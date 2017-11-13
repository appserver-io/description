<?php

/**
 * AppserverIo\Description\Configuration\FactoryConfigurationInterface
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
 * Interface for a enterprise bean reference DTO implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
interface FactoryConfigurationInterface extends ConfigurationInterface, ReferencesConfigurationInterface
{

    /**
     * Return's the factory name information.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface
     */
    public function getName();

    /**
     * Return's the factory class information.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface
     */
    public function getClass();

    /**
     * Return's the factory method information.
     *
     * @return \AppserverIo\Configuration\Interfaces\NodeValueInterface
     */
    public function getMethod();
}
