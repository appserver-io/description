<?php

/**
 * AppserverIo\Description\Api\Node\PersistenceUnitNode
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

namespace AppserverIo\Description\Api\Node;

use AppserverIo\Description\Configuration\PersistenceUnitConfigurationInterface;

/**
 * DTO to transfer a applications persistence unit configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2018 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class PersistenceUnitNode extends AbstractNode implements PersistenceUnitConfigurationInterface
{

    /**
     * A directories node trait.
     *
     * @var \AppserverIo\Description\Api\Node\DirectoriesNodeTrait
     */
    use DirectoriesNodeTrait;

    /**
     * A params node trait.
     *
     * @var \AppserverIo\Description\Api\Node\ParamsNodeTrait
     */
    use ParamsNodeTrait;

    /**
     * A annotation registries node trait.
     *
     * @var \AppserverIo\Appserver\Core\Api\Node\AnnotationRegistriesNodeTrait
     */
    use AnnotationRegistriesNodeTrait;

    /**
     * A ignored annotations node trait.
     *
     * @var \AppserverIo\Appserver\Core\Api\Node\IgnoredAnnotationsNodeTrait
     */
    use IgnoredAnnotationsNodeTrait;

    /**
     * The interface name the class loader has.
     *
     * @var string
     * @AS\Mapping(nodeType="string")
     */
    protected $interface;

    /**
     * The unique class loader name.
     *
     * @var string
     * @AS\Mapping(nodeType="string")
     */
    protected $name;

    /**
     * The class loaders class name.
     *
     * @var string
     * @AS\Mapping(nodeType="string")
     */
    protected $type;

    /**
     * The class loaders factory class name.
     *
     * @var string
     * @AS\Mapping(nodeType="string")
     */
    protected $factory;

    /**
     * The node containing datasource information.
     *
     * @var \AppserverIo\Psr\ApplicationServer\Configuration\DatasourceConfigurationInterface
     * @AS\Mapping(nodeName="datasource", nodeType="AppserverIo\Description\Api\Node\DatasourceNode")
     */
    protected $datasource;

    /**
     * The bean shared information.
     *
     * @var \AppserverIo\Description\Api\Node\ValueNode
     * @AS\Mapping(nodeName="shared", nodeType="AppserverIo\Description\Api\Node\ValueNode")
     */
    protected $shared;

    /**
     * The node containing the metadata configuration information.
     *
     * @var \AppserverIo\Description\Configuration\MetadataConfigurationInterface
     * @AS\Mapping(nodeName="metadataConfiguration", nodeType="AppserverIo\Description\Api\Node\MetadataConfigurationNode")
     */
    protected $metadataConfiguration;

    /**
     * The node containing the query cache configuration information.
     *
     * @var \AppserverIo\Description\Configuration\CacheConfigurationInterface
     * @AS\Mapping(nodeName="queryCacheConfiguration", nodeType="AppserverIo\Description\Api\Node\QueryCacheConfigurationNode")
     */
    protected $queryCacheConfiguration;

    /**
     * The node containing the result cache configuration information.
     *
     * @var \AppserverIo\Description\Configuration\CacheConfigurationInterface
     * @AS\Mapping(nodeName="resultCacheConfiguration", nodeType="AppserverIo\Description\Api\Node\ResultCacheConfigurationNode")
     */
    protected $resultCacheConfiguration;

    /**
     * The node containing the metadata cache configuration information.
     *
     * @var \AppserverIo\Description\Configuration\CacheConfigurationInterface
     * @AS\Mapping(nodeName="metadataCacheConfiguration", nodeType="AppserverIo\Description\Api\Node\MetadataCacheConfigurationNode")
     */
    protected $metadataCacheConfiguration;

    /**
     * Initialize the node with the default cache configuration.
     */
    public function __construct()
    {
        $this->queryCacheConfiguration = new QueryCacheConfigurationNode();
        $this->resultCacheConfiguration = new ResultCacheConfigurationNode();
        $this->metadataCacheConfiguration = new MetadataCacheConfigurationNode();
    }

    /**
     * Returns the entity manager's interface.
     *
     * @return string The entity manager's interface
     */
    public function getInterface()
    {
        return $this->name;
    }

    /**
     * Returns the entity manager's name.
     *
     * @return string The entity manager's name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the entity manager's class name.
     *
     * @return string The entity manager's class name
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the entity manager's factory class name.
     *
     * @return string The entity manager's factory class name
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Returns the entity manager's datasource configuration.
     *
     * @return \AppserverIo\Psr\ApplicationServer\Configuration\DatasourceConfigurationInterface The entity manager's datasource configuration
     */
    public function getDatasource()
    {
        return $this->datasource;
    }

    /**
     * Return's the bean shared information.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface
     */
    public function getShared()
    {
        return $this->shared;
    }

    /**
     * Returns the entity manager's metadata configuration.
     *
     * @return \AppserverIo\Description\Configuration\MetadataConfigurationInterface The entity manager's metadata configuration
     */
    public function getMetadataConfiguration()
    {
        return $this->metadataConfiguration;
    }

    /**
     * Returns the entity manager's query cache configuration.
     *
     * @return \AppserverIo\Description\Configuration\CacheConfigurationInterface The entity manager's query cache configuration
     */
    public function getQueryCacheConfiguration()
    {
        return $this->queryCacheConfiguration;
    }

    /**
     * Returns the entity manager's result cache configuration.
     *
     * @return \AppserverIo\Description\Configuration\CacheConfigurationInterface The entity manager's result cache configuration
     */
    public function getResultCacheConfiguration()
    {
        return $this->resultCacheConfiguration;
    }

    /**
     * Returns the entity manager's metadata cache configuration.
     *
     * @return \AppserverIo\Description\Configuration\CacheConfigurationInterface The entity manager's metadata cache configuration
     */
    public function getMetadataCacheConfiguration()
    {
        return $this->metadataCacheConfiguration;
    }
}
