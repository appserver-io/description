<?php

/**
 * \AppserverIo\Description\Api\Node\InitParamNode
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
 * @author    Bernhard Wick <bw@appserver.io>
 * @copyright 2018 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Description\Api\Node;

use AppserverIo\Description\Configuration\InitParamConfigurationInterface;

/**
 * DTO to transfer a the initialization parameter information.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @author    Bernhard Wick <bw@appserver.io>
 * @copyright 2018 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class InitParamNode extends AbstractNode implements InitParamConfigurationInterface
{

    /**
     * The parameter name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="param-name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $paramName;

    /**
     * The parameter value information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="param-value", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $paramValue;

    /**
     * Return's the parameter name information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The parameter name information
     */
    public function getParamName()
    {
        return $this->paramName;
    }

    /**
     * Return's the parameter value information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The parameter value information
     */
    public function getParamValue()
    {
        return $this->paramValue;
    }
}
