<?php

/**
 * \AppserverIo\Description\Api\Node\MessageDrivenNode
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

use AppserverIo\Description\Configuration\MessageDrivenConfigurationInterface;

/**
 * DTO to transfer a message driven bean information.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class MessageDrivenNode extends AbstractNode implements MessageDrivenConfigurationInterface
{

    /**
     * The trait providing the reference information.
     *
     * @var \AppserverIo\Description\Api\Node\ReferencesNodeTrait
     */
    use ReferencesNodeTrait;

    /**
     * The enterprise bean name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="epb-name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $epbName;

    /**
     * The enterprise bean class information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="epb-class", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $epbClass;

    /**
     * The bean shared information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="shared", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $shared;

    /**
     * Return's the enterprise bean name information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The enterprise bean name information
     */
    public function getEpbName()
    {
        return $this->epbName;
    }

    /**
     * Return's the enterprise bean class information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The enterprise bean class information
     */
    public function getEpbClass()
    {
        return $this->epbClass;
    }

    /**
     * Return's the bean shared information.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface
     */
    public function getShared()
    {
        return $this->shared;
    }
}
