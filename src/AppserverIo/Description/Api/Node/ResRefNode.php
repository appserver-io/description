<?php

/**
 * \AppserverIo\Description\Api\Node\ResRefNode
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

namespace AppserverIo\Description\Api\Node;

use AppserverIo\Description\Configuration\ResRefConfigurationInterface;

/**
 * DTO to transfer resource reference information.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class ResRefNode extends AbstractNode implements ResRefConfigurationInterface
{

    /**
     * The resource reference name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="res-ref-name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $resRefName;

    /**
     * The resource reference type information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="res-ref-type", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $resRefType;

    /**
     * The resource description information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="description", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $description;

    /**
     * The resource lookup name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="lookup-name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $lookupName;

    /**
     * The resource injection target information.
     *
     * @var \AppserverIo\Description\Api\Node\InjectionTargetNode
     * @AS\Mapping(nodeName="injection-target", nodeType="AppserverIo\Description\Api\Node\InjectionTargetNode")
     */
    protected $injectionTarget;

    /**
     * Return's the resource reference name information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The resource reference name information
     */
    public function getResRefName()
    {
        return $this->resRefName;
    }

    /**
     * Return's the resource reference type information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The resource reference type information
     */
    public function getResRefType()
    {
        return $this->resRefType;
    }

    /**
     * Return's the resource description information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The resource description information
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Return's the resource lookup name information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The resource lookup name information
     */
    public function getLookupName()
    {
        return $this->lookupName;
    }

    /**
     * Return's the resource injection target information.
     *
     * @return \AppserverIo\Description\Api\Node\InjectionTargetNode The resource injection target information
     */
    public function getInjectionTarget()
    {
        return $this->injectionTarget;
    }
}
