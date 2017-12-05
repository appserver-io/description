<?php

/**
 * AppserverIo\Description\AbstractDescriptor
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
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Description;

use AppserverIo\Psr\Deployment\DescriptorInterface;

/**
 * The most basic descriptor implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2017 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
abstract class AbstractDescriptor implements DescriptorInterface
{

    /**
     * The descriptor's description.
     *
     * @var string
     */
    protected $description;

    /**
     * Sets the reference description.
     *
     * @param string $description The reference description
     *
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the reference description.
     *
     * @return string The reference description
     */
    public function getDescription()
    {
        return $this->description;
    }
}
