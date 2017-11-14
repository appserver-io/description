<?php

/**
 * AppserverIo\Description\Api\Node\AbstractValueNodeTest
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

/**
 * Test for the abstract value node implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2016 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class AbstractValueNodeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The mock instance of the abstract class.
     *
     * @var \AppserverIo\Description\Api\Node\AbstractValueNode
     */
    protected $abstractValueNode;

    /**
     * Initializes an instance of the abstract class we want to test.
     *
     * @return void
     * @see \PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->abstractValueNode = $this->getMockForAbstractClass('AppserverIo\Description\Api\Node\AbstractValueNode');
    }

    /**
     * Tests the setter/getter for the value node.
     *
     * @return void
     */
    public function testSetGetNodeValue()
    {
        $this->abstractValueNode->setNodeValue($nodeValue = new NodeValue());
        $this->assertSame($nodeValue, $this->abstractValueNode->getNodeValue());
    }
}
