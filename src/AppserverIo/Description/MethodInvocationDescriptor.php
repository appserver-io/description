<?php

/**
 * AppserverIo\Description\MethodDescriptor
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

use AppserverIo\Psr\Deployment\DescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\EnterpriseBeansException;
use AppserverIo\Description\Configuration\ConfigurationInterface;
use AppserverIo\Description\Configuration\MethodInvocationConfigurationInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\MethodInvocationDescriptorInterface;

/**
 * Implementation of a method invocation descriptor.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class MethodInvocationDescriptor extends AbstractNameAwareDescriptor implements MethodInvocationDescriptorInterface
{

    /**
     * The method name.
     *
     * @var string
     */
    protected $methodName;

    /**
     * The method arguments.
     *
     * @var array
     */
    protected $arguments = array();

    /**
     * Set's the method name.
     *
     * @param string $methodName The method name
     *
     * @return void
     */
    public function setMethodName($methodName)
    {
        $this->methodName = $methodName;
    }

    /**
     * Return's the method name.
     *
     * @return string The method name
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * Add's the passed argument to the descriptor.
     *
     * @param string $argument The argument
     *
     * @return void
     */
    public function addArgument($argument)
    {
        $this->arguments[] = $argument;
    }

    /**
     * Return's the method arguments.
     *
     * @return array The method arguments
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\MethodInvocationDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new MethodInvocationDescriptor();
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
        if (!$configuration instanceof MethodInvocationConfigurationInterface) {
            return;
        }

        // query for the name and set it
        if ($methodName = (string) $configuration->getMethodName()) {
            $this->setMethodName(DescriptorUtil::trim($methodName));
        }

        // add the configured arguments to the descriptor
        foreach ($configuration->getArguments() as $argument) {
            $this->addArgument($argument);
        }

        // return the instance
        return $this;
    }

    /**
     * Merges the passed configuration into this one. Configuration values
     * of the passed configuration will overwrite the this one.
     *
     * @param \AppserverIo\Psr\Deployment\DescriptorInterface $methodDescriptor The configuration to merge
     *
     * @return void
     */
    public function merge(DescriptorInterface $methodDescriptor)
    {

        // check if the classes are equal
        if ($this->getMethodName() !== $methodDescriptor->getMethodName()) {
            throw new EnterpriseBeansException(
                sprintf('You try to merge a method invocation configuration for "%s" with "%s"', $methodDescriptor->getMethodName(), $this->getMethodName())
            );
        }

        // merge the method arguments
        foreach ($methodDescriptor->getArguments() as $argument) {
            $this->addArgument($argument);
        }
    }
}
