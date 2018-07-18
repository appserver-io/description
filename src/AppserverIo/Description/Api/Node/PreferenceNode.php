<?php

/**
 * \AppserverIo\Description\Api\Node\PreferenceNode
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
use AppserverIo\Description\Configuration\PreferenceConfigurationInterface;

/**
 * DTO to transfer a bean configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class PreferenceNode extends AbstractNode implements PreferenceConfigurationInterface
{

    /**
     * The preference interface information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @DI\Mapping(nodeName="interface", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $interface;

    /**
     * The preference class information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @DI\Mapping(nodeName="class", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $class;

    /**
     * Return's the preference interface information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The preference interface information
     */
    public function getInterface()
    {
        return $this->interface;
    }

    /**
     * Return's the preference class information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The preference class information
     */
    public function getClass()
    {
        return $this->class;
    }
}
