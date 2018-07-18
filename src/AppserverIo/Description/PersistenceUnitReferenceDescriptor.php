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
use AppserverIo\Description\Configuration\PersistenceUnitRefConfigurationInterface;
use AppserverIo\Psr\EnterpriseBeans\Annotations\PersistenceUnit;
use AppserverIo\Psr\EnterpriseBeans\Description\NameAwareDescriptorInterface;
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
class PersistenceUnitReferenceDescriptor extends AbstractReferenceDescriptor implements PersistenceUnitReferenceDescriptorInterface
{

    /**
     * The persistence unit name.
     *
     * @var string
     */
    protected $unitName;

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
     * Returns a new descriptor instance.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\NameAwareDescriptorInterface $parent The parent descriptor instance
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\EpbReferenceDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance(NameAwareDescriptorInterface $parent)
    {
        return new PersistenceUnitReferenceDescriptor($parent);
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

        // create a new annotation instance
        $annotationInstance = $this->getPropertyAnnotation($reflectionProperty, PersistenceUnit::class);

        // if we found a @PersistenceUnit annotation, load the annotation instance
        if ($annotationInstance === null) {
            // if not, do nothing
            return;
        }

        // load the reference name defined as @PersistenceUnit(name=****)
        if ($name = $annotationInstance->getName()) {
            $this->setName($name);
        } else {
            $this->setName(ucfirst($reflectionProperty->getPropertyName()));
        }

        // load the resource type defined as @PersistenceUnit(unitName=****)
        if ($unitName = $annotationInstance->getUnitName()) {
            $this->setUnitName($unitName);
        } else {
            $this->setUnitName(ucfirst($reflectionProperty->getPropertyName()));
        }

        // load the injection target data
        if ($injectionTarget = InjectionTargetDescriptor::newDescriptorInstance()->fromReflectionProperty($reflectionProperty)) {
            $this->setInjectionTarget($injectionTarget);
        }

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

        // load the annotation instance
        $annotationInstance = $this->getMethodAnnotation($reflectionMethod, PersistenceUnit::class);

        // if we found a @PersistenceUnit annotation, load the annotation instance
        if ($annotationInstance === null) {
            // if not, do nothing
            return;
        }

        // load the reference name defined as @PersistenceUnit(name=****)
        if ($name = $annotationInstance->getName()) {
            $this->setName($name);
        } else {
            // use the name of the first parameter
            foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
                $this->setName($name = ucfirst($reflectionParameter->getParameterName()));
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
     * @param \AppserverIo\Description\Configuration\PersistenceUnitRefConfigurationInterface $configuration The configuration node with the beans reference configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\EpbReferenceDescriptorInterface|null The initialized descriptor instance
     */
    public function fromConfiguration(PersistenceUnitRefConfigurationInterface $configuration)
    {

        // query for the reference name
        if ($name = (string) $configuration->getPersistenceUnitRefName()) {
            $this->setName($name);
        }

        // query for the reference type
        if ($unitName = (string) $configuration->getPersistenceUnitName()) {
            $this->setUnitName($unitName);
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
