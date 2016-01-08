<?php

/**
 * AppserverIo\Description\InjectionTargetDescriptor
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
use AppserverIo\Configuration\Interfaces\NodeInterface;
use AppserverIo\Psr\Deployment\DescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface;

/**
 * Utility class that stores a beans injection target configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class InjectionTargetDescriptor implements InjectionTargetDescriptorInterface, DescriptorInterface
{

    /**
     * The target class we want to inject to.
     *
     * @var string
     */
    protected $targetClass;

    /**
     * The target property name we want to inject to.
     *
     * @var string
     */
    protected $targetProperty;

    /**
     * The target method name we want use for injection.
     *
     * @var string
     */
    protected $targetMethod;

    /**
     * Sets the target class we want to inject to.
     *
     * @param string $targetClass The target class we want to inject to
     *
     * @return void
     */
    public function setTargetClass($targetClass)
    {
        $this->targetClass = $targetClass;
    }

    /**
     * Returns the target class we want to inject to.
     *
     * @return string The target class we want to inject to
     */
    public function getTargetClass()
    {
        return $this->targetClass;
    }

    /**
     * Sets the target property name we want to inject to.
     *
     * @param string $targetProperty The target property name we want to inject to
     *
     * @return void
     */
    public function setTargetProperty($targetProperty)
    {
        $this->targetProperty = $targetProperty;
    }

    /**
     * Returns the target property name we want to inject to.
     *
     * @return string The target property name we want to inject to
     */
    public function getTargetProperty()
    {
        return $this->targetProperty;
    }

    /**
     * Sets the target method we want to use for injection.
     *
     * @param string $targetMethod The target method used for injection
     *
     * @return void
     */
    public function setTargetMethod($targetMethod)
    {
        $this->targetMethod = $targetMethod;
    }

    /**
     * Returns the target method we want use for injection.
     *
     * @return string The target method used for injection
     */
    public function getTargetMethod()
    {
        return $this->targetMethod;
    }

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new InjectionTargetDescriptor();
    }

    /**
     * Creates and initializes a beans injection target configuration instance from the passed
     * reflection class.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the beans injection target configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface|null The initialized descriptor instance
     */
    public function fromReflectionClass(ClassInterface $reflectionClass)
    {
        throw new \Exception(__METHOD__ . ' not implemented yet');
    }

    /**
     * Creates and initializes a beans injection target configuration instance from the passed
     * reflection property instance.
     *
     * @param \AppserverIo\Lang\Reflection\PropertyInterface $reflectionProperty The reflection property with the beans injection target configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface|null The initialized descriptor instance
     */
    public function fromReflectionProperty(PropertyInterface $reflectionProperty)
    {
        // initialize the injection target from the passed property
        $this->setTargetClass($reflectionProperty->getClassName());
        $this->setTargetProperty($reflectionProperty->getPropertyName());

        // return the instance
        return $this;
    }

    /**
     * Creates and initializes a beans injection target configuration instance from the passed
     * reflection method instance.
     *
     * @param \AppserverIo\Lang\Reflection\MethodInterface $reflectionMethod The reflection method with the beans injection target configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface|null The initialized descriptor instance
     */
    public function fromReflectionMethod(MethodInterface $reflectionMethod)
    {

        // initialize the injection target from the passed method
        $this->setTargetClass($reflectionMethod->getClassName());
        $this->setTargetMethod($reflectionMethod->getMethodName());

        // return the instance
        return $this;
    }

    /**
     * Creates and initializes a beans injection target configuration instance from the passed
     * configuration node instance.
     *
     * @param \AppserverIo\Configuration\Interfaces\NodeInterface $node The configuration node with the beans injection target configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface|null The initialized descriptor instance
     */
    public function fromConfiguration(NodeInterface $node)
    {

        // query for the target class name we want to inject to
        if ($targetClass = (string) $node->getInjectionTargetClass()) {
            $this->setTargetClass($targetClass);
        }

        // query for the target property name we want to inject to
        if ($targetProperty = (string) $node->getInjectionTargetProperty()) {
            $this->setTargetProperty($targetProperty);
        }

        // query for the target method we want to use for injection
        if ($targetMethod = (string) $node->getInjectionTargetMethod()) {
            $this->setTargetMethod($targetMethod);
        }

        // return the instance
        return $this;
    }

    /**
     * Merges the passed injection target configuration into this one. Configuration
     * values of the passed configuration will overwrite the this one.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface $injectionTargetDescriptor The injection target to merge
     *
     * @return void
     */
    public function merge(InjectionTargetDescriptorInterface $injectionTargetDescriptor)
    {

        // merge the injection target class
        if ($targetClass = $injectionTargetDescriptor->getTargetClass()) {
            $this->setTargetClass($targetClass);
        }

        // merge the injection target property
        if ($targetProperty = $injectionTargetDescriptor->getTargetProperty()) {
            $this->setTargetProperty($targetProperty);
        }

        // merge the injection target method
        if ($targetMethod = $injectionTargetDescriptor->getTargetMethod()) {
            $this->setTargetMethod($targetMethod);
        }
    }
}
