<?php

/**
 * AppserverIo\Description\FactoryDescriptor
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

use AppserverIo\Lang\Reflection\ClassInterface;
use AppserverIo\Psr\Deployment\DescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Annotations\Inject;
use AppserverIo\Psr\EnterpriseBeans\EnterpriseBeansException;
use AppserverIo\Psr\EnterpriseBeans\Description\FactoryDescriptorInterface;
use AppserverIo\Description\Configuration\ConfigurationInterface;
use AppserverIo\Description\Configuration\FactoryConfigurationInterface;

/**
 * Implementation of a factory method descriptor.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class FactoryDescriptor extends AbstractNameAwareDescriptor implements FactoryDescriptorInterface
{

    /**
     * The default factory method.
     *
     * @var string
     */
    const DEFAULT_METHOD = 'factory';

    /**
     * The beans class name.
     *
     * @var string
     */
    protected $className;

    /**
     * The factory method that creates the bean.
     *
     * @var string
     */
    protected $method;

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
     * Sets the factory method that creates the bean.
     *
     * @param string $method The factory method
     *
     * @return void
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Returns the factory method that creates the bean.
     *
     * @return string The factory factory
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\FactoryDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new FactoryDescriptor();
    }

    /**
     * Returns a new annotation instance for the passed reflection class.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the bean configuration
     *
     * @return \AppserverIo\Lang\Reflection\AnnotationInterface The reflection annotation
     */
    protected function newAnnotationInstance(ClassInterface $reflectionClass)
    {
        return $reflectionClass->getAnnotation(Inject::ANNOTATION);
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

        // query if we've an enterprise bean with a @Factory annotation
        if ($reflectionClass->hasAnnotation(Inject::ANNOTATION) === false) {
            // if not, do nothing
            return;
        }

        // create a new annotation instance
        $reflectionAnnotation = $this->newAnnotationInstance($reflectionClass);

        // initialize the annotation instance
        /** @var \AppserverIo\Psr\EnterpriseBeans\Annotations\Factory $annotationInstance */
        $annotationInstance = $reflectionAnnotation->newInstance(
            $reflectionAnnotation->getAnnotationName(),
            $reflectionAnnotation->getValues()
        );

        // load the factory name to register in naming directory
        if ($name = $annotationInstance->getFactory()) {
            $this->setName(DescriptorUtil::trim($name));
        } else {
            return;
        }

        // load the class name to register in naming directory
        if ($className = $annotationInstance->getFactoryType()) {
            $this->setClassName(DescriptorUtil::trim($className));
        }

        // load the factory method or set the default factory method
        if ($method = $annotationInstance->getFactoryMethod()) {
            $this->setMethod(DescriptorUtil::trim($method));
        } else {
            $this->setMethod(FactoryDescriptor::DEFAULT_METHOD);
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
        if (!$configuration instanceof FactoryConfigurationInterface) {
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

        // query for the factory and set it
        if ($method = (string) $configuration->getMethod()) {
            $this->setMethod(DescriptorUtil::trim($method));
        }

        // return the instance
        return $this;
    }

    /**
     * Merges the passed configuration into this one. Configuration values
     * of the passed configuration will overwrite the this one.
     *
     * @param \AppserverIo\Psr\Deployment\DescriptorInterface $factoryDescriptor The configuration to merge
     *
     * @return void
     */
    public function merge(DescriptorInterface $factoryDescriptor)
    {

        // check if the classes are equal
        if ($this->getName() !== $factoryDescriptor->getName()) {
            throw new EnterpriseBeansException(
                sprintf('You try to merge a bean configuration for "%s" with "%s"', $factoryDescriptor->getName(), $this->getName())
            );
        }

        // merge the class name
        if ($className = $factoryDescriptor->getClassName()) {
            $this->setClassName($className);
        }

        // merge the method
        if ($method = $factoryDescriptor->getMethod()) {
            $this->setMethod($method);
        }
    }
}
