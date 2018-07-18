<?php

/**
 * AppserverIo\Description\SessionBeanDescriptor
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
use AppserverIo\Psr\EnterpriseBeans\Annotations\Local;
use AppserverIo\Psr\EnterpriseBeans\Annotations\Remote;
use AppserverIo\Psr\EnterpriseBeans\Annotations\PreDestroy;
use AppserverIo\Psr\EnterpriseBeans\Annotations\PostConstruct;
use AppserverIo\Psr\EnterpriseBeans\Description\BeanDescriptorInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\SessionBeanDescriptorInterface;
use AppserverIo\Description\Configuration\SessionConfigurationInterface;
use AppserverIo\Description\Configuration\ConfigurationInterface;

/**
 * Implementation for an abstract session bean descriptor.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
abstract class SessionBeanDescriptor extends EnterpriseBeanDescriptor implements SessionBeanDescriptorInterface
{

    /**
     * The beans session type.
     *
     * @var string
     */
    protected $sessionType;

    /**
     * The local interface name.
     *
     * @var string
     */
    protected $local;

    /**
     * The remote interface name.
     *
     * @var string
     */
    protected $remote;

    /**
     * The array with the post construct callback method names.
     *
     * @var array
     */
    protected $postConstructCallbacks = array();

    /**
     * The array with the pre destroy callback method names.
     *
     * @var array
     */
    protected $preDestroyCallbacks = array();

    /**
     * Sets the beans session type.
     *
     * @param string $sessionType The beans session type
     *
     * @return void
     */
    public function setSessionType($sessionType)
    {
        $this->sessionType = $sessionType;
    }

    /**
     * Returns the beans session type.
     *
     * @return string The beans session type
     */
    public function getSessionType()
    {
        return $this->sessionType;
    }

    /**
     * Sets the local interface name.
     *
     * @param string $local The local interface name
     *
     * @return void
     */
    public function setLocal($local)
    {
        $this->local = $local;
    }

    /**
     * Returns the local interface name.
     *
     * @return string The local interface name
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Sets the remote interface name.
     *
     * @param string $remote The remote interface name
     *
     * @return void
     */
    public function setRemote($remote)
    {
        $this->remote = $remote;
    }

    /**
     * Returns the remote interface name.
     *
     * @return string The remote interface name
     */
    public function getRemote()
    {
        return $this->remote;
    }

    /**
     * Adds a post construct callback method name.
     *
     * @param string $postConstructCallback The post construct callback method name
     *
     * @return void
     */
    public function addPostConstructCallback($postConstructCallback)
    {
        $this->postConstructCallbacks[] = $postConstructCallback;
    }

    /**
     * Adds a pre destroy callback method name.
     *
     * @param string $preDestroyCallback The pre destroy callback method name
     *
     * @return void
     */
    public function addPreDestroyCallback($preDestroyCallback)
    {
        $this->preDestroyCallbacks[] = $preDestroyCallback;
    }

    /**
     * Sets the array with the post construct callback method names.
     *
     * @param array $postConstructCallbacks The post construct callback method names
     *
     * @return void
     */
    public function setPostConstructCallbacks(array $postConstructCallbacks)
    {
        $this->postConstructCallbacks = $postConstructCallbacks;
    }

    /**
     * The array with the post construct callback method names.
     *
     * @return array The post construct callback method names
     */
    public function getPostConstructCallbacks()
    {
        return $this->postConstructCallbacks;
    }

    /**
     * Sets the array with the pre destroy callback method names.
     *
     * @param array $preDestroyCallbacks The pre destroy callback method names
     *
     * @return void
     */
    public function setPreDestroyCallbacks(array $preDestroyCallbacks)
    {
        $this->preDestroyCallbacks = $preDestroyCallbacks;
    }

    /**
     * The array with the pre destroy callback method names.
     *
     * @return array The pre destroy callback method names
     */
    public function getPreDestroyCallbacks()
    {
        return $this->preDestroyCallbacks;
    }

    /**
     * Initializes the bean descriptor instance from the passed reflection class instance.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the bean description
     *
     * @return void
     *
     * @throws \Exception
     */
    public function fromReflectionClass(ClassInterface $reflectionClass)
    {

        // initialize the bean descriptor
        parent::fromReflectionClass($reflectionClass);

        // query whether we've a @Local annotation
        if ($localAnnotationInstance = $this->getClassAnnotation($reflectionClass, Local::class)) {
            $this->setLocal($localAnnotationInstance->getName());
        } else {
            $this->setLocal(sprintf('%sLocal', $this->getName()));
        }

        // query whether we've a @Remote annotation
        if ($remoteAnnotationInstance = $this->getClassAnnotation($reflectionClass, Remote::class)) {
            $this->setRemote($remoteAnnotationInstance->getName());
        } else {
            $this->setRemote(sprintf('%sRemote', $this->getName()));
        }

        // we've to check for a @PostConstruct or @PreDestroy annotation
        foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
            // if we found a @PostConstruct annotation, invoke the method
            if ($this->getMethodAnnotation($reflectionMethod, PostConstruct::class)) {
                $this->addPostConstructCallback(DescriptorUtil::trim($reflectionMethod->getMethodName()));
            }

            // if we found a @PreDestroy annotation, invoke the method
            if ($this->getMethodAnnotation($reflectionMethod, PreDestroy::class)) {
                $this->addPreDestroyCallback(DescriptorUtil::trim($reflectionMethod->getMethodName()));
            }
        }
    }

    /**
     * Initializes a bean descriptor instance from the passed configuration node.
     *
     * @param \AppserverIo\Description\Configuration\ConfigurationInterface $configuration The configuration node with the bean description
     *
     * @return void
     */
    public function fromConfiguration(ConfigurationInterface $configuration)
    {

        // query whether or not we've a session bean configuration
        if (!$configuration instanceof SessionConfigurationInterface) {
            return;
        }

        // initialize the bean descriptor
        parent::fromConfiguration($configuration);

        // query for the session type and set it
        if ($sessionType = (string) $configuration->getSessionType()) {
            $this->setSessionType($sessionType);
        }

        // query for the name of the local business interface and set it
        if ($local = (string) $configuration->getLocal()) {
            $this->setLocal($local);
        } else {
            $this->setLocal(sprintf('%sLocal', $this->getName()));
        }

        // query for the name of the remote business interface and set it
        if ($remote = (string) $configuration->getRemote()) {
            $this->setRemote($remote);
        } else {
            $this->setRemote(sprintf('%sRemote', $this->getName()));
        }

        // initialize the post construct callback methods
        if ($postConstructNode = $configuration->getPostConstruct()) {
            foreach ($postConstructNode->getLifecycleCallbackMethods() as $postConstructCallback) {
                $this->addPostConstructCallback(DescriptorUtil::trim((string) $postConstructCallback));
            }
        }

        // initialize the pre destroy callback methods
        if ($preDestroyNode = $configuration->getPreDestroy()) {
            foreach ($preDestroyNode->getLifecycleCallbackMethods() as $preDestroyCallback) {
                $this->addPreDestroyCallback(DescriptorUtil::trim((string) $preDestroyCallback));
            }
        }
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
        if (!$beanDescriptor instanceof SessionBeanDescriptorInterface) {
            return;
        }

        // merge the default bean members by invoking the parent method
        parent::merge($beanDescriptor);

        // merge the session type
        if ($sessionType = $beanDescriptor->getSessionType()) {
            $this->setSessionType($sessionType);
        }

        // merge the post construct callback method names
        foreach ($beanDescriptor->getPostConstructCallbacks() as $postConstructCallback) {
            if (in_array($postConstructCallback, $this->getPostConstructCallbacks()) === false) {
                $this->addPostConstructCallback($postConstructCallback);
            }
        }

        // merge the pre destroy callback method names
        foreach ($beanDescriptor->getPreDestroyCallbacks() as $preDestroyCallback) {
            if (in_array($preDestroyCallback, $this->getPreDestroyCallbacks()) === false) {
                $this->addPreDestroyCallback($preDestroyCallback);
            }
        }
    }
}
