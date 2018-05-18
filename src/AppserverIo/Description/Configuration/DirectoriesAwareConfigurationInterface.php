<?php

/**
 * \AppserverIo\Description\Api\Configuration\DirectoriesAwareConfigurationInterface
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
 * @copyright 2018 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Description\Configuration;

/**
 * Interface for configuration implementations with nodes having a directories/directory child.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
interface DirectoriesAwareConfigurationInterface
{

    /**
     * Array with the directories.
     *
     * @param array $directories The directories
     *
     * @return void
     */
    public function setDirectories(array $directories);

    /**
     * Array with the directories.
     *
     * @return array The array with the directories
     */
    public function getDirectories();

    /**
     * Returns an array with the directories as string value, each
     * prepended with the passed value.
     *
     * @param string $prepend Prepend to each directory
     *
     * @return array The array with the directories as string
     */
    public function getDirectoriesAsArray($prepend = null);
}
