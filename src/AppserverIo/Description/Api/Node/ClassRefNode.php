<?php

/**
 * \AppserverIo\Description\Api\Node\ClassRefNode
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

use AppserverIo\Description\Configuration\ClassRefConfigurationInterface;

/**
 * DTO to transfer resource reference information.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class ClassRefNode extends AbstractNode implements ClassRefConfigurationInterface
{

    /**
     * The class reference name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="class-ref-name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $classRefName;

    /**
     * The class reference type information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="class-ref-type", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $classRefType;

    /**
     * The class description information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="description", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $description;

    /**
     * The class injection target information.
     *
     * @var \AppserverIo\Description\Api\Node\InjectionTargetNode
     * @AS\Mapping(nodeName="injection-target", nodeType="AppserverIo\Description\Api\Node\InjectionTargetNode")
     */
    protected $injectionTarget;

    /**
     * Return's the class reference name information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The class reference name information
     */
    public function getClassRefName()
    {
        return $this->classRefName;
    }

    /**
     * Return's the class reference type information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The class reference type information
     */
    public function getClassRefType()
    {
        return $this->classRefType;
    }

    /**
     * Return's the class description information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The class description information
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Return's the class injection target information.
     *
     * @return \AppserverIo\Description\Api\Node\InjectionTargetNode The class injection target information
     */
    public function getInjectionTarget()
    {
        return $this->injectionTarget;
    }
}
