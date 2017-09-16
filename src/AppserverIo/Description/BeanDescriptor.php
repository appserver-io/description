<?php

/**
 * AppserverIo\Description\BeanDescriptor
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
use AppserverIo\Description\Configuration\BeanConfigurationInterface;

/**
 * Abstract class for all bean descriptors.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class BeanDescriptor implements DescriptorInterface
{

    /**
     * The bean name.
     *
     * @var string
     */
    protected $name;

    /**
     * The beans class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Sets the bean name.
     *
     * @param string $name The bean name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the bean name.
     *
     * @return string The bean name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the beans class name.
     *
     * @param string $className The beans class name
     *
     * @return void
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * Returns the beans class name.
     *
     * @return string The beans class name
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\BeanDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new BeanDescriptor();
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
        if (!$configuration instanceof BeanConfigurationInterface) {
            return;
        }

        // query for the class name and set it
        if ($className = (string) $configuration->getClass()) {
            $this->setClassName(DescriptorUtil::trim($className));
        }

        // query for the name and set it
        if ($name = (string) $configuration->getName()) {
            $this->setName(DescriptorUtil::trim($name));
        }

        // return the instance
        return $this;
    }

    /**
     * Merges the passed configuration into this one. Configuration values
     * of the passed configuration will overwrite the this one.
     *
     * @param \AppserverIo\Psr\Deployment\DescriptorInterface $beanDescriptor The configuration to merge
     *
     * @return void
     */
    public function merge(DescriptorInterface $beanDescriptor)
    {

        // check if the classes are equal
        if ($this->getName() !== $beanDescriptor->getName()) {
            throw new EnterpriseBeansException(
                sprintf('You try to merge a bean configuration for % with %s', $beanDescriptor->getName(), $this->getName())
            );
        }

        // merge the class name
        if ($className = $beanDescriptor->getClassName()) {
            $this->setClassName($className);
        }
    }
}
