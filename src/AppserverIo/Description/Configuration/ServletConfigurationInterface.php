<?php

/**
 * AppserverIo\Description\Configuration\ServletConfigurationInterface
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

namespace AppserverIo\Description\Configuration;

/**
 * The interface for a servlet DTO implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
interface ServletConfigurationInterface extends ConfigurationInterface, ReferencesConfigurationInterface
{

    /**
     * Return's the description of the servlet.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface
     */
    public function getDescription();

    /**
     * Return's the display name of the servlet.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface
     */
    public function getDisplayName();

    /**
     * Return's the name of the servlet.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface
     */
    public function getServletName();

    /**
     * Return's the servlet class.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface
     */
    public function getServletClass();

    /**
     * Return's the servlet's initialization parameters.
     *
     * @return array The initialization parameters
     */
    public function getInitParams();
}
