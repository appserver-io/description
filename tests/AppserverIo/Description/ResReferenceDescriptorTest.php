<?php

/**
 * AppserverIo\Description\ResReferenceDescriptorTest
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
use AppserverIo\Description\Api\Node\ResRefNode;
use AppserverIo\Psr\EnterpriseBeans\Annotations\Resource;

/**
 * Test implementation for the ResReferenceDescriptorTest class implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class ResReferenceDescriptorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The descriptor instance we want to test.
     *
     * @var \AppserverIo\Description\ResReferenceDescriptorTest
     */
    protected $descriptor;

    /**
     * Dummy resource reference.
     *
     * @Resource(type="TimerServiceContextInterface", description="Reference to a timer service", lookup="php:global/example/TimerServiceContextInterface")
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

        // create a mock object for the parent instance
        $parent = $this->getMockBuilder($nameAwareInterface = 'AppserverIo\Psr\EnterpriseBeans\Description\NameAwareDescriptorInterface')
                       ->setMethods(get_class_methods($nameAwareInterface))
                       ->getMock();

        // mock the getName() method
        $parent->expects($this->any())
               ->method('getName')
               ->willReturn('SomeBean');

        // initialize the descriptor
        $this->descriptor = new ResReferenceDescriptor($parent);
    }

    /**
     * Injects the dummy resource instance.
     *
     * @param mixed $dummyResource The dummy resource
     *
     * @return void
     * @Resource
     */
    public function injectDummyResource($dummyResource)
    {
        $this->dummyResource = $dummyResource;
    }

    /**
     * Injects the dummy resource instance.
     *
     * @param mixed $dummyResource The dummy resource
     *
     * @return void
     * @Resource(type="TimerServiceContextInterface", description="Reference to a timer service", lookup="php:global/example/TimerServiceContextInterface")
     */
    public function injectDummyResourceWithAttributes($dummyResource)
    {
        $this->dummyResource = $dummyResource;
    }

    /**
     * Tests the static newDescriptorInstance() method.
     *
     * @return void
     */
    public function testNewDescriptorInstance()
    {
        $this->assertInstanceOf(
            'AppserverIo\Description\ResReferenceDescriptor',
            ResReferenceDescriptor::newDescriptorInstance($this->getMock('AppserverIo\Psr\EnterpriseBeans\Description\NameAwareDescriptorInterface'))
        );
    }

    /**
     * Test the the fromReflectionClass() methods has not yet been implemented.
     *
     * @return void
     * @expectedException \Exception
     */
    public function testFromReflectionClass()
    {
        $this->descriptor->fromReflectionClass(new ReflectionClass('\stdClass'));
    }

    /**
     * Test that initization with the fromReflectionProperty() method
     * and an annotation works as expected.
     *
     * @return void
     */
    public function testFromReflectionPropertyAndAnnotationWithAttributes()
    {

        // initialize the reflection property
        $reflectionProperty = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionProperty')
                                   ->setConstructorArgs(array(__CLASS__, array(), array()))
                                   ->setMethods( array('getClassName', 'getPropertyName'))
                                   ->getMock();

        // mock the methods
        $reflectionProperty
            ->expects($this->exactly(2))
            ->method('getClassName')
            ->will($this->returnValue(__CLASS__));
        $reflectionProperty
            ->expects($this->exactly(3))
            ->method('getPropertyName')
            ->will($this->returnValue('dummyResource'));

        // initialize the descriptor from the reflection property
        $this->descriptor->fromReflectionProperty($reflectionProperty);

        // check that the descriptor has been initialized successfully
        $this->assertSame('DummyResource', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/DummyResource', $this->descriptor->getRefName());
        $this->assertSame('Reference to a timer service', $this->descriptor->getDescription());
        $this->assertSame('php:global/example/TimerServiceContextInterface', $this->descriptor->getLookup());
        $this->assertSame('TimerServiceContextInterface', $this->descriptor->getType());
    }

    /**
     * Test that initization with the fromReflectionMethod() method
     * and an empty annotation works as expected.
     *
     * @return void
     */
    public function testFromReflectionMethodAndAnnotationWithoutAttributes()
    {

        // initialize the reflection method
        $reflectionMethod = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionMethod')
                                 ->setConstructorArgs(array(__CLASS__, array(), array()))
                                 ->setMethods(array('getClassName', 'getMethodName'))
                                 ->getMock();

        // mock the methods
        $reflectionMethod
            ->expects($this->exactly(4))
            ->method('getClassName')
            ->will($this->returnValue(__CLASS__));
        $reflectionMethod
            ->expects($this->exactly(4))
            ->method('getMethodName')
            ->will($this->returnValue('injectDummyResource'));

        // initialize the descriptor from the reflection method
        $this->descriptor->fromReflectionMethod($reflectionMethod);

        // check that the descriptor has been initialized successfully
        $this->assertSame('DummyResource', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/DummyResource', $this->descriptor->getRefName());
        $this->assertNull($this->descriptor->getDescription());
        $this->assertNull($this->descriptor->getLookup());
    }

    /**
     * Test that initization with the fromReflectionMethod() method
     * and an empty annotation works as expected.
     *
     * @return void
     */
    public function testFromReflectionMethodAndAnnotationWithAttributes()
    {

        // initialize the reflection method
        $reflectionMethod = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionMethod')
                                 ->setConstructorArgs(array(__CLASS__, array(), array()))
                                 ->setMethods(array('getClassName', 'getMethodName'))
                                 ->getMock();

        // mock the methods
        $reflectionMethod
            ->expects($this->exactly(4))
            ->method('getClassName')
            ->will($this->returnValue(__CLASS__));
        $reflectionMethod
            ->expects($this->exactly(4))
            ->method('getMethodName')
            ->will($this->returnValue('injectDummyResourceWithAttributes'));

        // initialize the descriptor from the reflection method
        $this->descriptor->fromReflectionMethod($reflectionMethod);

        // check that the descriptor has been initialized successfully
        $this->assertSame('DummyResource', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/DummyResource', $this->descriptor->getRefName());
        $this->assertSame('Reference to a timer service', $this->descriptor->getDescription());
        $this->assertSame('php:global/example/TimerServiceContextInterface', $this->descriptor->getLookup());
        $this->assertSame('TimerServiceContextInterface', $this->descriptor->getType());
    }

    /**
     * Initializes the descriptor from a deployment descriptor.
     *
     * @return void
     */
    public function testFromConfiguration()
    {

        // initialize the configuration
        $node = new ResRefNode();
        $node->initFromFile(__DIR__ . '/_files/dd-res-ref.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // check if all values have been initialized
        $this->assertSame('TimerServiceContextInterface', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/TimerServiceContextInterface', $this->descriptor->getRefName());
        $this->assertSame('php:global/example/TimerServiceContextInterface', $this->descriptor->getLookup());
        $this->assertSame('AppserverIo\Psr\Timer\TimerServiceContextInterface', $this->descriptor->getType());
        $this->assertSame('Reference to a timer service', $this->descriptor->getDescription());
        $this->assertInstanceOf('AppserverIo\Description\InjectionTargetDescriptor', $this->descriptor->getInjectionTarget());
    }

    /**
     * Tests if the merge method works successfully.
     *
     * @return void
     */
    public function testMergeSuccessful()
    {

        // initialize the configuration
        $node = new ResRefNode();
        $node->initFromFile(__DIR__ . '/_files/dd-res-ref.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // initialize the descriptor to merge
        $descriptorToMerge = $this->getMockBuilder('AppserverIo\Description\ResReferenceDescriptor')
                                  ->disableOriginalConstructor()
                                  ->getMockForAbstractClass();

        // initialize the configuration of the descriptor to be merged
        $nodeToMerge = new ResRefNode();
        $nodeToMerge->initFromFile(__DIR__ . '/_files/dd-res-ref-to-merge.xml');
        $descriptorToMerge->fromConfiguration($nodeToMerge);

        // merge the descriptors
        $this->descriptor->merge($descriptorToMerge);

        // check if all values have been initialized
        $this->assertSame('MyTimerServiceContextInterface', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/MyTimerServiceContextInterface', $this->descriptor->getRefName());
        $this->assertSame('Another reference to a timer service', $this->descriptor->getDescription());
        $this->assertSame('php:global/example/MyTimerServiceContextInterface', $this->descriptor->getLookup());
        $this->assertSame('AppserverIo\Psr\Timer\MyTimerServiceContextInterface', $this->descriptor->getType());
        $this->assertInstanceOf('AppserverIo\Description\InjectionTargetDescriptor', $injectTarget = $this->descriptor->getInjectionTarget());
        $this->assertSame('AppserverIo\Apps\Example\Services\MySampleProcessor', $injectTarget->getTargetClass());
        $this->assertSame('injectTimerService', $injectTarget->getTargetMethod());
        $this->assertNull($injectTarget->getTargetProperty());
    }
}
