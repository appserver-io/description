<?php

/**
 * AppserverIo\Description\BeanDescriptor
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Description;

use AppserverIo\Lang\String;
use AppserverIo\Lang\Boolean;
use AppserverIo\Lang\Reflection\ClassInterface;
use AppserverIo\Description\Configuration\ConfigurationInterface;
use AppserverIo\Description\Configuration\BeanConfigurationInterface;
use AppserverIo\Psr\EnterpriseBeans\Annotations\Inject;
use AppserverIo\Psr\EnterpriseBeans\EnterpriseBeansException;
use AppserverIo\Psr\EnterpriseBeans\Description\BeanDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\FactoryDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\FactoryAwareDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\MethodInvocationDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\MethodInvocationAwareDescriptorInterface;

/**
 * Abstract class for all bean descriptors.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class BeanDescriptor extends AbstractNameAwareDescriptor implements BeanDescriptorInterface, FactoryAwareDescriptorInterface, MethodInvocationAwareDescriptorInterface
{

    /**
     * Trait with functionality to handle bean, resource and persistence unit references.
     *
     * @var AppserverIo\Description\DescriptorReferencesTrait
     */
    use DescriptorReferencesTrait;

    /**
     * The beans class name.
     *
     * @var string
     */
    protected $className;

    /**
     * The factory that creates the bean.
     *
     * @var \AppserverIo\Psr\EnterpriseBeans\Description\FactoryDescriptorInterface
     */
    protected $factory;

    /**
     * The method invocations that'll be invoked after the instance has been created.
     *
     * @var array
     */
    protected $methodInvocations = array();

    /**
     * Sets the beans class name.
     *
     * @param string $className The beans class name
     *
     * @return void
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * Returns the beans class name.
     *
     * @return string The beans class name
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Sets the factory that creates the bean.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\FactoryDescriptorInterface $factory The bean's factory
     *
     * @return void
     */
    public function setFactory(FactoryDescriptorInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Returns the factory that creates the bean.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\FactoryDescriptorInterface The bean's factory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Add's the passed method invaction to the method invocations that'll be invoked when the
     * instance has been created.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\MethodInvocationDescriptorInterface $methodInvocation The method descriptor to add
     *
     * @return void
     */
    public function addMethodInvocation(MethodInvocationDescriptorInterface $methodInvocation)
    {
        $this->methodInvocations[] = $methodInvocation;
    }

    /**
     * Returns the array with the methods that'll be invoked when the
     * instance has been created.
     *
     * @return array The array with the methods descriptors
     */
    public function getMethodInvocations()
    {
        return $this->methodInvocations;
    }

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\BeanDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new BeanDescriptor();
    }

    /**
     * Return's the annoation class name.
     *
     * @return string The annotation class name
     */
    protected function getAnnotationClass()
    {
        return Inject::class;
    }

    /**
     * Initializes the bean descriptor instance from the passed reflection class instance.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the servlet description
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\BeanDescriptorInterface|null The initialized descriptor instance
     */
    public function fromReflectionClass(ClassInterface $reflectionClass)
    {

        // create a new annotation instance
        $annotationInstance = $this->getClassAnnotation($reflectionClass, $this->getAnnotationClass());

        // query if we've an enterprise bean with the requested annotation
        if ($annotationInstance === null) {
            // if not, do nothing
            return;
        }

        // load the default name to register in naming directory
        if ($name = $annotationInstance->getName()) {
            $this->setName(DescriptorUtil::trim($name));
        } else {
            // if @Annotation(name=****) is NOT set, we use the short class name by default
            $this->setName($reflectionClass->getShortName());
        }

        // load class name
        $this->setClassName($reflectionClass->getName());

        // initialize the shared flag @Inject(shared=true)
        $this->setShared($annotationInstance->getShared());

        // initialize references from the passed reflection class
        $this->referencesFromReflectionClass($reflectionClass);

        // load the factory information from the reflection class
        if ($factory = FactoryDescriptor::newDescriptorInstance()->fromReflectionClass($reflectionClass)) {
            $this->setFactory($factory);
        }

        // return the instance
        return $this;
    }

    /**
     * Initializes a bean configuration instance from the passed configuration node.
     *
     * @param \AppserverIo\Description\Configuration\ConfigurationInterface $configuration The bean configuration
     *
     * @return void
     */
    public function fromConfiguration(ConfigurationInterface $configuration)
    {

        // query whether or not we've preference configuration
        if (!$configuration instanceof BeanConfigurationInterface) {
            return;
        }

        // query for the class name and set it
        if ($className = (string) $configuration->getClass()) {
            $this->setClassName(DescriptorUtil::trim($className));
        }

        // query for the name and set it
        if ($name = (string) $configuration->getName()) {
            $this->setName(DescriptorUtil::trim($name));
        }

        // merge the shared flag
        if ($shared = $configuration->getShared()) {
            $this->setShared(Boolean::valueOf(new String($shared))->booleanValue());
        }

        // initialize references from the passed deployment descriptor
        $this->referencesFromConfiguration($configuration);

        // load the factory information from the reflection class
        if ($factory = $configuration->getFactory()) {
            $this->setFactory(FactoryDescriptor::newDescriptorInstance()->fromConfiguration($factory));
        }

        // load the method invocations from the reflection class
        foreach ($configuration->getMethodInvocations() as $methodInvocation) {
            $this->addMethodInvocation(MethodInvocationDescriptor::newDescriptorInstance()->fromConfiguration($methodInvocation));
        }

        // return the instance
        return $this;
    }

    /**
     * Merges the passed configuration into this one. Configuration values
     * of the passed configuration will overwrite the this one.
     *
     * @param \AppserverIo\Psr\Deployment\DescriptorInterface $beanDescriptor The configuration to merge
     *
     * @return void
     */
    public function merge(BeanDescriptorInterface $beanDescriptor)
    {

        // check if the classes are equal
        if ($this->getName() !== $beanDescriptor->getName()) {
            throw new EnterpriseBeansException(
                sprintf('You try to merge a bean configuration for "%s" with "%s"', $beanDescriptor->getName(), $this->getName())
            );
        }

        // merge the class name
        if ($className = $beanDescriptor->getClassName()) {
            $this->setClassName($className);
        }

        // merge the factory
        if ($factory = $beanDescriptor->getFactory()) {
            $this->setFactory($factory);
        }

        // merge the shared flag
        $this->setShared($beanDescriptor->isShared());

        // merge the references
        $this->mergeReferences($beanDescriptor);

        // merge the method invocations
        foreach ($beanDescriptor->getMethodInvocations() as $methodInvocation) {
            $this->addMethodInvocation($methodInvocation);
        }
    }
}
