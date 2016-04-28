<?php

/**
 * \AppserverIo\Description\Api\Node\RemoveMethodNode
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
 * @copyright 2016 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Description\Api\Node;

use AppserverIo\Description\Configuration\RemoveMethodConfigurationInterface;

/**
 * DTO to transfer remove method information.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2016 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class RemoveMethodNode extends AbstractNode implements RemoveMethodConfigurationInterface
{

    /**
     * The remove methods information.
     *
     * @var array
     * @AS\Mapping(nodeName="method-name", nodeType="array", elementType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $methodNames;

    /**
     * Return's the remove methods information.
     *
     * @return array The remove methods information
     */
    public function getMethodNames()
    {
        return $this->methodNames;
    }
}
