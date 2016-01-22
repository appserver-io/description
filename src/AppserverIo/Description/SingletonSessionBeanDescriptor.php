<?php

/**
 * AppserverIo\Description\SingletonSessionBeanDescriptor
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

use AppserverIo\Lang\String;
use AppserverIo\Lang\Boolean;
use AppserverIo\Lang\Reflection\ClassInterface;
use AppserverIo\Psr\EnterpriseBeans\Annotations\Startup;
use AppserverIo\Psr\EnterpriseBeans\Annotations\Singleton;
use AppserverIo\Psr\EnterpriseBeans\Description\BeanDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\SingletonSessionBeanDescriptorInterface;
use AppserverIo\Description\Configuration\ConfigurationInterface;
use AppserverIo\Description\Configuration\SessionConfigurationInterface;

/**
 * Implementation for a singleton session bean descriptor.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class SingletonSessionBeanDescriptor extends SessionBeanDescriptor implements SingletonSessionBeanDescriptorInterface
{

    /**
     * Defines a keyword for a singleton session bean in a deployment descriptor node.
     *
     * @var string
     */
    const SESSION_TYPE = 'Singleton';

    /**
     * Whether the bean should be initialized on server startup.
     *
     * @var boolean
     */
    protected $initOnStartup = false;

    /**
     * Initialize the session bean descriptor with the session type.
     */
    public function __construct()
    {
        $this->setSessionType(SingletonSessionBeanDescriptor::SESSION_TYPE);
    }

    /**
     * Sets the flag whether the bean should be initialized on startup or not.
     *
     * @param boolean $initOnStartup TRUE if the bean should be initialized on startup, else FALSE
     *
     * @return void
     */
    public function setInitOnStartup($initOnStartup = true)
    {
        $this->initOnStartup = $initOnStartup;
    }

    /**
     * Queries whether the bean should be initialized on startup or not.
     *
     * @return boolean TRUE if the bean should be initialized on startup, else FALSE
     */
    public function isInitOnStartup()
    {
        return $this->initOnStartup;
    }

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\SingletonSessionBeanDescriptorInterface
     *     The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new SingletonSessionBeanDescriptor();
    }

    /**
     * Returns a new annotation instance for the passed reflection class.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the bean configuration
     *
     * @return \AppserverIo\Lang\Reflection\AnnotationInterface The reflection annotation
     */
    protected function newAnnotationInstance(ClassInterface $reflectionClass)
    {
        return $reflectionClass->getAnnotation(Singleton::ANNOTATION);
    }

    /**
     * Initializes the bean descriptor instance from the passed reflection class instance.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the bean configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\SingletonSessionBeanDescriptorInterface|null The initialized descriptor instance
     */
    public function fromReflectionClass(ClassInterface $reflectionClass)
    {

        // query if we've an enterprise bean with a @Singleton annotation
        if ($reflectionClass->hasAnnotation(Singleton::ANNOTATION) === false) {
            // if not, do nothing
            return;
        }

        // set the session type
        $this->setSessionType(SingletonSessionBeanDescriptor::SESSION_TYPE);

        // initialize the descriptor instance
        parent::fromReflectionClass($reflectionClass);

        // if we found a bean with @Singleton + @Startup annotation
        if ($reflectionClass->hasAnnotation(Startup::ANNOTATION)) {
            // instanciate the bean
            $this->setInitOnStartup();
        }

        // return the instance
        return $this;
    }

    /**
     * Initializes a bean descriptor instance from the passed configuration node.
     *
     * @param \AppserverIo\Description\Configuration\ConfigurationInterface $configuration The configuration node with the bean configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\SingletonSessionBeanDescriptorInterface|null The initialized descriptor instance
     */
    public function fromConfiguration(ConfigurationInterface $configuration)
    {

        // query whether or not we've a session bean configuration
        if (!$configuration instanceof SessionConfigurationInterface) {
            return;
        }

        // query wheter or not the session type matches
        if ((string) $configuration->getSessionType() !== SingletonSessionBeanDescriptor::SESSION_TYPE) {
            return;
        }

        // initialize the descriptor instance
        parent::fromConfiguration($configuration);

        // query for the startup flag
        if ($initOnStartup = (string) $configuration->getInitOnStartup()) {
            $this->setInitOnStartup(Boolean::valueOf(new String($initOnStartup))->booleanValue());
        }

        // return the instance
        return $this;
    }

    /**
     * Merges the passed configuration into this one. Configuration values
     * of the passed configuration will overwrite the this one.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\BeanDescriptorInterface $beanDescriptor The configuration to merge
     *
     * @return void
     */
    public function merge(BeanDescriptorInterface $beanDescriptor)
    {

        // only merge the more special configuration fields if the desciptor has the right type
        if (!$beanDescriptor instanceof SingletonSessionBeanDescriptorInterface) {
            return;
        }

        // merge the default bean members by invoking the parent method
        parent::merge($beanDescriptor);

        // merge the startup flag
        $this->setInitOnStartup($beanDescriptor->isInitOnStartup());
    }
}
