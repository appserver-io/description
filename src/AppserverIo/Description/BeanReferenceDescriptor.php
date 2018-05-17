<?php

/**
 * AppserverIo\Description\BeanReferenceDescriptor
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
use AppserverIo\Description\Configuration\BeanRefConfigurationInterface;
use AppserverIo\Psr\EnterpriseBeans\Annotations\Inject;
use AppserverIo\Psr\EnterpriseBeans\Description\NameAwareDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\BeanReferenceDescriptorInterface;

/**
 * Utility class that stores a bean reference configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class BeanReferenceDescriptor extends AbstractReferenceDescriptor implements BeanReferenceDescriptorInterface
{

    /**
     * The configurable bean name.
     *
     * @var string
     */
    protected $beanName;

    /**
     * The class type.
     *
     * @var string
     */
    protected $type;

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
     * Sets the class type.
     *
     * @param string $type The class type
     *
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns the class type.
     *
     * @return string The class type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns a new descriptor instance.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\NameAwareDescriptorInterface $parent The parent descriptor instance
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\EpbReferenceDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance(NameAwareDescriptorInterface $parent)
    {
        return new BeanReferenceDescriptor($parent);
    }

    /**
     * Creates and initializes a beans reference configuration instance from the passed
     * reflection class instance.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the beans reference configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\BeanReferenceDescriptorInterface|null The initialized descriptor instance
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
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\BeanReferenceDescriptorInterface|null The initialized descriptor instance
     */
    public function fromReflectionProperty(PropertyInterface $reflectionProperty)
    {

        // if we found a @Inject annotation, load the annotation instance
        if ($reflectionProperty->hasAnnotation(Inject::ANNOTATION) === false) {
            // if not, do nothing
            return;
        }

        // initialize the annotation instance
        $annotation = $reflectionProperty->getAnnotation(Inject::ANNOTATION);

        // load the annotation instance
        $annotationInstance = $annotation->newInstance($annotation->getAnnotationName(), $annotation->getValues());

        // load the reference name defined as @Inject(name=****)
        if ($name = $annotationInstance->getName()) {
            $this->setName($name);
        } else {
            $this->setName(ucfirst($reflectionProperty->getPropertyName()));
        }

        // register the bean with the name defined as @Inject(beanName=****)
        if ($beanNameAttribute = $annotationInstance->getBeanName()) {
            $this->setBeanName($beanNameAttribute);
        } else {
            $this->setBeanName(ucfirst($this->getName()));
        }

        // load the class type defined as @Inject(type=****)
        if ($type = $annotationInstance->getType()) {
            $this->setType($type);
        }

        // load the class description defined as @Inject(description=****)
        if ($description = $annotationInstance->getDescription()) {
            $this->setDescription($description);
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

        // if we found a @Inject annotation, load the annotation instance
        if ($reflectionMethod->hasAnnotation(Inject::ANNOTATION) === false) {
            // if not, do nothing
            return;
        }

        // initialize the annotation instance
        $annotation = $reflectionMethod->getAnnotation(Inject::ANNOTATION);

        // load the annotation instance
        $annotationInstance = $annotation->newInstance($annotation->getAnnotationName(), $annotation->getValues());

        // load the reference name defined as @Inject(name=****)
        if ($name = $annotationInstance->getName()) {
            $this->setName($name);
        } else {
            // use the name of the first parameter
            foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
                $this->setName($name = ucfirst($reflectionParameter->getParameterName()));
                break;
            }
        }

        // register the bean with the name defined as @Inject(beanName=****)
        if ($beanNameAttribute = $annotationInstance->getBeanName()) {
            $this->setBeanName($beanNameAttribute);
        } else {
            $this->setBeanName(ucfirst($this->getName()));
        }

        // load the class type defined as @Inject(type=****)
        if ($type = $annotationInstance->getType()) {
            $this->setType($type);
        }

        // load the class description defined as @Inject(description=****)
        if ($description = $annotationInstance->getDescription()) {
            $this->setDescription($description);
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
     * @param \AppserverIo\Description\Configuration\BeanRefConfigurationInterface $configuration The configuration node with the class reference configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\BeanReferenceDescriptorInterface|null The initialized descriptor instance
     */
    public function fromConfiguration(BeanRefConfigurationInterface $configuration)
    {

        // query for the reference name
        if ($name = (string) $configuration->getBeanRefName()) {
            $this->setName($name);
        }

        // query for the bean name and set it
        if ($beanName = (string) $configuration->getBeanLink()) {
            $this->setBeanName($beanName);
        } else {
            $this->setBeanName($this->getName());
        }

        // query for the reference type
        if ($type = (string) $configuration->getBeanRefType()) {
            $this->setType($type);
        }

        // query for the description and set it
        if ($description = (string) $configuration->getDescription()) {
            $this->setDescription($description);
        }

        // query for the reference position
        if ($position = (integer) $configuration->getPosition()) {
            $this->setPosition($position);
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
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\BeanReferenceDescriptorInterface $beanReferenceDescriptor The configuration to merge
     *
     * @return void
     */
    public function merge(BeanReferenceDescriptorInterface $beanReferenceDescriptor)
    {

        // merge the reference name
        if ($name = $beanReferenceDescriptor->getName()) {
            $this->setName($name);
        }

        // merge the bean name
        if ($beanName = $beanReferenceDescriptor->getBeanName()) {
            $this->setBeanName($beanName);
        }

        // merge the reference type
        if ($type = $beanReferenceDescriptor->getType()) {
            $this->setType($type);
        }

        // merge the description
        if ($description = $beanReferenceDescriptor->getDescription()) {
            $this->setDescription($description);
        }

        // merge the injection target
        if ($injectionTarget = $beanReferenceDescriptor->getInjectionTarget()) {
            $this->setInjectionTarget($injectionTarget);
        }
    }
}
