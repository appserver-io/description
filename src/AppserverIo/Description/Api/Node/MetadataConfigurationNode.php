<?php

/**
 * AppserverIo\Description\Api\Node\MetadataConfigurationNode
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

/**
 * DTO to transfer an entity manager's metadata configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2018 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class MetadataConfigurationNode extends AbstractNode
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
     * The class name for the metadata configuration driver.
     *
     * @var string
     * @AS\Mapping(nodeType="string")
     */
    protected $type;

    /**
     * The factory class name for the metadata configuration driver.
     *
     * @var string
     * @AS\Mapping(nodeType="string")
     */
    protected $factory;

    /**
     * Returns the class name for the metadata configuration driver.
     *
     * @return string The class name for the metadata configuration driver
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the factory class name for the metadata configuration driver.
     *
     * @return string The factory class name for the metadata configuration driver
     */
    public function getFactory()
    {
        return $this->factory;
    }
}
