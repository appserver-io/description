<?php

/**
 * \AppserverIo\Description\Api\Node\PersistenceUnitRefNode
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

use AppserverIo\Description\Configuration\PositionAwareConfigurationInterface;
use AppserverIo\Description\Configuration\PersistenceUnitRefConfigurationInterface;

/**
 * DTO to transfer persistence unit reference information.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class PersistenceUnitRefNode extends AbstractNode implements PersistenceUnitRefConfigurationInterface, PositionAwareConfigurationInterface
{

    /**
     * The trait to handle node positions.
     *
     * @var \AppserverIo\Description\Api\Node\PositionNodeTrait
     */
    use PositionNodeTrait;

    /**
     * The persistence unit reference name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="persistence-unit-ref-name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $persistenceUnitRefName;

    /**
     * The persistence unit name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="persistence-unit-name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $persistenceUnitName;

    /**
     * The persistence unit description information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="description", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $description;

    /**
     * The persistence unit injection target information.
     *
     * @var \AppserverIo\Description\Api\Node\InjectionTargetNode
     * @AS\Mapping(nodeName="injection-target", nodeType="AppserverIo\Description\Api\Node\InjectionTargetNode")
     */
    protected $injectionTarget;

    /**
     * Return's the persistence unit reference name information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The persitsence unit reference name information
     */
    public function getPersistenceUnitRefName()
    {
        return $this->persistenceUnitRefName;
    }

    /**
     * Return's the persistence unit name information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The persistence unit name information
     */
    public function getPersistenceUnitName()
    {
        return $this->persistenceUnitName;
    }

    /**
     * Return's the persistence unit description information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The persistence unit description information
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Return's the persistence unit injection target information.
     *
     * @return \AppserverIo\Description\Api\Node\InjectionTargetNode The persistence unit injection target information
     */
    public function getInjectionTarget()
    {
        return $this->injectionTarget;
    }
}
