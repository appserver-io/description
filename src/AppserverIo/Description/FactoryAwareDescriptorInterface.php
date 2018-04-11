<?php

/**
 * AppserverIo\Description\FactoryAwareDescriptorInterface
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

use AppserverIo\Psr\EnterpriseBeans\Description\FactoryDescriptorInterface;

/**
 * Interface for factory aware descriptor implementations.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2017 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
interface FactoryAwareDescriptorInterface
{

    /**
     * Sets the factory that creates the bean.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\FactoryDescriptorInterface $factory The bean's factory
     *
     * @return void
     */
    public function setFactory(FactoryDescriptorInterface $factory);

    /**
     * Returns the factory that creates the bean.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\FactoryDescriptorInterface The bean's factory
     */
    public function getFactory();
}
