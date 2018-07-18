<?php

/**
 * \AppserverIo\Description\Api\Node\BeanRefNode
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
use AppserverIo\Description\Configuration\BeanRefConfigurationInterface;
use AppserverIo\Description\Configuration\PositionAwareConfigurationInterface;

/**
 * DTO to transfer bean reference information.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class BeanRefNode extends AbstractNode implements BeanRefConfigurationInterface, PositionAwareConfigurationInterface
{

    /**
     * The trait to handle node positions.
     *
     * @var \AppserverIo\Description\Api\Node\PositionNodeTrait
     */
    use PositionNodeTrait;

    /**
     * The bean reference name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @DI\Mapping(nodeName="bean-ref-name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $beanRefName;

    /**
     * The bean link information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @DI\Mapping(nodeName="bean-link", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $beanLink;

    /**
     * The bean reference type information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @DI\Mapping(nodeName="bean-ref-type", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $beanRefType;

    /**
     * The bean description information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @DI\Mapping(nodeName="description", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $description;

    /**
     * The bean injection target information.
     *
     * @var \AppserverIo\Description\Api\Node\InjectionTargetNode
     * @DI\Mapping(nodeName="injection-target", nodeType="AppserverIo\Description\Api\Node\InjectionTargetNode")
     */
    protected $injectionTarget;

    /**
     * Return's the bean reference name information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The bean reference name information
     */
    public function getBeanRefName()
    {
        return $this->beanRefName;
    }

    /**
     * Return's the bean link information.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface The bean link information
     */
    public function getBeanLink()
    {
        return $this->beanLink;
    }

    /**
     * Return's the bean reference type information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The bean reference type information
     */
    public function getBeanRefType()
    {
        return $this->beanRefType;
    }

    /**
     * Return's the bean description information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The bean description information
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Return's the bean injection target information.
     *
     * @return \AppserverIo\Description\Api\Node\InjectionTargetNode The bean injection target information
     */
    public function getInjectionTarget()
    {
        return $this->injectionTarget;
    }
}
