<?php

/**
 * \AppserverIo\Appserver\Core\Api\Node\ValueNode
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

use AppserverIo\Configuration\Interfaces\ValueInterface;

/**
 * Generic implemenation of a DTO to transfer simple node values.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class ValueNode extends AbstractValueNode
{

    /**
     * Initializes the display name node with the necessary data.
     *
     * @param \AppserverIo\Configuration\Interfaces\ValueInterface $nodeValue The params initial value
     */
    public function __construct(ValueInterface $nodeValue = null)
    {

        // initialize the UUID
        $this->setUuid($this->newUuid());

        // set the data
        $this->nodeValue = $nodeValue;
    }
}
