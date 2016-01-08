<?php

/**
 * AppserverIo\Description\BeanDescriptor
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

/**
 * Abstract class for all bean descriptors.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class DescriptorUtil
{

    /**
     * This is a utility class, so protect it against direct
     * instantiation.
     *
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * This is a utility class, so protect it against cloning.
     *
     * @return void
     * @codeCoverageIgnore
     */
    private function __clone()
    {
    }

    /**
     * Trims and returns the passed value.
     *
     * @param string $value The value to trim
     *
     * @return string The trimmed value
     * @throws \Exception Is thrown if the passed value is not of type string
     */
    public static function trim($value)
    {
        if (is_string($value) === false) {
            throw new \Exception('Passed value is not of type string');
        }
        return trim($value);
    }
}
