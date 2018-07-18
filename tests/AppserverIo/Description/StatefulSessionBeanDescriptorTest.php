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
use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;
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
 * @EPB\Stateful
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
     * @see \PHPUnit_Framework_TestCase::setUp()
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

        // create the reflection class
        $reflectionClass = new ReflectionClass(__CLASS__, array(), array());

        // check that the descriptor has been initialized
        $this->assertSame($this->descriptor, $this->descriptor->fromReflectionClass($reflectionClass));
        $this->assertSame('StatefulSessionBeanDescriptorTest', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Description\StatefulSessionBeanDescriptorTest', $this->descriptor->getClassName());
        $this->assertCount(0, $this->descriptor->getEpbReferences());
        $this->assertCount(0, $this->descriptor->getResReferences());
        $this->assertCount(0, $this->descriptor->getReferences());
        $this->assertCount(1, $this->descriptor->getPreAttachCallbacks());
        $this->assertCount(1, $this->descriptor->getPostDetachCallbacks());
        $this->assertCount(1, $this->descriptor->getPostActivateCallbacks());
        $this->assertCount(1, $this->descriptor->getPrePassivateCallbacks());
    }

    /**
     * Tests that initialization from a reflection class without Stateful
     * annotation won't work.
     *
     * @return void
     */
    public function testFromInvalidReflectionClass()
    {

        // create the reflection class
        $reflectionClass = new ReflectionClass('\stdClass', array(), array());

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
        $this->assertContains('newActivate', $this->descriptor->getPostActivateCallbacks());
        $this->assertContains('newPassivate', $this->descriptor->getPrePassivateCallbacks());
        $this->assertContains('logout', $this->descriptor->getRemoveMethods());
        $this->assertCount(2, $this->descriptor->getPostDetachCallbacks());
        $this->assertCount(2, $this->descriptor->getPreAttachCallbacks());
        $this->assertCount(2, $this->descriptor->getPostActivateCallbacks());
        $this->assertCount(2, $this->descriptor->getPrePassivateCallbacks());
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
     * Tests the setter/getter for the pre-passivate lifecycle callbacks.
     *
     * @return void
     */
    public function testSetGetPrePassivateCallbacks()
    {
        $this->descriptor->setPrePassivateCallbacks($prePassivateCallbacks = array('passivate'));
        $this->assertSame($prePassivateCallbacks, $this->descriptor->getPrePassivateCallbacks());
    }

    /**
     * Tests the setter/getter for the post-activate lifecycle callbacks.
     *
     * @return void
     */
    public function testSetGetPostActivateCallbacks()
    {
        $this->descriptor->setPostActivateCallbacks($postActivateCallbacks = array('activate'));
        $this->assertSame($postActivateCallbacks, $this->descriptor->getPostActivateCallbacks());
    }

    /**
     * Test the add/getter for the remove methods.
     *
     * @return void
     */
    public function testAddGetRemoveMethods()
    {
        $this->descriptor->addRemoveMethod('logout');
        $this->assertEquals(array('logout'), $this->descriptor->getRemoveMethods());
    }

    /**
     * Test if isRemoveMethod() method returns TRUE as expected.
     *
     * @return void
     */
    public function testIsRemoveMethodTrue()
    {
        $this->descriptor->addRemoveMethod($removeMethod = 'logout');
        $this->assertTrue($this->descriptor->isRemoveMethod($removeMethod));
    }

    /**
     * Test if isRemoveMethod() method returns FALSE as expected.
     *
     * @return void
     */
    public function testIsRemoveMethodFals()
    {
        $this->descriptor->addRemoveMethod('logout');
        $this->assertFalse($this->descriptor->isRemoveMethod('login'));
    }

    /**
     * A dummy implemenatation for pre-attach method.
     *
     * @return void
     * @EPB\PreAttach
     */
    public function attach()
    {
        // dummy implementation
    }

    /**
     * A dummy implemenatation for post-detach method.
     *
     * @return void
     * @EPB\PostDetach
     */
    public function detach()
    {
        // dummy implementation
    }

    /**
     * A dummy implemenatation for post-activate method.
     *
     * @return void
     * @EPB\PostActivate
     */
    public function activate()
    {
        // dummy implementation
    }

    /**
     * A dummy implemenatation for pre-passivate method.
     *
     * @return void
     * @EPB\PrePassivate
     */
    public function passivate()
    {
        // dummy implementation
    }

    /**
     * A dummy implementation for remove method.
     *
     * @return void
     * @EPB\Remove
     */
    public function logout()
    {
        // dummy implementation
    }
}
