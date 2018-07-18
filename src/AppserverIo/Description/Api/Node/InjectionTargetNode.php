<?php

/**
 * \AppserverIo\Description\Api\Node\InjectionTargetNode
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

use AppserverIo\Description\Annotations as DI;
use AppserverIo\Description\Configuration\InjectionTargetConfigurationInterface;

/**
 * DTO to transfer enterprise bean reference information.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class InjectionTargetNode extends AbstractNode implements InjectionTargetConfigurationInterface
{

    /**
     * The enterprise bean injection target class information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @DI\Mapping(nodeName="injection-target-class", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $injectionTargetClass;

    /**
     * The enterprise bean injection target method information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @DI\Mapping(nodeName="injection-target-method", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $injectionTargetMethod;

    /**
     * The enterprise bean injection target method parameter name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @DI\Mapping(nodeName="injection-target-method-parameter-name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $injectionTargetMethodParameterName;

    /**
     * The enterprise bean injection target property information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @DI\Mapping(nodeName="injection-target-property", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $injectionTargetProperty;

    /**
     * Return's the enterprise bean injection target class information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The enterprise bean injection target class information
     */
    public function getInjectionTargetClass()
    {
        return $this->injectionTargetClass;
    }

    /**
     * Return's the enterprise bean injection target method information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The enterprise bean injection target method information
     */
    public function getInjectionTargetMethod()
    {
        return $this->injectionTargetMethod;
    }

    /**
     * Return's the enterprise bean injection target method parameter name information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The enterprise bean injection target method parameter name information
     */
    public function getInjectionTargetMethodParameterName()
    {
        return $this->injectionTargetMethodParameterName;
    }

    /**
     * Return's the enterprise bean injection target property information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The enterprise bean injection target property information
     */
    public function getInjectionTargetProperty()
    {
        return $this->injectionTargetProperty;
    }
}
