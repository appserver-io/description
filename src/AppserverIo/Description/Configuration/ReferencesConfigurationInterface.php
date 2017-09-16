<?php

/**
 * AppserverIo\Description\Configuration\ReferencesConfigurationInterface
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
 * The interface for a configuration containing references.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
interface ReferencesConfigurationInterface
{

    /**
     * Return's the enterprise bean reference information.
     *
     * @return array
     */
    public function getEpbRefs();

    /**
     * Return's the resource reference information.
     *
     * @return array
     */
    public function getResRefs();

    /**
     * Return's the persistence unit reference information.
     *
     * @return array
     */
    public function getPersistenceUnitRefs();
}
