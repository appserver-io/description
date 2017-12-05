<?php

/**
 * AppserverIo\Description\EpbReferenceDescriptor
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
use AppserverIo\Lang\Reflection\MethodInterface;
use AppserverIo\Lang\Reflection\PropertyInterface;
use AppserverIo\Description\Configuration\EpbRefConfigurationInterface;
use AppserverIo\Psr\EnterpriseBeans\Annotations\EnterpriseBean;
use AppserverIo\Psr\EnterpriseBeans\Description\EpbReferenceDescriptorInterface;

/**
 * Utility class that stores a beans reference configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class EpbReferenceDescriptor extends AbstractReferenceDescriptor implements EpbReferenceDescriptorInterface
{

    /**
     * The configurable bean name.
     *
     * @var string
     */
    protected $beanName;

    /**
     * The bean interface.
     *
     * @var string
     */
    protected $beanInterface;

    /**
     * The lookup name.
     *
     * @var string
     */
    protected $lookup;

    /**
     * Sets the configurable bean name.
     *
     * @param string $beanName The configurable bean name
     *
     * @return void
     */
    public function setBeanName($beanName)
    {
        $this->beanName = $beanName;
    }

    /**
     * Returns the configurable bean name.
     *
     * @return string The configurable bean name
     */
    public function getBeanName()
    {
        return $this->beanName;
    }

    /**
     * Sets the bean interface.
     *
     * @param string $beanInterface The bean interface
     *
     * @return void
     */
    public function setBeanInterface($beanInterface)
    {
        $this->beanInterface = $beanInterface;
    }

    /**
     * Returns the bean interface.
     *
     * @return string The bean interface
     */
    public function getBeanInterface()
    {
        return $this->beanInterface;
    }

    /**
     * Sets the lookup name.
     *
     * @param string $lookup The lookup name
     *
     * @return void
     */
    public function setLookup($lookup)
    {
        $this->lookup = $lookup;
    }

    /**
     * Returns the lookup name.
     *
     * @return string The lookup name
     */
    public function getLookup()
    {
        return $this->lookup;
    }

    /**
     * Returns a new descriptor instance.
     *
     * @param \AppserverIo\Description\NameAwareDescriptorInterface $parent The parent descriptor instance
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\EpbReferenceDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance(NameAwareDescriptorInterface $parent)
    {
        return new EpbReferenceDescriptor($parent);
    }

    /**
     * Creates and initializes a beans reference configuration instance from the passed
     * reflection class instance.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the beans reference configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\EpbReferenceDescriptorInterface|null The initialized descriptor instance
     *
     * @throws \Exception
     */
    public function fromReflectionClass(ClassInterface $reflectionClass)
    {
        throw new \Exception(__METHOD__ . ' not implemented yet');
    }

    /**
     * Creates and initializes a beans reference configuration instance from the passed
     * reflection property instance.
     *
     * @param \AppserverIo\Lang\Reflection\PropertyInterface $reflectionProperty The reflection property with the beans reference configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\EpbReferenceDescriptorInterface|null The initialized descriptor instance
     */
    public function fromReflectionProperty(PropertyInterface $reflectionProperty)
    {

        // if we found a @EnterpriseBean annotation, load the annotation instance
        if ($reflectionProperty->hasAnnotation(EnterpriseBean::ANNOTATION) === false) {
            // if not, do nothing
            return;
        }

        // initialize the annotation instance
        $annotation = $reflectionProperty->getAnnotation(EnterpriseBean::ANNOTATION);

        // load the annotation instance
        $annotationInstance = $annotation->newInstance($annotation->getAnnotationName(), $annotation->getValues());

        // load the reference name defined as @EnterpriseBean(name=****)
        if ($name = $annotationInstance->getName()) {
            $this->setName($name);
        } else {
            // use the property name
            $this->setName(ucfirst($reflectionProperty->getPropertyName()));
        }

        // register the bean with the name defined as @EnterpriseBean(beanName=****)
        if ($beanNameAttribute = $annotationInstance->getBeanName()) {
            $this->setBeanName($beanNameAttribute);
        } else {
            $this->setBeanName(ucfirst($this->getName()));
        }

        // register the bean with the interface defined as @EnterpriseBean(beanInterface=****)
        if ($beanInterfaceAttribute = $annotationInstance->getBeanInterface()) {
            $this->setBeanInterface($beanInterfaceAttribute);
        } else {
            // use the property name as local business interface
            $this->setBeanInterface(sprintf('%sLocal', ucfirst($this->getBeanName())));
        }

        // register the bean with the lookup name defined as @EnterpriseBean(lookup=****)
        if ($lookupAttribute = $annotationInstance->getLookup()) {
            $this->setLookup($lookupAttribute);
        }

        // register the bean with the interface defined as @EnterpriseBean(description=****)
        if ($descriptionAttribute = $annotationInstance->getDescription()) {
            $this->setDescription($descriptionAttribute);
        }

        // load the injection target data
        $this->setInjectionTarget(InjectionTargetDescriptor::newDescriptorInstance()->fromReflectionProperty($reflectionProperty));

        // return the instance
        return $this;
    }

    /**
     * Creates and initializes a beans reference configuration instance from the passed
     * reflection method instance.
     *
     * @param \AppserverIo\Lang\Reflection\MethodInterface $reflectionMethod The reflection method with the beans reference configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\EpbReferenceDescriptorInterface|null The initialized descriptor instance
     */
    public function fromReflectionMethod(MethodInterface $reflectionMethod)
    {

        // if we found a @EnterpriseBean annotation, load the annotation instance
        if ($reflectionMethod->hasAnnotation(EnterpriseBean::ANNOTATION) === false) {
            // if not, do nothing
            return;
        }

        // initialize the annotation instance
        $annotation = $reflectionMethod->getAnnotation(EnterpriseBean::ANNOTATION);

        // load the annotation instance
        $annotationInstance = $annotation->newInstance($annotation->getAnnotationName(), $annotation->getValues());

        // load the reference name defined as @EnterpriseBean(name=****)
        if ($name = $annotationInstance->getName()) {
            $this->setName($name);
        } else {
            // use the name of the first parameter as local business interface
            foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
                $this->setName($name = ucfirst($reflectionParameter->getParameterName()));
                break;
            }
        }

        // register the bean with the name defined as @EnterpriseBean(beanName=****)
        if ($beanNameAttribute = $annotationInstance->getBeanName()) {
            $this->setBeanName($beanNameAttribute);
        } else {
            $this->setBeanName(ucfirst($this->getName()));
        }

        // register the bean with the interface defined as @EnterpriseBean(beanInterface=****)
        if ($beanInterfaceAttribute = $annotationInstance->getBeanInterface()) {
            $this->setBeanInterface($beanInterfaceAttribute);
        } else {
            $this->setBeanInterface(sprintf('%sLocal', ucfirst($this->getBeanName())));
        }

        // register the bean with the lookup name defined as @EnterpriseBean(lookup=****)
        if ($lookupAttribute = $annotationInstance->getLookup()) {
            $this->setLookup($lookupAttribute);
        }

        // register the bean with the interface defined as @EnterpriseBean(description=****)
        if ($descriptionAttribute = $annotationInstance->getDescription()) {
            $this->setDescription($descriptionAttribute);
        }

        // load the injection target data
        if ($injectionTarget = InjectionTargetDescriptor::newDescriptorInstance()->fromReflectionMethod($reflectionMethod)) {
            $this->setInjectionTarget($injectionTarget);
        } else {
            // initialize a default injection target, which is the constructor
            // and assume that the parameter name equals the reference name
            $injectionTarget = InjectionTargetDescriptor::newDescriptorInstance();
            $injectionTarget->setTargetMethod('__construct');
            $injectionTarget->setTargetMethodParameterName(lcfirst($name));

            // set the default injection target
            $this->setInjectionTarget($injectionTarget);
        }

        // return the instance
        return $this;
    }

    /**
     * Creates and initializes a beans reference configuration instance from the passed
     * configuration node.
     *
     * @param \AppserverIo\Configuration\Interfaces\NodeInterface $configuration The configuration node with the beans reference configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\EpbReferenceDescriptorInterface|null The initialized descriptor instance
     */
    public function fromConfiguration(EpbRefConfigurationInterface $configuration)
    {

        // query for the reference name
        if ($name = (string) $configuration->getEpbRefName()) {
            $this->setName($name);
        }

        // query for the bean name and set it
        if ($beanName = (string) $configuration->getEpbLink()) {
            $this->setBeanName($beanName);
        }

        // query for the lookup name and set it
        if ($lookup = (string) $configuration->getLookupName()) {
            $this->setLookup($lookup);
        }

        // query for the bean interface and set it
        if ($beanInterface = (string) $configuration->getLocal()) {
            $this->setBeanInterface($beanInterface);
        } elseif ($beanInterface = (string) $configuration->getRemote()) {
            $this->setBeanInterface($beanInterface);
        } else {
            // use the bean name as local interface
            $this->setBeanInterface(sprintf('%sLocal', str_replace('Bean', '', $this->getBeanName())));
        }

        // query for the description and set it
        if ($description = (string) $configuration->getDescription()) {
            $this->setDescription($description);
        }

        // load the injection target data
        if ($injectionTarget = $configuration->getInjectionTarget()) {
            $this->setInjectionTarget(InjectionTargetDescriptor::newDescriptorInstance()->fromConfiguration($injectionTarget));
        } else {
            // initialize a default injection target, which is the constructor
            // and assume that the parameter name equals the reference name
            $injectionTarget = InjectionTargetDescriptor::newDescriptorInstance();
            $injectionTarget->setTargetMethod('__construct');
            $injectionTarget->setTargetMethodParameterName(lcfirst($name));

            // set the default injection target
            $this->setInjectionTarget($injectionTarget);
        }

        // return the instance
        return $this;
    }

    /**
     * Merges the passed configuration into this one. Configuration values
     * of the passed configuration will overwrite the this one.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\EpbReferenceDescriptorInterface $epbReferenceDescriptor The configuration to merge
     *
     * @return void
     */
    public function merge(EpbReferenceDescriptorInterface $epbReferenceDescriptor)
    {

        // merge the reference name
        if ($name = $epbReferenceDescriptor->getName()) {
            $this->setName($name);
        }

        // merge the bean interface
        if ($beanInterface = $epbReferenceDescriptor->getBeanInterface()) {
            $this->setBeanInterface($beanInterface);
        }

        // merge the bean name
        if ($beanName = $epbReferenceDescriptor->getBeanName()) {
            $this->setBeanName($beanName);
        }

        // merge the lookup name
        if ($lookup = $epbReferenceDescriptor->getLookup()) {
            $this->setLookup($lookup);
        }

        // merge the description
        if ($description = $epbReferenceDescriptor->getDescription()) {
            $this->setDescription($description);
        }

        // merge the injection target
        if ($injectionTarget = $epbReferenceDescriptor->getInjectionTarget()) {
            $this->setInjectionTarget($injectionTarget);
        }
    }
}
