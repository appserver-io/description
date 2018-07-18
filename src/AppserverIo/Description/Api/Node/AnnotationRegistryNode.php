<?php

/**
 * AppserverIo\Description\Api\Node\AnnotationRegistryNode
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

use AppserverIo\Description\Annotations as DI;
use AppserverIo\Description\Configuration\AnnotationRegistryConfigurationInterface;

/**
 * DTO to transfer a doctrine entity manager custom annotation configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2018 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class AnnotationRegistryNode extends AbstractNode implements AnnotationRegistryConfigurationInterface
{

    /**
     * A directories node trait.
     *
     * @var \AppserverIo\Description\Api\Node\DirectoriesNodeTrait
     */
    use DirectoriesNodeTrait;

    /**
     * The annotation registry's type.
     *
     * @var string
     * @DI\Mapping(nodeType="string")
     */
    protected $type;

    /**
     * The annotation registry's file.
     *
     * @var string
     * @DI\Mapping(nodeType="string")
     */
    protected $file;

    /**
     * The annotation registry's namespace.
     *
     * @var string
     * @DI\Mapping(nodeType="string")
     */
    protected $namespace;

    /**
     * Initializes the annotation registry configuration with the passed values.
     *
     * @param string $type      The annotation registry's type
     * @param string $file      The annotation registry's file
     * @param string $namespace The annotation registry's namespace
     */
    public function __construct($type = '', $file = '', $namespace = '')
    {
        $this->type = $type;
        $this->file = $file;
        $this->namespace = $namespace;
    }

    /**
     * Returns the fannotation registry's type.
     *
     * @return string The fannotation registry's type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the annotation registry's file.
     *
     * @return string The annotation registry's file
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Returns the annotation registry's namespace.
     *
     * @return string The annotation registry's namespace
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}
