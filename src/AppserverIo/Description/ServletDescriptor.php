<?php

/**
 * AppserverIo\Description\ServletDescriptor
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
use AppserverIo\Psr\Servlet\ServletException;
use AppserverIo\Psr\Servlet\Annotations\Route;
use AppserverIo\Psr\Servlet\Description\ServletDescriptorInterface;
use AppserverIo\Description\Configuration\ServletConfigurationInterface;
use AppserverIo\Description\Configuration\ConfigurationInterface;

/**
 * A servlet descriptor implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class ServletDescriptor extends AbstractNameAwareDescriptor implements ServletDescriptorInterface
{

    /**
     * Trait with functionality to handle bean, resource and persistence unit references.
     *
     * @var AppserverIo\Description\DescriptorReferencesTrait
     */
    use DescriptorReferencesTrait;

    /**
     * The servlets class name.
     *
     * @var string
     */
    protected $className;

    /**
     * The servlets display name.
     *
     * @var string
     */
    protected $displayName;

    /**
     * The array with the initialization parameters.
     *
     * @var array
     */
    protected $initParams = array();

    /**
     * The array with the URL patterns.
     *
     * @var array
     */
    protected $urlPatterns = array();

    /**
     * Sets the servlets class name.
     *
     * @param string $className The servlets class name
     *
     * @return void
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * Returns the servlets class name.
     *
     * @return string The servlets class name
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Sets the servlets display name.
     *
     * @param string $displayName The servlets display name
     *
     * @return void
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * Returns the servlets display name.
     *
     * @return string The servlets display name
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Adds a initialization parameter key/value pair.
     *
     * @param string $key   The key of the initialization parameter
     * @param string $value The value of the initialization parameter
     *
     * @return void
     */
    public function addInitParam($key, $value)
    {
        $this->initParams[$key] = $value;
    }

    /**
     * Sets the array with the initialization parameters.
     *
     * @param array $initParams The initialization parameters
     *
     * @return void
     */
    public function setInitParams(array $initParams)
    {
        $this->initParams = $initParams;
    }

    /**
     * The array with the initialization parameters.
     *
     * @return array The initialization parameters
     */
    public function getInitParams()
    {
        return $this->initParams;
    }

    /**
     * Adds a URL pattern.
     *
     * @param string $urlPattern The URL pattern
     *
     * @return void
     */
    public function addUrlPattern($urlPattern)
    {
        if (in_array($urlPattern, $this->urlPatterns) === false) {
            $this->urlPatterns[] = $urlPattern;
        }
    }

    /**
     * Sets the array with the URL patterns.
     *
     * @param array $urlPatterns The URL patterns
     *
     * @return void
     */
    public function setUrlPatterns(array $urlPatterns)
    {
        $this->urlPatterns = $urlPatterns;
    }

    /**
     * The array with the URL patterns.
     *
     * @return array The URL patterns
     */
    public function getUrlPatterns()
    {
        return $this->urlPatterns;
    }

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\BeanDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new ServletDescriptor();
    }

    /**
     * Return's the annoation class name.
     *
     * @return string The annotation class name
     */
    protected function getAnnotationClass()
    {
        return Route::class;
    }

    /**
     * Initializes the servlet descriptor instance from the passed reflection class instance.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the servlet description
     *
     * @return \AppserverIo\Description\Configuration\ServletConfigurationInterface|null The initialized descriptor instance
     */
    public function fromReflectionClass(ClassInterface $reflectionClass)
    {

        // query if we've a servlet
        if ($reflectionClass->implementsInterface('AppserverIo\Psr\Servlet\ServletInterface') === false) {
            // if not, do nothing
            return;
        }

        // query if we've an interface or an abstract class
        if ($reflectionClass->toPhpReflectionClass()->isInterface() ||
            $reflectionClass->toPhpReflectionClass()->isAbstract()) {
            // if so, do nothing
            return;
        }

        // set the servlet name, strip the phrase 'Servlet' if appended
        $this->setName(lcfirst(preg_replace('/Servlet$/', '', $reflectionClass->getShortName())));
        
        // set the class name
        $this->setClassName($reflectionClass->getName());

        // if we found a @Route annotation, load the annotation instance
        if ($annotationInstance = $this->getClassAnnotation($reflectionClass, Route::class)) {
            // load the default name to register in naming directory
            if ($nameAttribute = $annotationInstance->getName()) {
                $this->setName($nameAttribute);
            }

            // register the servlet description defined as @Route(description=****)
            if ($description = $annotationInstance->getDescription()) {
                $this->setDescription($description);
            }

            // register the servlet display name defined as @Route(displayName=****)
            if ($displayName = $annotationInstance->getDisplayName()) {
                $this->setDisplayName($displayName);
            }

            // register the init params defined as @Route(initParams=****)
            foreach ($annotationInstance->getInitParams() as $initParam) {
                list ($paramName, $paramValue) = $initParam;
                $this->addInitParam($paramName, $paramValue);
            }

            // register the URL pattern defined as @Route(urlPattern=****)
            foreach ($annotationInstance->getUrlPattern() as $urlPattern) {
                $this->addUrlPattern($urlPattern);
            }
        }

        // initialize references from the passed reflection class
        $this->referencesFromReflectionClass($reflectionClass);

        // return the instance
        return $this;
    }

    /**
     * Initializes a servlet descriptor instance from the passed configuration node.
     *
     * @param \AppserverIo\Description\Configuration\ConfigurationInterface $configuration The servlet configuration
     *
     * @return \AppserverIo\Description\Configuration\ServletConfigurationInterface|null The initialized descriptor instance
     */
    public function fromConfiguration(ConfigurationInterface $configuration)
    {

        // query whether or not we've servlet configuration
        if (!$configuration instanceof ServletConfigurationInterface) {
            return;
        }

        // query for the class name and set it
        if ($className = (string) $configuration->getServletClass()) {
            $this->setClassName($className);
        }

        // query for the name and set it
        if ($name = (string) $configuration->getServletName()) {
            $this->setName($name);
        }

        // query for the description and set it
        if ($description = (string) $configuration->getDescription()) {
            $this->setDescription($description);
        }

        // query for the display name and set it
        if ($displayName = (string) $configuration->getDisplayName()) {
            $this->setDisplayName($displayName);
        }

        // append the init params to the servlet configuration
        foreach ($configuration->getInitParams() as $initParam) {
            $this->addInitParam((string) $initParam->getParamName(), (string) $initParam->getParamValue());
        }

        // initialize references from the passed deployment descriptor
        $this->referencesFromConfiguration($configuration);

        // return the instance
        return $this;
    }

    /**
     * Merges the passed configuration into this one. Configuration values
     * of the passed configuration will overwrite the this one.
     *
     * @param \AppserverIo\Description\Configuration\ServletConfigurationInterface $servletDescriptor The descriptor to merge
     *
     * @return void
     * @throws \AppserverIo\Psr\Servlet\ServletException Is thrown if you try to merge a servlet descriptor with a different class name
     */
    public function merge(ServletDescriptorInterface $servletDescriptor)
    {

        // check if the classes are equal
        if ($this->getName() !== $servletDescriptor->getName()) {
            throw new ServletException(
                sprintf('You try to merge a servlet descriptor for "%s" with "%s"', $this->getName(), $servletDescriptor->getName())
            );
        }

        // merge the servlet name
        if ($className = $servletDescriptor->getClassName()) {
            $this->setClassName($className);
        }

        // merge the servlet description
        if ($description = $servletDescriptor->getDescription()) {
            $this->setDescription($description);
        }

        // merge the servlet display name
        if ($displayName = $servletDescriptor->getDisplayName()) {
            $this->setDisplayName($displayName);
        }

        // merge the URL patterns
        foreach ($servletDescriptor->getUrlPatterns() as $urlPattern) {
            $this->addUrlPattern($urlPattern);
        }

        // merge the initialization parameters
        foreach ($servletDescriptor->getInitParams() as $paramKey => $paramValue) {
            $this->addInitParam($paramKey, $paramValue);
        }

        // merge the references
        $this->mergeReferences($servletDescriptor);
    }
}
