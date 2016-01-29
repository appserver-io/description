<?php

/**
 * AppserverIo\Appserver\Core\Api\Node\AbstractNodeTest
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

namespace AppserverIo\Appserver\Core\Api\Node;

/**
 * Test for the abstract node implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class AbstractNodeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The mock instance of the abstract class.
     *
     * @var \AppserverIo\Appserver\Core\Api\Node\AppstractNode
     */
    protected $abstractNode;

    /**
     * Initializes an instance of the abstract class we want to test.
     *
     * @return void
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->abstractNode = $this->getMockForAbstractClass('AppserverIo\Description\Api\Node\AbstractNode');
    }

    /**
     * Tests the setter/getter for the UUID.
     *
     * @return void
     */
    public function testSetGetUuid()
    {
        $this->abstractNode->setUuid($uuid = 'f47ac10b-58cc-4372-a567-0e02b2c3d479');
        $this->assertSame($uuid, $this->abstractNode->getUuid());
    }

    /**
     * Tests the setter/getter for the UUID of the parent node.
     *
     * @return void
     */
    public function testSetGetParentUuid()
    {
        $this->abstractNode->setParentUuid($uuid = 'f47ac10b-58cc-4372-a567-0e02b2c3d479');
        $this->assertSame($uuid, $this->abstractNode->getParentUuid());
    }

    /**
     * Tests the getter for the primary key.
     *
     * @return void
     */
    public function testGetPrimaryKey()
    {
        $this->abstractNode->setUuid($uuid = 'f47ac10b-58cc-4372-a567-0e02b2c3d479');
        $this->assertSame($uuid, $this->abstractNode->getPrimaryKey());
    }

    /**
     * Tests the setter/getter for the node name.
     *
     * @return void
     */
    public function testSetGetNodeName()
    {
        $this->abstractNode->setNodeName($nodeName = 'testName');
        $this->assertSame($nodeName, $this->abstractNode->getNodeName());
    }

    /**
     * Test if the passed value implements the ValueInterface interface.
     *
     * @return void
     */
    public function testIsValueClass()
    {
        $mockValue = $this->getMockForAbstractClass('AppserverIo\Configuration\Interfaces\ValueInterface');
        $this->assertTrue($this->abstractNode->isValueClass(get_class($mockValue)));
    }

    /**
     * Tests if the export to a configuration instance works.
     *
     * @return void
     */
    public function testExportToConfiguration()
    {
        $this->abstractNode->setNodeName('params');
        $this->abstractNode->initFromFile(__DIR__ . '/_files/params.xml');
        $this->assertInstanceOf(
            'AppserverIo\Configuration\Interfaces\ConfigurationInterface',
            $this->abstractNode->exportToConfiguration()
        );
    }
}
