<?php

/**
 * \AppserverIo\Description\Api\Node\EpbRefNode
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

use AppserverIo\Description\Configuration\EpbRefConfigurationInterface;
use AppserverIo\Description\Configuration\PositionAwareConfigurationInterface;

/**
 * DTO to transfer enterprise bean reference information.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class EpbRefNode extends AbstractNode implements EpbRefConfigurationInterface, PositionAwareConfigurationInterface
{

    /**
     * The trait to handle node positions.
     *
     * @var \AppserverIo\Description\Api\Node\PositionNodeTrait
     */
    use PositionNodeTrait;

    /**
     * The enterprise bean reference name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="epb-ref-name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $epbRefName;

    /**
     * The enterprise bean description information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="description", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $description;

    /**
     * The enterprise bean link information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="epb-link", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $epbLink;

    /**
     * The enterprise bean lookup name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="lookup-name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $lookupName;

    /**
     * The enterprise bean remote interface information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="remote", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $remote;

    /**
     * The enterprise bean local interface information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="local", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $local;

    /**
     * The enterprise bean injection target information.
     *
     * @var \AppserverIo\Description\Api\Node\InjectionTargetNode
     * @AS\Mapping(nodeName="injection-target", nodeType="AppserverIo\Description\Api\Node\InjectionTargetNode")
     */
    protected $injectionTarget;

    /**
     * Return's the enterprise bean reference name information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The enterprise bean reference name information
     */
    public function getEpbRefName()
    {
        return $this->epbRefName;
    }

    /**
     * Return's the enterprise bean description information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The enterprise bean description information
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Return's the enterprise bean link information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The enterprise bean link information
     */
    public function getEpbLink()
    {
        return $this->epbLink;
    }

    /**
     * Return's the enterprise bean lookup name information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The enterprise bean lookup name information
     */
    public function getLookupName()
    {
        return $this->lookupName;
    }

    /**
     * Return's the enterprise bean remote interface information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The enterprise bean remote interface information
     */
    public function getRemote()
    {
        return $this->remote;
    }

    /**
     * Return's the enterprise bean local interface information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The enterprise bean local interface information
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Return's the enterprise bean injection target information.
     *
     * @return \AppserverIo\Description\Api\Node\InjectionTargetNode The enterprise bean injection target information
     */
    public function getInjectionTarget()
    {
        return $this->injectionTarget;
    }
}
