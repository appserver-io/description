<?php

/**
 * AppserverIo\Description\PersistenceUnitReferenceDescriptor
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
use AppserverIo\Psr\EnterpriseBeans\Annotations\PersistenceUnit;
use AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\PersistenceUnitReferenceDescriptorInterface;

/**
 * Utility class that stores a persistence unit reference configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class PersistenceUnitReferenceDescriptor implements PersistenceUnitReferenceDescriptorInterface, DescriptorInterface
{

    /**
     * Prefix for resource references.
     *
     * @var string
     */
    const REF_DIRECTORY = 'env/persistence';

    /**
     * The reference name.
     *
     * @var string
     */
    protected $name;

    /**
     * The persistence unit name.
     *
     * @var string
     */
    protected $unitName;

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
     * Sets the persistence unit name.
     *
     * @param string $unitName The persistence unit name
     *
     * @return void
     */
    public function setUnitName($unitName)
    {
        $this->unitName = $unitName;
    }

    /**
     * Returns the persistence unit name.
     *
     * @return string The persistence unit name
     */
    public function getUnitName()
    {
        return $this->unitName;
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
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\PersistenceUnitReferenceDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new PersistenceUnitReferenceDescriptor();
    }

    /**
     * Creates and initializes a beans reference configuration instance from the passed
     * reflection class instance.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the beans reference configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\PersistenceUnitReferenceDescriptorInterface|null The initialized descriptor instance
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
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\PersistenceUnitReferenceDescriptorInterface|null The initialized descriptor instance
     */
    public function fromReflectionProperty(PropertyInterface $reflectionProperty)
    {

        // if we found a @PersistenceUnit annotation, load the annotation instance
        if ($reflectionProperty->hasAnnotation(PersistenceUnit::ANNOTATION) === false) {
            // if not, do nothing
            return;
        }

        // initialize the annotation instance
        $annotation = $reflectionProperty->getAnnotation(PersistenceUnit::ANNOTATION);

        // load the annotation instance
        $annotationInstance = $annotation->newInstance($annotation->getAnnotationName(), $annotation->getValues());

        // load the reference name defined as @PersistenceUnit(name=****)
        if ($name = $annotationInstance->getName()) {
            $this->setName(sprintf('%s/%s', PersistenceUnitReferenceDescriptor::REF_DIRECTORY, $name));
        } else {
            $this->setName(sprintf('%s/%s', PersistenceUnitReferenceDescriptor::REF_DIRECTORY, ucfirst($reflectionProperty->getPropertyName())));
        }

        // load the resource type defined as @PersistenceUnit(unitName=****)
        if ($unitName = $annotationInstance->getUnitName()) {
            $this->setUnitName($unitName);
        } else {
            $this->setUnitName(ucfirst($reflectionProperty->getPropertyName()));
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
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\PersistenceUnitReferenceDescriptorInterface|null The initialized descriptor instance
     */
    public function fromReflectionMethod(MethodInterface $reflectionMethod)
    {

        // if we found a @PersistenceUnit annotation, load the annotation instance
        if ($reflectionMethod->hasAnnotation(PersistenceUnit::ANNOTATION) === false) {
            // if not, do nothing
            return;
        }

        // initialize the annotation instance
        $annotation = $reflectionMethod->getAnnotation(PersistenceUnit::ANNOTATION);

        // load the annotation instance
        $annotationInstance = $annotation->newInstance($annotation->getAnnotationName(), $annotation->getValues());

        // load the reference name defined as @PersistenceUnit(name=****)
        if ($name = $annotationInstance->getName()) {
            $this->setName(sprintf('%s/%s', PersistenceUnitReferenceDescriptor::REF_DIRECTORY, $name));
        } else {
            // use the name of the first parameter
            foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
                $this->setName(sprintf('%s/%s', PersistenceUnitReferenceDescriptor::REF_DIRECTORY, ucfirst($reflectionParameter->getParameterName())));
                break;
            }
        }

        // load the resource type defined as @PersistenceUnit(unitName=****)
        if ($unitName = $annotationInstance->getUnitName()) {
            $this->setUnitName($unitName);
        } else {
            // use the name of the first parameter unit name
            foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
                $this->setUnitName(ucfirst($reflectionParameter->getParameterName()));
                break;
            }
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
        if ($node->getName() !== 'persistence-unit-ref') {
            // if not, do nothing
            return;
        }

        // query for the reference name
        if ($name = (string) $node->{'persistence-unit-ref-name'}) {
            $this->setName(sprintf('%s/%s', PersistenceUnitReferenceDescriptor::REF_DIRECTORY, $name));
        }

        // query for the reference type
        if ($unitName = (string) $node->{'persistence-unit-name'}) {
            $this->setUnitName($unitName);
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
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\PersistenceUnitReferenceDescriptorInterface $persistenceUnitReferenceDescriptor The configuration to merge
     *
     * @return void
     */
    public function merge(PersistenceUnitReferenceDescriptorInterface $persistenceUnitReferenceDescriptor)
    {

        // merge the reference name
        if ($name = $persistenceUnitReferenceDescriptor->getName()) {
            $this->setName($name);
        }

        // merge the persistence unit name
        if ($unitName = $persistenceUnitReferenceDescriptor->getUnitName()) {
            $this->setUnitName($unitName);
        }

        // merge the injection target
        if ($injectionTarget = $persistenceUnitReferenceDescriptor->getInjectionTarget()) {
            $this->setInjectionTarget($injectionTarget);
        }
    }
}
