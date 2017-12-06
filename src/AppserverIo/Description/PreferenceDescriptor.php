<?php

/**
 * AppserverIo\Description\PreferenceDescriptor
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
use AppserverIo\Psr\EnterpriseBeans\EnterpriseBeansException;
use AppserverIo\Description\Configuration\ConfigurationInterface;
use AppserverIo\Description\Configuration\PreferenceConfigurationInterface;

/**
 * Implementation for a preference descriptor.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class PreferenceDescriptor extends AbstractDescriptor
{

    /**
     * The bean name.
     *
     * @var string
     */
    protected $interface;

    /**
     * The beans class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Sets the preference interface.
     *
     * @param string $interface The preference interface
     *
     * @return void
     */
    public function setInterface($interface)
    {
        $this->interface = $interface;
    }

    /**
     * Returns the preference interface.
     *
     * @return string The preference interface
     */
    public function getInterface()
    {
        return $this->interface;
    }

    /**
     * Sets the preference class name.
     *
     * @param string $className The preference class name
     *
     * @return void
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * Returns the preference class name.
     *
     * @return string The preference class name
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Psr\Deployment\DescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new PreferenceDescriptor();
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
        if (!$configuration instanceof PreferenceConfigurationInterface) {
            return;
        }

        // query for the class name and set it
        if ($className = (string) $configuration->getClass()) {
            $this->setClassName(DescriptorUtil::trim($className));
        }

        // query for the interface and set it
        if ($interface = (string) $configuration->getInterface()) {
            $this->setInterface(DescriptorUtil::trim($interface));
        }

        // return the instance
        return $this;
    }

    /**
     * Merges the passed configuration into this one. Configuration values
     * of the passed configuration will overwrite the this one.
     *
     * @param \AppserverIo\Psr\Deployment\DescriptorInterface $descriptor The configuration to merge
     *
     * @return void
     */
    public function merge(DescriptorInterface $descriptor)
    {

        // check if the interfaces are equal
        if ($this->getInterface() !== $descriptor->getInterface()) {
            throw new EnterpriseBeansException(
                sprintf('You try to merge a preference configuration for "%s" with "%s"', $descriptor->getInterface(), $this->getInterface())
            );
        }

        // merge the class name
        if ($className = $descriptor->getClassName()) {
            $this->setClassName($className);
        }
    }
}
