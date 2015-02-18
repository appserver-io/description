<?php

/**
 * AppserverIo\Description\ResReferenceDescriptor
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
use AppserverIo\Psr\EnterpriseBeans\Annotations\Resource;
use AppserverIo\Psr\EnterpriseBeans\Description\ResReferenceDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface;

/**
 * Utility class that stores a resource reference configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class ResReferenceDescriptor implements ResReferenceDescriptorInterface, DescriptorInterface
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
     * The resource type.
     *
     * @var string
     */
    protected $type;

    /**
     * The lookup name.
     *
     * @var string
     */
    protected $lookup;

    /**
     * The resource description.
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
     * Sets the resource type.
     *
     * @param string $type The resource type
     *
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns the resource type.
     *
     * @return string The resource type
     */
    public function getType()
    {
        return $this->type;
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
     * Sets the resource description.
     *
     * @param string $description The resource description
     *
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the resource description.
     *
     * @return string The resource description
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
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\ResReferenceDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new ResReferenceDescriptor();
    }

    /**
     * Creates and initializes a beans reference configuration instance from the passed
     * reflection class instance.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the beans reference configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\ResReferenceDescriptorInterface|null The initialized descriptor instance
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
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\ResReferenceDescriptorInterface|null The initialized descriptor instance
     */
    public function fromReflectionProperty(PropertyInterface $reflectionProperty)
    {

        // if we found a @Resource annotation, load the annotation instance
        if ($reflectionProperty->hasAnnotation(Resource::ANNOTATION) === false) {
            // if not, do nothing
            return;
        }

        // initialize the annotation instance
        $annotation = $reflectionProperty->getAnnotation(Resource::ANNOTATION);

        // load the annotation instance
        $annotationInstance = $annotation->newInstance($annotation->getAnnotationName(), $annotation->getValues());

        // load the reference name defined as @Resource(name=****)
        if ($name = $annotationInstance->getName()) {
            $this->setName(sprintf('%s/%s', ResReferenceDescriptor::REF_DIRECTORY, $name));
        } else {
            $this->setName(sprintf('%s/%s', ResReferenceDescriptor::REF_DIRECTORY, ucfirst($reflectionProperty->getPropertyName())));
        }

        // load the resource type defined as @Resource(type=****)
        if ($type = $annotationInstance->getType()) {
            $this->setType($type);
        } else {
            $this->setType(ucfirst($reflectionProperty->getPropertyName()));
        }

        // load the lookup defined as @Resource(lookup=****)
        if ($lookup = $annotationInstance->getLookup()) {
            $this->setLookup($lookup);
        }

        // load the resource description defined as @Resource(description=****)
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

        // if we found a @Resource annotation, load the annotation instance
        if ($reflectionMethod->hasAnnotation(Resource::ANNOTATION) === false) {
            // if not, do nothing
            return;
        }

        // initialize the annotation instance
        $annotation = $reflectionMethod->getAnnotation(Resource::ANNOTATION);

        // load the annotation instance
        $annotationInstance = $annotation->newInstance($annotation->getAnnotationName(), $annotation->getValues());

        // load the reference name defined as @Resource(name=****)
        if ($name = $annotationInstance->getName()) {
            $this->setName(sprintf('%s/%s', ResReferenceDescriptor::REF_DIRECTORY, $name));
        } else {
            // use the name of the first parameter
            foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
                $this->setName(sprintf('%s/%s', ResReferenceDescriptor::REF_DIRECTORY, ucfirst($reflectionParameter->getParameterName())));
                break;
            }
        }

        // load the resource type defined as @Resource(type=****)
        if ($type = $annotationInstance->getType()) {
            $this->setType($type);
        } else {
            // use the name of the first parameter as local business interface
            foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
                $this->setType(ucfirst($reflectionParameter->getParameterName()));
                break;
            }
        }

        // load the lookup defined as @Resource(lookup=****)
        if ($lookup = $annotationInstance->getLookup()) {
            $this->setLookup($lookup);
        }

        // load the resource description defined as @Resource(description=****)
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
     * deployment node.
     *
     * @param \SimpleXmlElement $node The deployment node with the beans reference configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\EpbReferenceDescriptorInterface|null The initialized descriptor instance
     */
    public function fromDeploymentDescriptor(\SimpleXmlElement $node)
    {

        // query if we've a <res-ref> descriptor node
        if ($node->getName() !== 'res-ref') {
            // if not, do nothing
            return;
        }

        // query for the reference name
        if ($name = (string) $node->{'res-ref-name'}) {
            $this->setName(sprintf('%s/%s', ResReferenceDescriptor::REF_DIRECTORY, $name));
        }

        // query for the reference type
        if ($type = (string) $node->{'res-ref-type'}) {
            $this->setType($type);
        }

        // query for the description and set it
        if ($description = (string) $node->{'description'}) {
            $this->setDescription($description);
        }

        // query for the lookup name and set it
        if ($lookup = (string) $node->{'lookup-name'}) {
            $this->setLookup($lookup);
        }

        // query for the injection target
        if ($injectionTarget = $node->{'injection-target'}) {
            $this->setInjectionTarget(InjectionTargetDescriptor::newDescriptorInstance()->fromDeploymentDescriptor($injectionTarget));
        }

        // return the instance
        return $this;
    }

    /**
     * Merges the passed configuration into this one. Configuration values
     * of the passed configuration will overwrite the this one.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\ResReferenceDescriptorInterface $resReferenceDescriptor The configuration to merge
     *
     * @return void
     */
    public function merge(ResReferenceDescriptorInterface $resReferenceDescriptor)
    {

        // merge the reference name
        if ($name = $resReferenceDescriptor->getName()) {
            $this->setName($name);
        }

        // merge the reference type
        if ($type = $resReferenceDescriptor->getType()) {
            $this->setType($type);
        }

        // merge the lookup name
        if ($lookup = $resReferenceDescriptor->getLookup()) {
            $this->setLookup($lookup);
        }

        // merge the description
        if ($description = $resReferenceDescriptor->getDescription()) {
            $this->setDescription($description);
        }

        // merge the injection target
        if ($injectionTarget = $resReferenceDescriptor->getInjectionTarget()) {
            $this->setInjectionTarget($injectionTarget);
        }
    }
}
