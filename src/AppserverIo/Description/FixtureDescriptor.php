<?php

/**
 * AppserverIo\Description\FixtureDescriptor
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

use AppserverIo\Psr\EnterpriseBeans\Annotations\Fixture;
use AppserverIo\Psr\EnterpriseBeans\Description\FixtureDescriptorInterface;

/**
 * Fixture bean descriptor implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class FixtureDescriptor extends BeanDescriptor implements FixtureDescriptorInterface
{

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\FixtureDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new FixtureDescriptor();
    }

    /**
     * Return's the annoation class name.
     *
     * @return string The annotation class name
     */
    protected function getAnnotationClass()
    {
        return Fixture::class;
    }
}
