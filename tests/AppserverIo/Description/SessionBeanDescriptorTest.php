<?php

/**
 * AppserverIo\Description\SessionBeanDescriptorTest
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

use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;
use AppserverIo\Lang\Reflection\ReflectionClass;
use AppserverIo\Description\Api\Node\SessionNode;
use AppserverIo\Description\Api\Node\MessageDrivenNode;

/**
 * Test implementation for the SessionBeanDescriptor class implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 *
 * @EPB\Stateless
 */
class SessionBeanDescriptorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The abstract descriptor instance we want to test.
     *
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $descriptor;

    /**
     * Dummy bean reference.
     *
     * @EPB\EnterpriseBean(name="SessionBean")
     */
    protected $dummyEnterpriseBean;

    /**
     * Dummy resource reference.
     *
     * @EPB\Resource(name="Application")
     */
    protected $dummyResource;

    /**
     * Initializes the descriptor instance we want to test.
     *
     * @return void
     * @see \PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->descriptor = $this->getMockBuilder('AppserverIo\Description\SessionBeanDescriptor')
            ->setMethods(array('getAnnotationClass'))
            ->getMockForAbstractClass();
    }

    /**
     * Injects the dummy bean instance.
     *
     * @param mixed $dummyEnterpriseBean The dummy bean
     *
     * @return void
     * @EPB\EnterpriseBean(name="SessionBean")
     */
    public function injectDummyEnterpriseBean($dummyEnterpriseBean)
    {
        $this->dummyEnterpriseBean = $dummyEnterpriseBean;
    }

    /**
     * Injects the dummy resource instance.
     *
     * @param mixed $dummyResource The dummy resource
     *
     * @return void
     * @EPB\Resource(name="Application")
     */
    public function injectDummyResource($dummyResource)
    {
        $this->dummyResource = $dummyResource;
    }

    /**
     * Dummy method to test lifecycle callback.
     *
     * @return void
     * @EPB\PostConstruct
     */
    public function initialize()
    {
    }

    /**
     * Dummy method to test lifecycle callback.
     *
     * @return void
     * @EPB\PreDestroy
     */
    public function destroy()
    {
    }

    /**
     * Tests the setter/getter for the pre-destroy lifecycle callbacks.
     *
     * @return void
     */
    public function testSetGetPreDestroyCallbacks()
    {
        $this->descriptor->setPreDestroyCallbacks($preDestroyCallbacks = array('destroy'));
        $this->assertSame($preDestroyCallbacks, $this->descriptor->getPreDestroyCallbacks());
    }

    /**
     * Tests the setter/getter for the post-construct lifecycle callbacks.
     *
     * @return void
     */
    public function testSetGetPostConstructCallbacks()
    {
        $this->descriptor->setPostConstructCallbacks($postConstructCallbacks = array('initialize'));
        $this->assertSame($postConstructCallbacks, $this->descriptor->getPostConstructCallbacks());
    }

    /**
     * Tests if the deployment initialization from a reflection class with a bean annotation
     * without the name attribute works as expected.
     *
     * @return void
     */
    public function testFromReflectionClass()
    {

        // create a reflection class
        $reflectionClass = new ReflectionClass(__CLASS__, array(), array());

        // mock the methods
        $this->descriptor->expects($this->once())
            ->method('getAnnotationClass')
            ->willReturn('AppserverIo\Psr\EnterpriseBeans\Annotations\Stateless');

        // initialize the descriptor instance
        $this->descriptor->fromReflectionClass($reflectionClass);

        // check the name parsed from the reflection class
        $this->assertSame(__CLASS__, $this->descriptor->getClassName());
        $this->assertSame('SessionBeanDescriptorTest', $this->descriptor->getName());
        $this->assertNull($this->descriptor->getSessionType());
        $this->assertCount(1, $this->descriptor->getEpbReferences());
        $this->assertCount(1, $this->descriptor->getResReferences());
        $this->assertCount(2, $this->descriptor->getReferences());

        // check for local/remote business interface has been initialized
        $this->assertSame('SessionBeanDescriptorTestLocal', $this->descriptor->getLocal());
        $this->assertSame('SessionBeanDescriptorTestRemote', $this->descriptor->getRemote());

        // check for initialized lifecycle callbacks
        $this->assertContains('initialize', $this->descriptor->getPostConstructCallbacks());
        $this->assertContains('destroy', $this->descriptor->getPreDestroyCallbacks());
    }

    /**
     * Tests if the deployment initialization from a deployment descriptor
     * works as expected.
     *
     * @return void
     */
    public function testFromConfiguration()
    {
        // initialize the configuration
        $node = new SessionNode();
        $node->initFromFile(__DIR__ . '/_files/dd-sessionbean-to-merge.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // check if all values have been initialized
        $this->assertSame('SampleProcessor', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Apps\Example\Services\SampleProcessor', $this->descriptor->getClassName());
        $this->assertSame('Stateless', $this->descriptor->getSessionType());
        $this->assertCount(1, $this->descriptor->getEpbReferences());
        $this->assertCount(1, $this->descriptor->getResReferences());
        $this->assertCount(1, $this->descriptor->getPersistenceUnitReferences());
        $this->assertCount(3, $this->descriptor->getReferences());

        // check for local/remote business interface has been initialized
        $this->assertSame('SampleProcessorLocalInterface', $this->descriptor->getLocal());
        $this->assertSame('SampleProcessorRemoteInterface', $this->descriptor->getRemote());

        // check for initialized lifecycle callbacks
        $this->assertContains('initializeIt', $this->descriptor->getPostConstructCallbacks());
        $this->assertContains('destroyIt', $this->descriptor->getPreDestroyCallbacks());
    }

    /**
     * Tests that initialization from an invalid deployment descriptor won't work.
     *
     * @return void
     */
    public function testFromConfigurationInvalid()
    {

        // initialize the configuration
        $node = new MessageDrivenNode();
        $node->initFromFile(__DIR__ . '/_files/dd-messagedrivenbean.xml');

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
        $descriptorToMerge = $this->getMockForAbstractClass('AppserverIo\Description\MessageDrivenBeanDescriptor');

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
        $node->initFromFile(__DIR__ . '/_files/dd-sessionbean.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // initialize the descriptor to merge
        $descriptorToMerge = $this->getMockForAbstractClass('AppserverIo\Description\SessionBeanDescriptor');

        // initialize the configuration of the descriptor to be merged
        $nodeToMerge = new SessionNode();
        $nodeToMerge->initFromFile(__DIR__ . '/_files/dd-sessionbean-to-merge.xml');
        $descriptorToMerge->fromConfiguration($nodeToMerge);

        // merge the descriptors
        $this->descriptor->merge($descriptorToMerge);

        // check if all values have been merged
        $this->assertSame('SampleProcessor', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Apps\Example\Services\SampleProcessor', $this->descriptor->getClassName());
        $this->assertSame('Stateless', $this->descriptor->getSessionType());
        $this->assertCount(2, $this->descriptor->getEpbReferences());
        $this->assertCount(3, $this->descriptor->getResReferences());
        $this->assertCount(2, $this->descriptor->getPersistenceUnitReferences());
        $this->assertCount(7, $this->descriptor->getReferences());

        // check for initialized lifecycle callbacks
        $this->assertContains('initialize', $this->descriptor->getPostConstructCallbacks());
        $this->assertContains('initializeIt', $this->descriptor->getPostConstructCallbacks());
        $this->assertContains('destroy', $this->descriptor->getPreDestroyCallbacks());
        $this->assertContains('destroyIt', $this->descriptor->getPreDestroyCallbacks());
    }
}
