<?php

/**
 * AppserverIo\Description\StatefulSessionBeanDescriptor
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
use AppserverIo\Configuration\Interfaces\NodeInterface;
use AppserverIo\Psr\EnterpriseBeans\Annotations\Stateful;
use AppserverIo\Psr\EnterpriseBeans\Annotations\PreAttach;
use AppserverIo\Psr\EnterpriseBeans\Annotations\PostDetach;
use AppserverIo\Psr\EnterpriseBeans\Description\BeanDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\StatefulSessionBeanDescriptorInterface;

/**
 * Implementation for a stateful session bean descriptor.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class StatefulSessionBeanDescriptor extends SessionBeanDescriptor implements StatefulSessionBeanDescriptorInterface
{

    /**
     * Defines a keyword for a stateful session bean in a deployment descriptor node.
     *
     * @var string
     */
    const SESSION_TYPE = 'Stateful';

    /**
     * The array with the pre attach callback method names.
     *
     * @var array
     */
    protected $preAttachCallbacks = array();

    /**
     * The array with the post detach callback method names.
     *
     * @var array
     */
    protected $postDetachCallbacks = array();

    /**
     * Initialize the session bean descriptor with the session type.
     */
    public function __construct()
    {
        $this->setSessionType(StatefulSessionBeanDescriptor::SESSION_TYPE);
    }

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\StatefulSessionBeanDescriptorInterface
     *     The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new StatefulSessionBeanDescriptor();
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
        return $reflectionClass->getAnnotation(Stateful::ANNOTATION);
    }

    /**
     * Adds a pre attach callback method name.
     *
     * @param string $preAttachCallback The pre attach callback method name
     *
     * @return void
     */
    public function addPreAttachCallback($preAttachCallback)
    {
        $this->preAttachCallbacks[] = $preAttachCallback;
    }

    /**
     * Sets the array with the pre attach callback method names.
     *
     * @param array $preAttachCallbacks The pre attach callback method names
     *
     * @return void
     */
    public function setPreAttachCallbacks(array $preAttachCallbacks)
    {
        $this->preAttachCallbacks = $preAttachCallbacks;
    }

    /**
     * The array with the pre attach callback method names.
     *
     * @return array The pre attach callback method names
     */
    public function getPreAttachCallbacks()
    {
        return $this->preAttachCallbacks;
    }

    /**
     * Adds a post detach callback method name.
     *
     * @param string $postDetachCallback The post detach callback method name
     *
     * @return void
     */
    public function addPostDetachCallback($postDetachCallback)
    {
        $this->postDetachCallbacks[] = $postDetachCallback;
    }

    /**
     * Sets the array with the post detach callback method names.
     *
     * @param array $postDetachCallbacks The post detach callback method names
     *
     * @return void
     */
    public function setPostDetachCallbacks(array $postDetachCallbacks)
    {
        $this->postDetachCallbacks = $postDetachCallbacks;
    }

    /**
     * The array with the post detach callback method names.
     *
     * @return array The post detach callback method names
     */
    public function getPostDetachCallbacks()
    {
        return $this->postDetachCallbacks;
    }

    /**
     * Initializes the bean descriptor instance from the passed reflection class instance.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the bean configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\StatefulSessionBeanDescriptorInterface|null The initialized descriptor instance
     */
    public function fromReflectionClass(ClassInterface $reflectionClass)
    {

        // query if we've an enterprise bean with a @Stateful annotation
        if ($reflectionClass->hasAnnotation(Stateful::ANNOTATION) === false) {
            // if not, do nothing
            return;
        }

        // set the session type
        $this->setSessionType(StatefulSessionBeanDescriptor::SESSION_TYPE);

        // we've to check for a @PostDetach or @PreAttach annotation
        foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
            // if we found a @PostDetach annotation, invoke the method
            if ($reflectionMethod->hasAnnotation(PostDetach::ANNOTATION)) {
                $this->addPostDetachCallback(DescriptorUtil::trim($reflectionMethod->getMethodName()));
            }

            // if we found a @PreAttach annotation, invoke the method
            if ($reflectionMethod->hasAnnotation(PreAttach::ANNOTATION)) {
                $this->addPreAttachCallback(DescriptorUtil::trim($reflectionMethod->getMethodName()));
            }
        }

        // initialize the descriptor instance
        parent::fromReflectionClass($reflectionClass);

        // return the instance
        return $this;
    }

    /**
     * Initializes a bean descriptor instance from the passed configuration node.
     *
     * @param \AppserverIo\Configuration\Interfaces\NodeInterface $node The configuration node with the bean configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\StatefulSessionBeanDescriptorInterface|null The initialized descriptor instance
     */
    public function fromConfiguration(NodeInterface $node)
    {

        // query whether we've to handle the passed configuration or not
        if ($node->getNodeName() !== 'session') {
            return;
        }

        // query wheter or not the session type matches
        if ((string) $node->getSessionType() !== StatefulSessionBeanDescriptor::SESSION_TYPE) {
            return;
        }

        // initialize the descriptor instance
        parent::fromConfiguration($node);

        // initialize the post detach callback methods
        if ($postDetach = $node->getPostDetach()) {
            foreach ($postDetach->getLifecycleCallbackMethods() as $postDetachCallback) {
                $this->addPostDetachCallback(DescriptorUtil::trim((string) $postDetachCallback));
            }
        }

        // initialize the pre attach callback methods
        if ($preAttach = $node->getPreAttach()) {
            foreach ($preAttach->getLifecycleCallbackMethods() as $preAttachCallback) {
                $this->addPreAttachCallback(DescriptorUtil::trim((string) $preAttachCallback));
            }
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

        // merge the default bean members by invoking the parent method
        parent::merge($beanDescriptor);

        // only merge the more special configuration fields if the desciptor has the right type
        if (!$beanDescriptor instanceof StatefulSessionBeanDescriptorInterface) {
            return;
        }

        // merge the post detach callback method names
        foreach ($beanDescriptor->getPostDetachCallbacks() as $postDetachCallback) {
            if (in_array($postDetachCallback, $this->getPostDetachCallbacks()) === false) {
                $this->addPostDetachCallback($postDetachCallback);
            }
        }

        // merge the pre attach callback method names
        foreach ($beanDescriptor->getPreAttachCallbacks() as $preAttachCallback) {
            if (in_array($preAttachCallback, $this->getPreAttachCallbacks()) === false) {
                $this->addPreAttachCallback($preAttachCallback);
            }
        }
    }
}
