<?php

/**
 * AppserverIo\Description\MessageDrivenBeanDescriptorTest
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

use AppserverIo\Lang\Reflection\ReflectionClass;
use AppserverIo\Psr\EnterpriseBeans\Annotations\MessageDriven;
use AppserverIo\Description\Api\Node\MessageDrivenNode;
use AppserverIo\Description\Api\Node\SessionNode;

/**
 * Test implementation for the MessageDrivenBeanDescriptor class implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 *
 * @MessageDriven
 */
class MessageDrivenBeanDescriptorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The descriptor instance we want to test.
     *
     * @var \AppserverIo\Description\MessageDrivenBeanDescriptor
     */
    protected $descriptor;

    /**
     * Initializes the descriptor instance we want to test.
     *
     * @return void
     * @see \PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->descriptor = new MessageDrivenBeanDescriptor();
    }

    /**
     * Tests the static newDescriptorInstance() method.
     *
     * @return void
     */
    public function testNewDescriptorInstance()
    {
        $this->assertInstanceOf(
            'AppserverIo\Description\MessageDrivenBeanDescriptor',
            MessageDrivenBeanDescriptor::newDescriptorInstance()
        );
    }

    /**
     * Tests that initialization from a reflection class works as expected.
     *
     * @return void
     */
    public function testFromReflectionClass()
    {

        // initialize the annotation aliases
        $aliases = array(MessageDriven::ANNOTATION => MessageDriven::__getClass());

        // create the reflection class
        $reflectionClass = new ReflectionClass(__CLASS__, array(), $aliases);

        // check that the descriptor has been initialized
        $this->assertSame($this->descriptor, $this->descriptor->fromReflectionClass($reflectionClass));
        $this->assertSame('MessageDrivenBeanDescriptorTest', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Description\MessageDrivenBeanDescriptorTest', $this->descriptor->getClassName());
        $this->assertCount(0, $this->descriptor->getEpbReferences());
        $this->assertCount(0, $this->descriptor->getResReferences());
        $this->assertCount(0, $this->descriptor->getReferences());
    }

    /**
     * Tests that initialization from a reflection class without @MessageDriven
     * annotation won't work.
     *
     * @return void
     */
    public function testFromInvalidReflectionClass()
    {

        // initialize the annotation aliases
        $aliases = array(MessageDriven::ANNOTATION => MessageDriven::__getClass());

        // create the reflection class
        $reflectionClass = new ReflectionClass('\stdClass', array(), $aliases);

        // check that the descriptor has not been initialized
        $this->assertNull($this->descriptor->fromReflectionClass($reflectionClass));
    }

    /**
     * Tests that initialization from a deployment descriptor class works as expected.
     *
     * @return void
     */
    public function testFromConfiguration()
    {

        // initialize the configuration
        $node = new MessageDrivenNode();
        $node->initFromFile(__DIR__ . '/_files/dd-messagedrivenbean.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // check that the descriptor has been initialized
        $this->assertSame($this->descriptor, $this->descriptor->fromConfiguration($node));
        $this->assertSame('ImportReceiver', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Apps\Example\MessageBeans\ImportReceiver', $this->descriptor->getClassName());
        $this->assertCount(0, $this->descriptor->getEpbReferences());
        $this->assertCount(0, $this->descriptor->getResReferences());
        $this->assertCount(0, $this->descriptor->getReferences());
    }

    /**
     * Tests that initialization from an invalid deployment descriptor won't work.
     *
     * @return void
     */
    public function testFromInvalidConfiguration()
    {

        // initialize the configuration
        $node = new SessionNode();
        $node->initFromFile(__DIR__ . '/_files/dd-statefulsessionbean.xml');

        // check that the descriptor has not been initialized
        $this->assertNull($this->descriptor->fromConfiguration($node));
    }
}
