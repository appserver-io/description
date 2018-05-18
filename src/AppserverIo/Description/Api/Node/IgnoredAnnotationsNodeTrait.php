<?php

/**
 * AppserverIo\Description\Api\Node\IgnoredAnnotationsNodeTrait
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
 * @copyright 2018 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Description\Api\Node;

/**
 * Abstract node that serves nodes having a ignoredAnnotations/ignoredAnnotation child.
 *
 * @author    Bernhard Wick <bw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
trait IgnoredAnnotationsNodeTrait
{

    /**
     * The directories.
     *
     * @var array
     * @AS\Mapping(nodeName="ignoredAnnotations/ignoredAnnotation", nodeType="array", elementType="AppserverIo\Description\Api\Node\IgnoredAnnotationNode")
     */
    protected $ignoredAnnotations = array();

    /**
     * Array with the ignored annotations.
     *
     * @param array $ignoredAnnotations The ignored annotations
     *
     * @return void
     */
    public function setIgnoredAnnotations(array $ignoredAnnotations)
    {
        $this->ignoredAnnotations = $ignoredAnnotations;
    }

    /**
     * Array with the ignored annotations.
     *
     * @return array The array with the ignored annotations
     */
    public function getIgnoredAnnotations()
    {
        return $this->ignoredAnnotations;
    }

    /**
     * Returns an array with the ignored annotation as string value, each
     * prepended with the passed value.
     *
     * @param string $prepend Prepend to each ignored annotation
     *
     * @return array The array with the ignored annotations as string
     */
    public function getIgnoredAnnotationsAsArray($prepend = null)
    {
        $ignoredAnnotations = array();
        foreach ($this->getIgnoredAnnotations() as $ignoredAnnotation) {
            $ignoredAnnotations[] = sprintf('%s%s', $prepend, $ignoredAnnotation->getNodeValue()->__toString());
        }
        return $ignoredAnnotations;
    }
}
