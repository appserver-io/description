<?php

/**
 * AppserverIo\Description\DescriptorReferencesTrait
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
use AppserverIo\Description\Configuration\ReferencesConfigurationInterface;
use AppserverIo\Psr\Deployment\DescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\EpbReferenceDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\ResReferenceDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\BeanReferenceDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\PersistenceUnitReferenceDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\ReferenceDescriptorInterface;

/**
 * Trait with functionality to handle bean, resource and persistence unit references.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
trait DescriptorReferencesTrait
{

    /**
     * The array with the EPB references.
     *
     * @var array
     */
    protected $epbReferences = array();

    /**
     * The array with the resource references.
     *
     * @var array
     */
    protected $resReferences = array();

    /**
     * The array with the class references.
     *
     * @var array
     */
    protected $beanReferences = array();

    /**
     * The array with the persistence unit references.
     *
     * @var array
     */
    protected $persistenceUnitReferences = array();

    /**
     * Returns a unique identifier to add descriptors references that make sure that,
     * overriding a injection from a deployment descriptor will be taken into account.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\ReferenceDescriptorInterface $reference The reference to return the unique identifier for
     *
     * @return string The unique identifier
     */
    private function getUniqueRefIdentifier(ReferenceDescriptorInterface $reference)
    {

        // load the injection target itself
        $injectionTarget = $reference->getInjectionTarget();

        // load the property or the method name
        $target = $injectionTarget->getTargetProperty() ? $injectionTarget->getTargetProperty() : sprintf('%s()', $injectionTarget->getTargetMethod());

        // concatenate the descriptor name with the refernce signature to create a unique identifier
        return sprintf('%s::%s->%s', $reference->getName(), $injectionTarget->getTargetClass(), $target);
    }

    /**
     * Adds a EPB reference configuration.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\EpbReferenceDescriptorInterface $epbReference The EPB reference configuration
     *
     * @return void
     */
    public function addEpbReference(EpbReferenceDescriptorInterface $epbReference)
    {
        $this->epbReferences[$this->getUniqueRefIdentifier($epbReference)] = $epbReference;
    }

    /**
     * Sets the array with the EPB references.
     *
     * @param array $epbReferences The EPB references
     *
     * @return void
     */
    public function setEpbReferences(array $epbReferences)
    {
        $this->epbReferences = $epbReferences;
    }

    /**
     * The array with the EPB references.
     *
     * @return array The EPB references
     */
    public function getEpbReferences()
    {
        return $this->epbReferences;
    }

    /**
     * Adds a resource reference configuration.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\ResReferenceDescriptorInterface $resReference The resource reference configuration
     *
     * @return void
     */
    public function addResReference(ResReferenceDescriptorInterface $resReference)
    {
        $this->resReferences[$this->getUniqueRefIdentifier($resReference)] = $resReference;
    }

    /**
     * Sets the array with the resource references.
     *
     * @param array $resReferences The resource references
     *
     * @return void
     */
    public function setResReferences(array $resReferences)
    {
        $this->resReferences = $resReferences;
    }

    /**
     * The array with the resource references.
     *
     * @return array The resource references
     */
    public function getResReferences()
    {
        return $this->resReferences;
    }

    /**
     * Adds a bean reference configuration.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\BeanReferenceDescriptorInterface $beanReference The bean reference configuration
     *
     * @return void
     */
    public function addBeanReference(BeanReferenceDescriptorInterface $beanReference)
    {
        $this->beanReferences[$this->getUniqueRefIdentifier($beanReference)] = $beanReference;
    }

    /**
     * Sets the array with the bean references.
     *
     * @param array $beanReference The bean references
     *
     * @return void
     */
    public function setBeanReferences(array $beanReference)
    {
        $this->beanReferences = $beanReference;
    }

    /**
     * The array with the bean references.
     *
     * @return array The bean references
     */
    public function getBeanReferences()
    {
        return $this->beanReferences;
    }

    /**
     * Adds a persistence unit reference configuration.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\PersistenceUnitReferenceDescriptorInterface $persistenceUnitReference The persistence unit reference configuration
     *
     * @return void
     */
    public function addPersistenceUnitReference(PersistenceUnitReferenceDescriptorInterface $persistenceUnitReference)
    {
        $this->persistenceUnitReferences[$this->getUniqueRefIdentifier($persistenceUnitReference)] = $persistenceUnitReference;
    }

    /**
     * Sets the array with the persistence unit references.
     *
     * @param array $persistenceUnitReferences The persistence unit references
     *
     * @return void
     */
    public function setPersistenceUnitReferences(array $persistenceUnitReferences)
    {
        $this->persistenceUnitReferences = $persistenceUnitReferences;
    }

    /**
     * The array with the persistence unit references.
     *
     * @return array The persistence unit references
     */
    public function getPersistenceUnitReferences()
    {
        return $this->persistenceUnitReferences;
    }

    /**
     * Returns an array with the merge EBP, resource and persistence unit references.
     *
     * @return array The array with the merge all bean references
     */
    public function getReferences()
    {

        // initialize the references
        $references = array_merge(
            array_values($this->epbReferences),
            array_values($this->resReferences),
            array_values($this->beanReferences),
            array_values($this->persistenceUnitReferences)
        );

        // sort the references
        usort($references, function ($a, $b) {
            // load the positions
            $posA = $a->getPosition();
            $posB = $b->getPosition();

            // return 0 if positions are equal
            if ($posA  === $posB) {
                return 0;
            }

            // else return -1 or 1 depending on which position is higher
            return ($posA < $posB) ? -1 : 1;
        });

        // return the sorted references
        return $references;
    }

    /**
     * Initializes a bean configuration instance with the references of the passed configuration node.
     *
     * @param \AppserverIo\Description\Configuration\ReferencesConfigurationInterface $configuration The configuration node with the bean configuration
     *
     * @return void
     */
    public function referencesFromConfiguration(ReferencesConfigurationInterface $configuration)
    {

        // initialize the enterprise bean references
        foreach ($configuration->getEpbRefs() as $epbReference) {
            $this->addEpbReference(EpbReferenceDescriptor::newDescriptorInstance($this)->fromConfiguration($epbReference));
        }

        // initialize the resource references
        foreach ($configuration->getResRefs() as $resReference) {
            $this->addResReference(ResReferenceDescriptor::newDescriptorInstance($this)->fromConfiguration($resReference));
        }

        // initialize the bean references
        foreach ($configuration->getBeanRefs() as $beanReference) {
            $this->addBeanReference(BeanReferenceDescriptor::newDescriptorInstance($this)->fromConfiguration($beanReference));
        }

        // initialize the resource references
        foreach ($configuration->getPersistenceUnitRefs() as $persistenceUnitReference) {
            $this->addPersistenceUnitReference(PersistenceUnitReferenceDescriptor::newDescriptorInstance($this)->fromConfiguration($persistenceUnitReference));
        }
    }

    /**
     * Initializes the bean configuration instance with the references of the passed reflection class instance.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the bean configuration
     *
     * @return void
     */
    public function referencesFromReflectionClass(ClassInterface $reflectionClass)
    {

        // we've to check for property annotations that references EPB or resources
        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            // load the EPB references
            if ($epbReference = EpbReferenceDescriptor::newDescriptorInstance($this)->fromReflectionProperty($reflectionProperty)) {
                $this->addEpbReference($epbReference);
            }

            // load the resource references
            if ($resReference = ResReferenceDescriptor::newDescriptorInstance($this)->fromReflectionProperty($reflectionProperty)) {
                $this->addResReference($resReference);
            }

            // load the bean references
            if ($beanReference = BeanReferenceDescriptor::newDescriptorInstance($this)->fromReflectionProperty($reflectionProperty)) {
                $this->addBeanReference($beanReference);
            }

            // load the persistence unit references
            if ($persistenceUnitReference = PersistenceUnitReferenceDescriptor::newDescriptorInstance($this)->fromReflectionProperty($reflectionProperty)) {
                $this->addPersistenceUnitReference($persistenceUnitReference);
            }
        }

        // we've to check for method annotations that references EPB or resources
        foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
            // load the EPB references
            if ($epbReference = EpbReferenceDescriptor::newDescriptorInstance($this)->fromReflectionMethod($reflectionMethod)) {
                $this->addEpbReference($epbReference);
            }

            // load the resource references
            if ($resReference = ResReferenceDescriptor::newDescriptorInstance($this)->fromReflectionMethod($reflectionMethod)) {
                $this->addResReference($resReference);
            }

            // load the bean references
            if ($beanReference = BeanReferenceDescriptor::newDescriptorInstance($this)->fromReflectionMethod($reflectionMethod)) {
                $this->addBeanReference($beanReference);
            }

            // load the persistence unit references
            if ($persistenceUnitReference = PersistenceUnitReferenceDescriptor::newDescriptorInstance($this)->fromReflectionMethod($reflectionMethod)) {
                $this->addPersistenceUnitReference($persistenceUnitReference);
            }
        }
    }

    /**
     * Merge the refrerences of the passed descriptor into the actual one.
     *
     * @param \AppserverIo\Psr\Deployment\DescriptorInterface $descriptor The descriptor to merge the references with
     *
     * @return void
     */
    public function mergeReferences(DescriptorInterface $descriptor)
    {

        // merge the bean references
        foreach ($descriptor->getBeanReferences() as $beanReference) {
            $this->addBeanReference($beanReference);
        }

        // merge the EPB references
        foreach ($descriptor->getEpbReferences() as $epbReference) {
            $this->addEpbReference($epbReference);
        }

        // merge the resource references
        foreach ($descriptor->getResReferences() as $resReference) {
            $this->addResReference($resReference);
        }

        // merge the persistence unit references
        foreach ($descriptor->getPersistenceUnitReferences() as $persistenceUnitReference) {
            $this->addPersistenceUnitReference($persistenceUnitReference);
        }
    }
}
