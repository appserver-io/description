<?php

/**
 * AppserverIo\Description\MessageDrivenBeanDescriptor
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
use AppserverIo\Psr\EnterpriseBeans\Annotations\MessageDriven;
use AppserverIo\Psr\EnterpriseBeans\Description\MessageDrivenBeanDescriptorInterface;
use AppserverIo\Description\Configuration\ConfigurationInterface;
use AppserverIo\Description\Configuration\MessageDrivenConfigurationInterface;

/**
 * Implementation for message driven bean descriptor.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class MessageDrivenBeanDescriptor extends EnterpriseBeanDescriptor implements MessageDrivenBeanDescriptorInterface
{

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\MessageDrivenBeanDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new MessageDrivenBeanDescriptor();
    }

    /**
     * Return's the annoation class name.
     *
     * @return string The annotation class name
     */
    protected function getAnnotationClass()
    {
        return MessageDriven::class;
    }

    /**
     * Initializes the bean descriptor instance from the passed reflection class instance.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the bean configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\MessageDrivenBeanDescriptorInterface|null The initialized descriptor instance
     */
    public function fromReflectionClass(ClassInterface $reflectionClass)
    {

        // load the annotation instance
        $annotationInstance = $this->getClassAnnotation($reflectionClass, MessageDriven::class);

        // query if we've an enterprise bean with a @MessageDriven annotation
        if ($annotationInstance === null) {
            // if not, do nothing
            return;
        }

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
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\MessageDrivenBeanDescriptorInterface|null The initialized descriptor instance
     */
    public function fromConfiguration(ConfigurationInterface $configuration)
    {

        // query whether or not we've a message driven bean configuration
        if (!$configuration instanceof MessageDrivenConfigurationInterface) {
            return;
        }

        // initialize the descriptor instance
        parent::fromConfiguration($configuration);

        // return the instance
        return $this;
    }
}
