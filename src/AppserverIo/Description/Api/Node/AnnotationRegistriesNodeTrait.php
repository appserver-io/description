<?php

/**
 * AppserverIo\Description\Api\Node\AnnotationRegistriesNodeTrait
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
 * @author    Bernahrd Wick <bw@appserver.io>
 * @copyright 2018 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Description\Api\Node;

use AppserverIo\Description\Annotations as DI;

/**
 * Abstract node that a entity managers annotation registry nodes.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @author    Bernahrd Wick <bw@appserver.io>
 * @copyright 2018 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
trait AnnotationRegistriesNodeTrait
{

    /**
     * The entity managers annotation registries configuration.
     *
     * @var array
     * @DI\Mapping(nodeName="annotationRegistries/annotationRegistry", nodeType="array", elementType="AppserverIo\Description\Api\Node\AnnotationRegistryNode")
     */
    protected $annotationRegistries = array();

    /**
     * Sets the entity managers annotation registries configuration.
     *
     * @param array $annotationRegistries The entity managers annotation registries configuration
     *
     * @return void
     */
    public function setAnnotationRegistries($annotationRegistries)
    {
        $this->annotationRegistries = $annotationRegistries;
    }

    /**
     * Returns the entity managers annotation registries configuration.
     *
     * @return array The entity managers annotation registries configuration
     */
    public function getAnnotationRegistries()
    {
        return $this->annotationRegistries;
    }
}
