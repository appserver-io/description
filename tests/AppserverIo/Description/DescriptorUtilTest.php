<?php

/**
 * AppserverIo\Description\DescriptorUtilTest
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
 * Test implementation for the DescriptorUtil class implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class DescriptorUtilTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests the utils trim() method.
     *
     * @return void
     */
    public function testTrimWithString()
    {
        $this->assertSame('test', DescriptorUtil::trim(' test '));
    }

    /**
     * Tests the utils trim() method.
     *
     * @return void
     * @expectedException \Exception
     */
    public function testTrimWithIntegerAndExpectException()
    {
        DescriptorUtil::trim(1);
    }
}
