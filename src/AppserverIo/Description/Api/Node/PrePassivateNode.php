<?php

/**
 * \AppserverIo\Description\Api\Node\PrePassivateNode
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
use AppserverIo\Description\Configuration\PrePassivateConfigurationInterface;

/**
 * DTO to transfer pre passivate information.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class PrePassivateNode extends AbstractNode implements PrePassivateConfigurationInterface
{

    /**
     * The lifecycle callback methods information.
     *
     * @var array
     * @DI\Mapping(nodeName="lifecycle-callback-method", nodeType="array", elementType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $lifecycleCallbackMethods;

    /**
     * Return's the lifecycle callback methods information.
     *
     * @return array The lifecycle callback methods information
     */
    public function getLifecycleCallbackMethods()
    {
        return $this->lifecycleCallbackMethods;
    }
}
