<?php

/**
 * \AppserverIo\Description\Annotations\Mapping
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
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Description\Annotations;

/**
 * The annotation to parse the configuration nodes.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 *
 * @Annotation
 * @Target("PROPERTY")
 */
class Mapping
{

    /**
     * The tokens name.
     *
     * @var string
     */
    protected $name;

    /**
     * The node type.
     *
     * @var string
     */
    protected $nodeType;

    /**
     * The node name.
     *
     * @var string
     */
    protected $nodeName;

    /**
     * The element type.
     *
     * @var string
     */
    protected $elementType;

    /**
     * The attach method.
     *
     * @var string
     */
    protected $attachMethod;

    /**
     * The constructor the initializes the instance with the
     * data passed with the token.
     *
     * @param array $values The annotation values
     */
    public function __construct(array $values = array())
    {
        foreach ($values as $member => $value) {
            $this->$member = $value;
        }
    }

    /**
     * Return's the token name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return's the node type.
     *
     * @return string
     */
    public function getNodeType()
    {
        return $this->nodeType;
    }

    /**
     * Return's the node name.
     *
     * @return string
     */
    public function getNodeName()
    {
        return $this->nodeName;
    }

    /**
     * Returns the element type.
     *
     * @return string
     */
    public function getElementType()
    {
        return $this->elementType;
    }

    /**
     * Returns the attach method.
     *
     * @return string
     */
    public function getAttachMethod()
    {
        return $this->attachMethod;
    }
}
