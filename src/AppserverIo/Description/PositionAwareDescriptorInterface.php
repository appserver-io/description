<?php

/**
 * AppserverIo\Description\PositionAwareDescriptorInterface
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

namespace AppserverIo\Description;

/**
 * Interface for the position aware descriptors, e. g. method arguments.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
interface PositionAwareDescriptorInterface
{

    /**
     * Return's the position of the node in the tree.
     *
     * @return integer The position
     */
    public function getPosition();

    /**
     * Set's the passed position of the node in the tree.
     *
     * @param integer $position The position
     *
     * @return void
     */
    public function setPosition($position);
}
