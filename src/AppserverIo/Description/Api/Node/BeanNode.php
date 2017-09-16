<?php

/**
 * \AppserverIo\Description\Api\Node\BeanNode
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

use AppserverIo\Description\Configuration\BeanConfigurationInterface;

/**
 * DTO to transfer a bean configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class BeanNode extends AbstractNode implements BeanConfigurationInterface
{

    /**
     * The bean name information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="name", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $name;

    /**
     * The bean class information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="class", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $class;

    /**
     * Return's the bean name information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The bean name information
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return's the bean class information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The bean class information
     */
    public function getClass()
    {
        return $this->class;
    }
}
