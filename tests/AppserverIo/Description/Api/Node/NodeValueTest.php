<?php

/**
 * AppserverIo\Appserver\Core\Api\Node\NodeValueTest
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
 * @copyright 2016 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Description\Api\Node;

use AppserverIo\Properties\Properties;

/**
 * Test for the node value implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2016 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class NodeValueTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The mock instance of the abstract class.
     *
     * @var \AppserverIo\Description\Api\Node\NodeValue
     */
    protected $nodeValue;

    protected $constructorValue = 'Test with property ${foo.bar}';

    /**
     * Initializes an instance of the node value class we want to test.
     *
     * @return void
     * @see \PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->nodeValue = new NodeValue($this->constructorValue);
    }

    /**
     * Tests the constructor and the getValue() method.
     *
     * @return void
     */
    public function testConstructorGetValue()
    {
        $this->assertSame($this->constructorValue, $this->nodeValue->getValue());
    }

    /**
     * Tests the __toString() method.
     *
     * @return void
     */
    public function testToString()
    {
        $this->assertSame($this->constructorValue, $this->nodeValue->__toString());
    }

    /**
     * Tests the value getter/setter method.
     *
     * @return void
     */
    public function testGetSetValue()
    {
        $this->nodeValue->setValue($newValue = 'Another Test');
        $this->assertSame($newValue, $this->nodeValue->getValue());
    }

    /**
     * Tests the initFromConfiguration() method.
     *
     * @return void
     */
    public function testInitFromConfiguration()
    {

        // initialize a mock configuration instance
        $mockConfiguration = $this->getMockBuilder($interface = 'AppserverIo\Configuration\Interfaces\ConfigurationInterface')
                                  ->setMethods(get_class_methods($interface))
                                  ->getMock();

        // mock the getValue() method
        $mockConfiguration->expects($this->once())
                          ->method('getValue')
                          ->willReturn($returnValue = 'Test with configuration');

        // initialize the node value
        $this->nodeValue->initFromConfiguration($mockConfiguration);

        // query wether or not the configuration value has been set
        $this->assertSame($returnValue, $this->nodeValue->getValue());
    }

    /**
     * Test the replaceProperties() method.
     *
     * @return void
     */
    public function testReplaceProperties()
    {

        // initialize the properties
        $properties = new Properties();
        $properties->setProperty('foo.bar', $propertyValue = 'foo.bar');

        // try to replace the variables in the node value's value
        $this->nodeValue->replaceProperties($properties);

        // assert that the property has been replaced
        $this->assertSame(str_replace('${foo.bar}', $propertyValue, $this->constructorValue), $this->nodeValue->getValue());
    }
}
