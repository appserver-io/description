<?php

/**
 * AppserverIo\Description\StatefulSessionBeanDescriptorTest
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
use AppserverIo\Psr\EnterpriseBeans\Annotations\Stateful;
use AppserverIo\Psr\EnterpriseBeans\Annotations\PreAttach;
use AppserverIo\Psr\EnterpriseBeans\Annotations\PostDetach;
use AppserverIo\Description\Api\Node\SessionNode;
use AppserverIo\Description\Api\Node\MessageDrivenNode;

/**
 * Test implementation for the StatefulSessionBeanDescriptor class implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 *
 * @Stateful
 */
class StatefulSessionBeanDescriptorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The descriptor instance we want to test.
     *
     * @var \AppserverIo\Description\StatefulSessionBeanDescriptor
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
        $this->descriptor = new StatefulSessionBeanDescriptor();
    }

    /**
     * Tests the static newDescriptorInstance() method.
     *
     * @return void
     */
    public function testNewDescriptorInstance()
    {
        $this->assertInstanceOf(
            'AppserverIo\Description\StatefulSessionBeanDescriptor',
            StatefulSessionBeanDescriptor::newDescriptorInstance()
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
        $aliases = array(Stateful::ANNOTATION => Stateful::__getClass());

        // create the reflection class
        $reflectionClass = new ReflectionClass(__CLASS__, array(), $aliases);

        // check that the descriptor has been initialized
        $this->assertSame($this->descriptor, $this->descriptor->fromReflectionClass($reflectionClass));
        $this->assertSame('StatefulSessionBeanDescriptorTest', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Description\StatefulSessionBeanDescriptorTest', $this->descriptor->getClassName());
        $this->assertCount(0, $this->descriptor->getEpbReferences());
        $this->assertCount(0, $this->descriptor->getResReferences());
        $this->assertCount(0, $this->descriptor->getReferences());
        $this->assertCount(1, $this->descriptor->getPreAttachCallbacks());
        $this->assertCount(1, $this->descriptor->getPostDetachCallbacks());
    }

    /**
     * Tests that initialization from a reflection class without @Stateful
     * annotation won't work.
     *
     * @return void
     */
    public function testFromInvalidReflectionClass()
    {

        // initialize the annotation aliases
        $aliases = array(Stateful::ANNOTATION => Stateful::__getClass());

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
        $node->initFromFile(__DIR__ . '/_files/dd-statefulsessionbean.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // check that the descriptor has been initialized
        $this->assertSame($this->descriptor, $this->descriptor->fromConfiguration($node));
        $this->assertSame('UserProcessor', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Apps\Example\Services\UserProcessor', $this->descriptor->getClassName());

        // check for initialized lifecycle callbacks
        $this->assertContains('detach', $this->descriptor->getPostDetachCallbacks());
        $this->assertContains('attach', $this->descriptor->getPreAttachCallbacks());
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
        $node->initFromFile(__DIR__ . '/_files/dd-sessionbean.xml');

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
        $node->initFromFile(__DIR__ . '/_files/dd-statefulsessionbean.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // initialize the descriptor to merge
        $descriptorToMerge = $this->getMockForAbstractClass('AppserverIo\Description\StatelessSessionBeanDescriptor');

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
        $node->initFromFile(__DIR__ . '/_files/dd-statefulsessionbean.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // initialize the descriptor to merge
        $descriptorToMerge = $this->getMockForAbstractClass('AppserverIo\Description\StatefulSessionBeanDescriptor');

        // initialize the configuration of the descriptor to be merged
        $nodeToMerge = new SessionNode();
        $nodeToMerge->initFromFile(__DIR__ . '/_files/dd-statefulsessionbean-to-merge.xml');
        $descriptorToMerge->fromConfiguration($nodeToMerge);

        // merge the descriptors
        $this->descriptor->merge($descriptorToMerge);

        // check that the descriptor has been initialized
        $this->assertSame('UserProcessor', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Apps\Example\Services\UserProcessor', $this->descriptor->getClassName());
        $this->assertSame('Stateful', $this->descriptor->getSessionType());

        // check for initialized lifecycle callbacks
        $this->assertContains('newDetach', $this->descriptor->getPostDetachCallbacks());
        $this->assertContains('newAttach', $this->descriptor->getPreAttachCallbacks());
    }

    /**
     * Tests the setter/getter for the post-detach lifecycle callbacks.
     *
     * @return void
     */
    public function testSetGetPostConstructCallbacks()
    {
        $this->descriptor->setPostDetachCallbacks($postDetachCallbacks = array('detach'));
        $this->assertSame($postDetachCallbacks, $this->descriptor->getPostDetachCallbacks());
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
     * A dummy implemenatation for pre-attach method.
     *
     * @return void
     * @PreAttach
     */
    public function attach()
    {
        // dummy implementation
    }

    /**
     * A dummy implemenatation for post-detach method.
     *
     * @return void
     * @PostDetach
     */
    public function detach()
    {
        // dummy implementation
    }
}
