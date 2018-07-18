<?php

/**
 * AppserverIo\Description\StatelessSessionBeanDescriptor
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
use AppserverIo\Psr\EnterpriseBeans\Annotations\Stateless;
use AppserverIo\Psr\EnterpriseBeans\Description\StatelessSessionBeanDescriptorInterface;
use AppserverIo\Description\Configuration\ConfigurationInterface;
use AppserverIo\Description\Configuration\SessionConfigurationInterface;

/**
 * Implementation for a stateless session bean descriptor.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class StatelessSessionBeanDescriptor extends SessionBeanDescriptor implements StatelessSessionBeanDescriptorInterface
{

    /**
     * Defines a keyword for a stateless session bean in a deployment descriptor node.
     *
     * @var string
     */
    const SESSION_TYPE = 'Stateless';

    /**
     * Initialize the session bean descriptor with the session type.
     */
    public function __construct()
    {
        $this->setSessionType(StatelessSessionBeanDescriptor::SESSION_TYPE);
    }

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\StatelessSessionBeanDescriptorInterface
     *     The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new StatelessSessionBeanDescriptor();
    }

    /**
     * Return's the annoation class name.
     *
     * @return string The annotation class name
     */
    protected function getAnnotationClass()
    {
        return Stateless::class;
    }

    /**
     * Initializes the bean descriptor instance from the passed reflection class instance.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the bean configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\StatelessSessionBeanDescriptorInterface|null The initialized descriptor instance
     */
    public function fromReflectionClass(ClassInterface $reflectionClass)
    {

        // create a new annotation instance
        $annotationInstance = $this->getClassAnnotation($reflectionClass, $this->getAnnotationClass());

        // query if we've an enterprise bean with a @Stateless annotation
        if ($annotationInstance === null) {
            // if not, do nothing
            return;
        }

        // set the session type
        $this->setSessionType(StatelessSessionBeanDescriptor::SESSION_TYPE);

        // initialize the descriptor instance
        parent::fromReflectionClass($reflectionClass);

        // return the instance
        return $this;
    }

    /**
     * Initializes a bean descriptor instance from the passed configuration node.
     *
     * @param \AppserverIo\Description\Configuration\ConfigurationInterface $configuration The configuration node with the bean configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\StatelessSessionBeanDescriptorInterface|null The initialized descriptor instance
     */
    public function fromConfiguration(ConfigurationInterface $configuration)
    {

        // query whether or not we've a session bean configuration
        if (!$configuration instanceof SessionConfigurationInterface) {
            return;
        }

        // query wheter or not the session type matches
        if ((string) $configuration->getSessionType() !== StatelessSessionBeanDescriptor::SESSION_TYPE) {
            return;
        }

        // initialize the descriptor instance
        parent::fromConfiguration($configuration);

        // return the instance
        return $this;
    }
}
