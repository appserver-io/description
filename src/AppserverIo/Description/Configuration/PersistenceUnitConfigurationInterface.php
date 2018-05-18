<?php

/**
 * \AppserverIo\Description\Api\Configuration\PersistenceUnitConfigurationInterface
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

use AppserverIo\Configuration\Interfaces\NodeInterface;

/**
 * Interface for the persistence unit node information.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2018 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
interface PersistenceUnitConfigurationInterface extends NodeInterface, ConfigurationInterface, ParamsAwareConfigurationInterface, DirectoriesAwareConfigurationInterface
{

    /**
     * Returns the entity managers annotation registries configuration.
     *
     * @return array The entity managers annotation registries configuration
     */
    public function getAnnotationRegistries();

    /**
     * Returns the entity manager's interface.
     *
     * @return string The entity manager's interface
     */
    public function getInterface();

    /**
     * Returns the entity manager's name.
     *
     * @return string The entity manager's name
     */
    public function getName();

    /**
     * Returns the entity manager's class name.
     *
     * @return string The entity manager's class name
     */
    public function getType();

    /**
     * Returns the entity manager's factory class name.
     *
     * @return string The entity manager's factory class name
     */
    public function getFactory();

    /**
     * Returns the entity manager's datasource configuration.
     *
     * @return \AppserverIo\Psr\ApplicationServer\Configuration\DatasourceConfigurationInterface The entity manager's datasource configuration
     */
    public function getDatasource();

    /**
     * Returns the entity manager's metadata configuration.
     *
     * @return \AppserverIo\Description\Configuration\MetadataConfigurationInterface The entity manager's metadata configuration
     */
    public function getMetadataConfiguration();

    /**
     * Returns the entity manager's query cache configuration.
     *
     * @return \AppserverIo\Description\Configuration\MetadataConfigurationInterface The entity manager's query cache configuration
     */
    public function getQueryCacheConfiguration();

    /**
     * Returns the entity manager's result cache configuration.
     *
     * @return \AppserverIo\Description\Configuration\MetadataConfigurationInterface The entity manager's result cache configuration
     */
    public function getResultCacheConfiguration();

    /**
     * Returns the entity manager's metadata cache configuration.
     *
     * @return \AppserverIo\Description\Configuration\CacheConfigurationInterface The entity manager's metadata cache configuration
     */
    public function getMetadataCacheConfiguration();
}
