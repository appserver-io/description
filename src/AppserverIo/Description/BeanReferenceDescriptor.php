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
use AppserverIo\Psr\Deployment\DescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Annotations\Inject;
use AppserverIo\Psr\EnterpriseBeans\Description\BeanReferenceDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface;

/**
 * Utility class that stores a bean reference configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class BeanReferenceDescriptor implements BeanReferenceDescriptorInterface, DescriptorInterface
{

    /**
     * Prefix for resource references.
     *
     * @var string
     */
    const REF_DIRECTORY = 'env';

    /**
     * The reference name.
     *
     * @var string
     */
    protected $name;

    /**
     * The class type.
     *
     * @var string
     */
    protected $type;

    /**
     * The class description.
     *
     * @var string
     */
    protected $description;

    /**
     * Sets the reference name.
     *
     * @param string $name The reference name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the reference name.
     *
     * @return string The reference name
     */
    public function getName()
    {
        return $this->name;
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
     * Sets the class description.
     *
     * @param string $description The class description
     *
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the class description.
     *
     * @return string The class description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the injection target specification.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface $injectionTarget The injection target specification
     *
     * @return void
     */
    public function setInjectionTarget(InjectionTargetDescriptorInterface $injectionTarget)
    {
        $this->injectionTarget = $injectionTarget;
    }

    /**
     * Returns the injection target specification.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface The injection target specification
     */
    public function getInjectionTarget()
    {
        return $this->injectionTarget;
    }

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\BeanReferenceDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new BeanReferenceDescriptor();
    }

    /**
     * Creates and initializes a beans reference configuration instance from the passed
     * reflection class instance.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the beans reference configuration
     *
     * @return \AppserverIo\Psr\Di\Description\BeanReferenceDescriptorInterface|null The initialized descriptor instance
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
     * @return \AppserverIo\Psr\Di\Description\ClassDescriptorInterface|null The initialized descriptor instance
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
            $this->setName(sprintf('%s/%s', BeanReferenceDescriptor::REF_DIRECTORY, $name));
        } else {
            $this->setName(sprintf('%s/%s', BeanReferenceDescriptor::REF_DIRECTORY, ucfirst($reflectionProperty->getPropertyName())));
        }

        // load the class type defined as @Inject(type=****)
        if ($type = $annotationInstance->getType()) {
            $this->setType($type);
        } else {
            $this->setType(ucfirst($reflectionProperty->getPropertyName()));
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
            $this->setName(sprintf('%s/%s', BeanReferenceDescriptor::REF_DIRECTORY, $name));
        } else {
            // use the name of the first parameter
            foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
                $this->setName(sprintf('%s/%s', BeanReferenceDescriptor::REF_DIRECTORY, ucfirst($reflectionParameter->getParameterName())));
                break;
            }
        }

        // load the class type defined as @Inject(type=****)
        if ($type = $annotationInstance->getType()) {
            $this->setType($type);
        } else {
            // use the name of the first parameter as local business interface
            foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
                $this->setType(ucfirst($reflectionParameter->getParameterName()));
                break;
            }
        }

        // load the class description defined as @Inject(description=****)
        if ($description = $annotationInstance->getDescription()) {
            $this->setDescription($description);
        }

        // load the injection target data
        $this->setInjectionTarget(InjectionTargetDescriptor::newDescriptorInstance()->fromReflectionMethod($reflectionMethod));

        // return the instance
        return $this;
    }

    /**
     * Creates and initializes a beans reference configuration instance from the passed
     * configuration node.
     *
     * @param \AppserverIo\Description\Configuration\BeanRefConfigurationInterface $configuration The configuration node with the class reference configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\BeanRefConfigurationInterface|null The initialized descriptor instance
     */
    public function fromConfiguration(BeanRefConfigurationInterface $configuration)
    {

        // query for the reference name
        if ($name = (string) $configuration->getBeanRefName()) {
            $this->setName(sprintf('%s/%s', BeanRefConfigurationInterface::REF_DIRECTORY, $name));
        }

        // query for the reference type
        if ($type = (string) $configuration->getBeanRefType()) {
            $this->setType($type);
        }

        // query for the description and set it
        if ($description = (string) $configuration->getDescription()) {
            $this->setDescription($description);
        }

        // query for the injection target
        if ($injectionTarget = $configuration->getInjectionTarget()) {
            $this->setInjectionTarget(InjectionTargetDescriptor::newDescriptorInstance()->fromConfiguration($injectionTarget));
        }

        // return the instance
        return $this;
    }

    /**
     * Merges the passed configuration into this one. Configuration values
     * of the passed configuration will overwrite the this one.
     *
     * @param \AppserverIo\Psr\Di\Description\BeanReferenceDescriptorInterface $beanReferenceDescriptor The configuration to merge
     *
     * @return void
     */
    public function merge(BeanReferenceDescriptorInterface $beanReferenceDescriptor)
    {

        // merge the reference name
        if ($name = $beanReferenceDescriptor->getName()) {
            $this->setName($name);
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
