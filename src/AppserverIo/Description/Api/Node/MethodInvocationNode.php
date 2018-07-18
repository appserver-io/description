<?php

/**
 * AppserverIo\Description\Api\Node\MethodInvocationNode
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
use AppserverIo\Description\Configuration\MethodInvocationConfigurationInterface;

/**
 * DTO to transfer the bean method invocation information.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class MethodInvocationNode extends AbstractNode implements MethodInvocationConfigurationInterface
{

    /**
     * The trait providing the reference information.
     *
     * @var \AppserverIo\Description\Api\Node\ReferencesNodeTrait
     */
    use ReferencesNodeTrait;

    /**
     * The method name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @DI\Mapping(nodeName="method-name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $methodName;

    /**
     * The method arguments.
     *
     * @var array
     * @DI\Mapping(nodeName="argument", nodeType="array", elementType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $arguments;

    /**
     * Return's the method name information.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * Return's the method arguments.
     *
     * @return array The method arguments
     */
    public function getArguments()
    {
        return $this->arguments;
    }
}
