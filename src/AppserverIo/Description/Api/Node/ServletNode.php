<?php

/**
 * \AppserverIo\Description\Api\Node\ServletNode
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

use AppserverIo\Description\Configuration\ServletConfigurationInterface;

/**
 * DTO to transfer a session configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class ServletNode extends AbstractNode implements ServletConfigurationInterface
{

    /**
     * The description of the servlet.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="description", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $description;

    /**
     * The display name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="display-name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $displayName;

    /**
     * The servlet name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="servlet-name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $servletName;

    /**
     * The servlet class information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="servlet-class", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $servletClass;

    /**
     * The initialization parameter of the servlet.
     *
     * @var array
     * @AS\Mapping(nodeName="init-param", nodeType="array", elementType="AppserverIo\Description\Api\Node\InitParamNode")
     */
    protected $initParams = array();

    /**
     * The enterprise bean reference information.
     *
     * @var array
     * @AS\Mapping(nodeName="epb-ref", nodeType="array", elementType="AppserverIo\Description\Api\Node\EpbRefNode")
     */
    protected $epbRefs = array();

    /**
     * The resource reference information.
     *
     * @var array
     * @AS\Mapping(nodeName="res-ref", nodeType="array", elementType="AppserverIo\Description\Api\Node\ResRefNode")
     */
    protected $resRefs = array();

    /**
     * The class reference information.
     *
     * @var array
     * @AS\Mapping(nodeName="class-ref", nodeType="array", elementType="AppserverIo\Description\Api\Node\ClassRefNode")
     */
    protected $classRefs = array();

    /**
     * The persistence unit reference information.
     *
     * @var array
     * @AS\Mapping(nodeName="persistence-unit-ref", nodeType="array", elementType="AppserverIo\Description\Api\Node\PersistenceUnitRefNode")
     */
    protected $persistenceUnitRefs = array();

    /**
     * Return's the description of the servlet.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Return's the display name of the servlet.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The display name
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Return's the name of the servlet.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The servlet name
     */
    public function getServletName()
    {
        return $this->servletName;
    }

    /**
     * Return's the servlet class.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The servlet class
     */
    public function getServletClass()
    {
        return $this->servletClass;
    }

    /**
     * Return's the servlet's initialization parameters.
     *
     * @return array The initialization parameters
     */
    public function getInitParams()
    {
        return $this->initParams;
    }

    /**
     * Return's the enterprise bean reference information.
     *
     * @return array The enterprise bean reference information
     */
    public function getEpbRefs()
    {
        return $this->epbRefs;
    }

    /**
     * Return's the resource reference information.
     *
     * @return array The resource reference information
     */
    public function getResRefs()
    {
        return $this->resRefs;
    }

    /**
     * Return's the class reference information.
     *
     * @return array The class reference information
     */
    public function getClassRefs()
    {
        return $this->classRefs;
    }

    /**
     * Return's the persistence unit reference information.
     *
     * @return array The persistence unit reference information
     */
    public function getPersistenceUnitRefs()
    {
        return $this->persistenceUnitRefs;
    }
}
