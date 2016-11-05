<?php

/**
 * AppserverIo\Description\SingletonSessionBeanDescriptorTest
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
use AppserverIo\Psr\EnterpriseBeans\Annotations\Singleton;
use AppserverIo\Description\Api\Node\SessionNode;
use AppserverIo\Description\Api\Node\MessageDrivenNode;

/**
 * Test implementation for the SingletonSessionBeanDescriptor class implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 *
 * @Singleton
 * @Startup
 */
class SingletonSessionBeanDescriptorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The descriptor instance we want to test.
     *
     * @var \AppserverIo\Description\SingletonSessionBeanDescriptor
     */
    protected $descriptor;

    /**
     * Initializes the descriptor instance we want to test.
     *
     * @return void
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->descriptor = new SingletonSessionBeanDescriptor();
    }

    /**
     * Tests the static newDescriptorInstance() method.
     *
     * @return void
     */
    public function testNewDescriptorInstance()
    {
        $this->assertInstanceOf(
            'AppserverIo\Description\SingletonSessionBeanDescriptor',
            SingletonSessionBeanDescriptor::newDescriptorInstance()
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
        $aliases = array(Singleton::ANNOTATION => Singleton::__getClass());

        // create the reflection class
        $reflectionClass = new ReflectionClass(__CLASS__, array(), $aliases);

        // check that the descriptor has been initialized
        $this->assertSame($this->descriptor, $this->descriptor->fromReflectionClass($reflectionClass));
        $this->assertSame('SingletonSessionBeanDescriptorTest', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Description\SingletonSessionBeanDescriptorTest', $this->descriptor->getClassName());
        $this->assertTrue($this->descriptor->isInitOnStartup());
        $this->assertCount(0, $this->descriptor->getEpbReferences());
        $this->assertCount(0, $this->descriptor->getResReferences());
        $this->assertCount(0, $this->descriptor->getReferences());
    }

    /**
     * Tests that initialization from a reflection class without @Singleton
     * annotation won't work.
     *
     * @return void
     */
    public function testFromInvalidReflectionClass()
    {

        // initialize the annotation aliases
        $aliases = array(Singleton::ANNOTATION => Singleton::__getClass());

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
        $node = new SessionNode();
        $node->initFromFile(__DIR__ . '/_files/dd-singletonsessionbean.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // check that the descriptor has been initialized
        $this->assertSame('ASingletonProcessor', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Apps\Example\Services\ASingletonProcessor', $this->descriptor->getClassName());
        $this->assertTrue($this->descriptor->isInitOnStartup());
        $this->assertCount(0, $this->descriptor->getEpbReferences());
        $this->assertCount(0, $this->descriptor->getResReferences());
        $this->assertCount(0, $this->descriptor->getReferences());
        $this->assertCount(1, $this->descriptor->getPostConstructCallbacks());
        $this->assertCount(1, $this->descriptor->getPostDetachCallbacks());
        $this->assertCount(1, $this->descriptor->getPreAttachCallbacks());
    }

    /**
     * Tests that initialization from an wrong deployment descriptor, e. g. a
     * message driven bean, won't work.
     *
     * @return void
     */
    public function testFromConfigurationOtherBeanType()
    {

        // initialize the configuration
        $node = new MessageDrivenNode();
        $node->initFromFile(__DIR__ . '/_files/dd-messagedrivenbean.xml');

        // check that the descriptor has not been initialized
        $this->assertNull($this->descriptor->fromConfiguration($node));
    }

    /**
     * Tests that initialization from an invalid deployment descriptor won't work.
     *
     * @return void
     */
    public function testFromConfigurationInvalid()
    {

        // initialize the configuration
        $node = new SessionNode();
        $node->initFromFile(__DIR__ . '/_files/dd-statefulsessionbean.xml');

        // check that the descriptor has not been initialized
        $this->assertNull($this->descriptor->fromConfiguration($node));
    }

    /**
     * Tests that merging with a wrong deployment descriptor, e. g. a
     * message driven bean, won't work.
     *
     * @return void
     */
    public function testMergeInvalid()
    {

        // initialize the configuration
        $node = new SessionNode();
        $node->initFromFile(__DIR__ . '/_files/dd-singletonsessionbean.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // initialize the descriptor to merge
        $descriptorToMerge = $this->getMockForAbstractClass('AppserverIo\Description\StatefulSessionBeanDescriptor');

        $cloned = clone $this->descriptor;

        // merge the descriptors
        $this->descriptor->merge($descriptorToMerge);

        // check if all values have been merged
        $this->assertEquals($this->descriptor, $cloned);
    }

    /**
     * Tests if the merge method works successfully.
     *
     * @return void
     */
    public function testMergeSuccessful()
    {

        // initialize the configuration
        $node = new SessionNode();
        $node->initFromFile(__DIR__ . '/_files/dd-singletonsessionbean.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // initialize the descriptor to merge
        $descriptorToMerge = $this->getMockForAbstractClass('AppserverIo\Description\SingletonSessionBeanDescriptor');

        // initialize the configuration of the descriptor to be merged
        $nodeToMerge = new SessionNode();
        $nodeToMerge->initFromFile(__DIR__ . '/_files/dd-singletonsessionbean-to-merge.xml');
        $descriptorToMerge->fromConfiguration($nodeToMerge);

        // merge the descriptors
        $this->descriptor->merge($descriptorToMerge);

        // check if all values have been merged
        $this->assertSame('ASingletonProcessor', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Apps\Example\Services\ASingletonProcessor', $this->descriptor->getClassName());
        $this->assertFalse($this->descriptor->isInitOnStartup());
        $this->assertContains('newDetach', $this->descriptor->getPostDetachCallbacks());
        $this->assertContains('newAttach', $this->descriptor->getPreAttachCallbacks());
        $this->assertCount(0, $this->descriptor->getEpbReferences());
        $this->assertCount(0, $this->descriptor->getResReferences());
        $this->assertCount(0, $this->descriptor->getReferences());
        $this->assertCount(1, $this->descriptor->getPostConstructCallbacks());
        $this->assertCount(2, $this->descriptor->getPostDetachCallbacks());
        $this->assertCount(2, $this->descriptor->getPreAttachCallbacks());
    }

    /**
     * Tests the setter/getter for the pre-attach lifecycle callbacks.
     *
     * @return void
     */
    public function testSetGetPreAttachCallbacks()
    {
        $this->descriptor->setPreAttachCallbacks($preAttachCallbacks = array('attach'));
        $this->assertSame($preAttachCallbacks, $this->descriptor->getPreAttachCallbacks());
    }

    /**
     * Tests the setter/getter for the post-detach lifecycle callbacks.
     *
     * @return void
     */
    public function testSetGetPostDetachCallbacks()
    {
        $this->descriptor->setPostDetachCallbacks($postDetachCallbacks = array('attach'));
        $this->assertSame($postDetachCallbacks, $this->descriptor->getPostDetachCallbacks());
    }

    /**
     * Dummy method to test annotation parsing.
     *
     * @return void
     * @PostConstruct
     */
    public function postConstruct()
    {
    }

    /**
     * Dummy method to test annotation parsing.
     *
     * @return void
     * @PostDetach
     */
    public function postDetach()
    {
    }

    /**
     * Dummy method to test annotation parsing.
     *
     * @return void
     * @PreAttach
     */
    public function preAttach()
    {
    }
}
