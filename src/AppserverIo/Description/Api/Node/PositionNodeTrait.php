<?php

/**
 * \AppserverIo\Description\Api\Node\PositionNodeTrait
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

/**
 * Trait for a node's position information.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
trait PositionNodeTrait
{

    /**
     * The nodes position in the tree.
     *
     * @var integer
     */
    protected $position;

    /**
     * Return's the position of the node in the tree.
     *
     * @return integer The position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set's the passed position of the node in the tree.
     *
     * @param integer $position The position
     *
     * @return void
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
}
