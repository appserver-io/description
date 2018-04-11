<?php

/**
 * AppserverIo\Description\Configuration\SessionConfigurationInterface
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
 * Interface for the session bean node information.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
interface SessionConfigurationInterface extends EnterpriseBeanConfigurationInterface, ReferencesConfigurationInterface
{

    /**
     * Return's the session bean type information.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface
     */
    public function getSessionType();

    /**
     * Return's the init on startup information.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface
     */
    public function getInitOnStartup();

    /**
     * Return's the post construct information.
     *
     * @return \AppserverIo\Description\Configuration\PostConstructConfigurationInterface
     */
    public function getPostConstruct();

    /**
     * Return's the pre destroy information.
     *
     * @return \AppserverIo\Description\Configuration\PreDestroyConfigurationInterface
     */
    public function getPreDestroy();

    /**
     * Return's the post detach information.
     *
     * @return \AppserverIo\Description\Configuration\PostDetachConfigurationInterface
     */
    public function getPostDetach();

    /**
     * Return's the pre attach information.
     *
     * @return \AppserverIo\Description\Configuration\PreAttachConfigurationInterface
     */
    public function getPreAttach();

    /**
     * Return's the post activate information.
     *
     * @return \AppserverIo\Description\Configuration\PostActivateConfigurationInterface
     */
    public function getPostActivate();

    /**
     * Return's the pre passivate information.
     *
     * @return \AppserverIo\Description\Configuration\PrePassivateConfigurationInterface
     */
    public function getPrePassivate();

    /**
     * Return's the enterprise bean remote interface information.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface
     */
    public function getRemote();

    /**
     * Return's the enterprise bean local interface information.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface
     */
    public function getLocal();
}
