<?php

/**
 * AppserverIo\Description\AbstractDescriptor
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
use Doctrine\Common\Annotations\AnnotationReader;
use AppserverIo\Lang\Reflection\ClassInterface;
use AppserverIo\Lang\Reflection\MethodInterface;
use AppserverIo\Lang\Reflection\PropertyInterface;

/**
 * The most basic descriptor implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2017 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
abstract class AbstractDescriptor implements DescriptorInterface
{

    /**
     * The descriptor's description.
     *
     * @var string
     */
    protected $description;

    /**
     * The annotation reader instance singleton.
     *
     * @var \Doctrine\Common\Annotations\AnnotationReader
     */
    protected static $annotationReaderInstance;

    /**
     * Return's the annotation reader instance.
     *
     * @return \Doctrine\Common\Annotations\AnnotationReader
     */
    public function getAnnotationReader()
    {

        // query whether or not an instance already exists
        if (AbstractDescriptor::$annotationReaderInstance === null) {
            AbstractDescriptor::$annotationReaderInstance = new AnnotationReader();
        }

        // return the instance
        return AbstractDescriptor::$annotationReaderInstance;
    }

    /**
     * Return's the class annotation with the passed name, if available.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class to return the annotation for
     * @param string                                      $annotationName  The name of the annotation to return
     *
     * @return object|null The class annotation, or NULL if not available
     */
    protected function getClassAnnotation(ClassInterface $reflectionClass, $annotationName)
    {
        return $this->getAnnotationReader()->getClassAnnotation($reflectionClass->toPhpReflectionClass(), $annotationName);
    }

    /**
     * Return's the method annotation with the passed name, if available.
     *
     * @param \AppserverIo\Lang\Reflection\MethodInterface $reflectionMethod The reflection method to return the annotation for
     * @param string                                       $annotationName   The name of the annotation to return
     *
     * @return object|null The method annotation, or NULL if not available
     */
    protected function getMethodAnnotation(MethodInterface $reflectionMethod, $annotationName)
    {
        return $this->getAnnotationReader()->getMethodAnnotation($reflectionMethod->toPhpReflectionMethod(), $annotationName);
    }

    /**
     * Return's the property annotation with the passed name, if available.
     *
     * @param \AppserverIo\Lang\Reflection\MethodInterface $reflectionProperty The property method to return the annotation for
     * @param string                                       $annotationName     The name of the annotation to return
     *
     * @return object|null The property annotation, or NULL if not available
     */
    protected function getPropertyAnnotation(PropertyInterface $reflectionProperty, $annotationName)
    {
        return $this->getAnnotationReader()->getPropertyAnnotation($reflectionProperty->toPhpReflectionProperty(), $annotationName);
    }

    /**
     * Sets the reference description.
     *
     * @param string $description The reference description
     *
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the reference description.
     *
     * @return string The reference description
     */
    public function getDescription()
    {
        return $this->description;
    }
}
