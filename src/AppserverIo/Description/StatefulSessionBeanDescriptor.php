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
use AppserverIo\Psr\EnterpriseBeans\Annotations\Remove;
use AppserverIo\Psr\EnterpriseBeans\Annotations\Stateful;
use AppserverIo\Psr\EnterpriseBeans\Annotations\PreAttach;
use AppserverIo\Psr\EnterpriseBeans\Annotations\PostDetach;
use AppserverIo\Psr\EnterpriseBeans\Annotations\PrePassivate;
use AppserverIo\Psr\EnterpriseBeans\Annotations\PostActivate;
use AppserverIo\Psr\EnterpriseBeans\Description\BeanDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\StatefulSessionBeanDescriptorInterface;
use AppserverIo\Description\Configuration\ConfigurationInterface;
use AppserverIo\Description\Configuration\SessionConfigurationInterface;

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
     * The array with the pre passivate callback method names.
     *
     * @var array
     */
    protected $prePassivateCallbacks = array();

    /**
     * The array with the post activate callback method names.
     *
     * @var array
     */
    protected $postActivateCallbacks = array();

    /**
     * The array with the remove methods.
     *
     * @var array
     */
    protected $removeMethods = array();

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
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\StatefulSessionBeanDescriptorInterface The descriptor instance
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
     * Adds a pre passivate callback method name.
     *
     * @param string $prePassivateCallback The pre passivate callback method name
     *
     * @return void
     */
    public function addPrePassivateCallback($prePassivateCallback)
    {
        $this->prePassivateCallbacks[] = $prePassivateCallback;
    }

    /**
     * Sets the array with the pre passivate callback method names.
     *
     * @param array $prePassivateCallbacks The pre passivate callback method names
     *
     * @return void
     */
    public function setPrePassivateCallbacks(array $prePassivateCallbacks)
    {
        $this->prePassivateCallbacks = $prePassivateCallbacks;
    }

    /**
     * The array with the pre passivate callback method names.
     *
     * @return array The pre passivate callback method names
     */
    public function getPrePassivateCallbacks()
    {
        return $this->prePassivateCallbacks;
    }

    /**
     * Adds a post activate callback method name.
     *
     * @param string $postActivateCallback The post activate callback method name
     *
     * @return void
     */
    public function addPostActivateCallback($postActivateCallback)
    {
        $this->postActivateCallbacks[] = $postActivateCallback;
    }

    /**
     * Sets the array with the post activate callback method names.
     *
     * @param array $postActivateCallbacks The post activate callback method names
     *
     * @return void
     */
    public function setPostActivateCallbacks(array $postActivateCallbacks)
    {
        $this->postActivateCallbacks = $postActivateCallbacks;
    }

    /**
     * The array with the post activate callback method names.
     *
     * @return array The post activate callback method names
     */
    public function getPostActivateCallbacks()
    {
        return $this->postActivateCallbacks;
    }

    /**
     * Adds a remove method name.
     *
     * @param string $removeMethod The remove method name
     *
     * @return void
     */
    public function addRemoveMethod($removeMethod)
    {
        $this->removeMethods[] = $removeMethod;
    }

    /**
     * Returns the array with the remove method names.
     *
     * @return array The array with the remove method names
     */
    public function getRemoveMethods()
    {
        return $this->removeMethods;
    }

    /**
     * Queries whether the passed method name is a remove method or not.
     *
     * @param string $methodName The method name to be queried
     *
     * @return boolean TRUE if the passed method name is a remove method, else FALSE
     */
    public function isRemoveMethod($methodName)
    {
        return in_array($methodName, $this->removeMethods);
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

            // if we found a @PostActivate annotation, invoke the method
            if ($reflectionMethod->hasAnnotation(PostActivate::ANNOTATION)) {
                $this->addPostActivateCallback(DescriptorUtil::trim($reflectionMethod->getMethodName()));
            }

            // if we found a @PrePassivate annotation, invoke the method
            if ($reflectionMethod->hasAnnotation(PrePassivate::ANNOTATION)) {
                $this->addPrePassivateCallback(DescriptorUtil::trim($reflectionMethod->getMethodName()));
            }

            // if we found a @Remove annotation, invoke the method
            if ($reflectionMethod->hasAnnotation(Remove::ANNOTATION)) {
                $this->addRemoveMethod(DescriptorUtil::trim($reflectionMethod->getMethodName()));
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
     * @param \AppserverIo\Description\Configuration\ConfigurationInterface $configuration The configuration node with the bean configuration
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\StatefulSessionBeanDescriptorInterface|null The initialized descriptor instance
     */
    public function fromConfiguration(ConfigurationInterface $configuration)
    {

        // query whether or not we've a session bean configuration
        if (!$configuration instanceof SessionConfigurationInterface) {
            return;
        }

        // query wheter or not the session type matches
        if ((string) $configuration->getSessionType() !== StatefulSessionBeanDescriptor::SESSION_TYPE) {
            return;
        }

        // initialize the descriptor instance
        parent::fromConfiguration($configuration);

        // initialize the post detach callback methods
        if ($postDetach = $configuration->getPostDetach()) {
            foreach ($postDetach->getLifecycleCallbackMethods() as $postDetachCallback) {
                $this->addPostDetachCallback(DescriptorUtil::trim((string) $postDetachCallback));
            }
        }

        // initialize the pre attach callback methods
        if ($preAttach = $configuration->getPreAttach()) {
            foreach ($preAttach->getLifecycleCallbackMethods() as $preAttachCallback) {
                $this->addPreAttachCallback(DescriptorUtil::trim((string) $preAttachCallback));
            }
        }

        // initialize the post activate callback methods
        if ($postActivate = $configuration->getPostActivate()) {
            foreach ($postActivate->getLifecycleCallbackMethods() as $postActivateCallback) {
                $this->addPostActivateCallback(DescriptorUtil::trim((string) $postActivateCallback));
            }
        }

        // initialize the pre passivate callback methods
        if ($prePassivate = $configuration->getPrePassivate()) {
            foreach ($prePassivate->getLifecycleCallbackMethods() as $prePassivateCallback) {
                $this->addPrePassivateCallback(DescriptorUtil::trim((string) $prePassivateCallback));
            }
        }

        // initialize the remove methods
        if ($removeMethod = $configuration->getRemoveMethod()) {
            foreach ($removeMethod->getMethodNames() as $methodName) {
                $this->addRemoveMethod(DescriptorUtil::trim((string) $methodName));
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

        // only merge the more special configuration fields if the desciptor has the right type
        if (!$beanDescriptor instanceof StatefulSessionBeanDescriptorInterface) {
            return;
        }

        // merge the default bean members by invoking the parent method
        parent::merge($beanDescriptor);

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

        // merge the post activate callback method names
        foreach ($beanDescriptor->getPostActivateCallbacks() as $postActivateCallback) {
            if (in_array($postActivateCallback, $this->getPostActivateCallbacks()) === false) {
                $this->addPostActivateCallback($postActivateCallback);
            }
        }

        // merge the pre passivate callback method names
        foreach ($beanDescriptor->getPrePassivateCallbacks() as $prePassivateCallback) {
            if (in_array($prePassivateCallback, $this->getPrePassivateCallbacks()) === false) {
                $this->addPrePassivateCallback($prePassivateCallback);
            }
        }

        // merge the pre attach callback method names
        foreach ($beanDescriptor->getRemoveMethods() as $removeMethod) {
            if (in_array($removeMethod, $this->getRemoveMethods()) === false) {
                $this->addRemoveMethod($removeMethod);
            }
        }
    }
}
