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
use AppserverIo\Lang\Reflection\ReflectionMethod;
use AppserverIo\Lang\Reflection\ReflectionProperty;
use AppserverIo\Psr\EnterpriseBeans\Annotations\Resource;
use AppserverIo\Description\Api\Node\ResRefNode;

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
     * Dummy bean reference.
     *
     * @EnterpriseBean(name="SessionBean")
     */
    protected $dummyEnterpriseBean;

    /**
     * Dummy resource reference.
     *
     * @Resource(name="Application")
     */
    protected $dummyResource;

    /**
     * Initializes the descriptor instance we want to test.
     *
     * @return void
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->descriptor = new ResReferenceDescriptor();
    }

    /**
     * Injects the dummy bean instance.
     *
     * @param mixed $dummyEnterpriseBean The dummy bean
     *
     * @return void
     * @EnterpriseBean(name="SessionBean")
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
     * @Resource(name="Application")
     */
    public function injectDummyResource($dummyResource)
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
            ResReferenceDescriptor::newDescriptorInstance()
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

        // prepare the empty annotation values
        $values = array(
            'type' => 'AppserverIo\Psr\Timer\TimerServiceContextInterface',
            'lookup' => 'php:global/example/TimerServiceContextInterface',
            'description' => 'Reference to a timer service'
        );

        // create a mock annotation implementation
        $beanAnnotation = $this->getMockBuilder('AppserverIo\Psr\EnterpriseBeans\Annotations\Resource')
            ->setConstructorArgs(array('Resource', $values))
            ->getMockForAbstractClass();

        // create a mock annotation
        $annotation = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionAnnotation')
            ->setMethods(array('getAnnotationName', 'getValues', 'newInstance'))
            ->setConstructorArgs(array('Resource', $values))
            ->getMock();

        // mock the ReflectionAnnotation methods
        $annotation
            ->expects($this->once())
            ->method('getAnnotationName')
            ->will($this->returnValue('EnterpriseBean'));
        $annotation
            ->expects($this->once())
            ->method('getValues')
            ->will($this->returnValue($values));
        $annotation
            ->expects($this->once())
            ->method('newInstance')
            ->will($this->returnValue($beanAnnotation));

        // initialize the annotation aliases
        $aliases = array(Resource::ANNOTATION => Resource::__getClass());

        // initialize the reflection property
        $reflectionProperty = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionProperty')
                                   ->setConstructorArgs(array(__CLASS__, array(), $aliases))
                                   ->setMethods(
                                       array(
                                           'hasAnnotation',
                                           'getAnnotation',
                                           'getClassName',
                                           'getPropertyName'
                                       )
                                   )
                                   ->getMock();

        // mock the methods
        $reflectionProperty
            ->expects($this->once())
            ->method('hasAnnotation')
            ->with(Resource::ANNOTATION)
            ->will($this->returnValue(true));
        $reflectionProperty
            ->expects($this->once())
            ->method('getAnnotation')
            ->with(Resource::ANNOTATION)
            ->will($this->returnValue($annotation));
        $reflectionProperty
            ->expects($this->exactly(1))
            ->method('getClassName')
            ->will($this->returnValue(__CLASS__));
        $reflectionProperty
            ->expects($this->exactly(2))
            ->method('getPropertyName')
            ->will($this->returnValue('dummyResource'));

        // initialize the descriptor from the reflection property
        $this->descriptor->fromReflectionProperty($reflectionProperty);

        // check that the descriptor has been initialized successfully
        $this->assertSame('env/DummyResource', $this->descriptor->getName());
        $this->assertSame('Reference to a timer service', $this->descriptor->getDescription());
        $this->assertSame('php:global/example/TimerServiceContextInterface', $this->descriptor->getLookup());
        $this->assertSame('AppserverIo\Psr\Timer\TimerServiceContextInterface', $this->descriptor->getType());
    }

    /**
     * Test that initization with the fromReflectionMethod() method
     * and an empty annotation works as expected.
     *
     * @return void
     */
    public function testFromReflectionMethodAndAnnotationWithoutAttributes()
    {

        // prepare the empty annotation values
        $values = array();

        // create a mock annotation implementation
        $beanAnnotation = $this->getMockBuilder('AppserverIo\Psr\EnterpriseBeans\Annotations\Resource')
            ->setConstructorArgs(array('Resource', $values))
            ->getMockForAbstractClass();

        // create a mock annotation
        $annotation = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionAnnotation')
            ->setMethods(array('getAnnotationName', 'getValues', 'newInstance'))
            ->setConstructorArgs(array('Resource', $values))
            ->getMock();

        // mock the ReflectionAnnotation methods
        $annotation
            ->expects($this->once())
            ->method('getAnnotationName')
            ->will($this->returnValue('EnterpriseBean'));
        $annotation
            ->expects($this->once())
            ->method('getValues')
            ->will($this->returnValue($values));
        $annotation
            ->expects($this->once())
            ->method('newInstance')
            ->will($this->returnValue($beanAnnotation));

        // initialize the annotation aliases
        $aliases = array(Resource::ANNOTATION => Resource::__getClass());

        // initialize the reflection method
        $reflectionMethod = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionMethod')
                                 ->setConstructorArgs(array(__CLASS__, array(), $aliases))
                                 ->setMethods(
                                     array(
                                         'hasAnnotation',
                                         'getAnnotation',
                                         'getClassName',
                                         'getMethodName'
                                     )
                                 )
                                 ->getMock();

        // mock the methods
        $reflectionMethod
            ->expects($this->once())
            ->method('hasAnnotation')
            ->with(Resource::ANNOTATION)
            ->will($this->returnValue(true));
        $reflectionMethod
            ->expects($this->once())
            ->method('getAnnotation')
            ->with(Resource::ANNOTATION)
            ->will($this->returnValue($annotation));
        $reflectionMethod
            ->expects($this->exactly(2))
            ->method('getClassName')
            ->will($this->returnValue(__CLASS__));
        $reflectionMethod
            ->expects($this->exactly(2))
            ->method('getMethodName')
            ->will($this->returnValue('injectDummyResource'));

        // initialize the descriptor from the reflection method
        $this->descriptor->fromReflectionMethod($reflectionMethod);

        // check that the descriptor has been initialized successfully
        $this->assertSame('env/DummyResource', $this->descriptor->getName());
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

        // prepare the empty annotation values
        $values = array(
            'type' => 'AppserverIo\Psr\Timer\TimerServiceContextInterface',
            'lookup' => 'php:global/example/TimerServiceContextInterface',
            'description' => 'Reference to a timer service'
        );

        // create a mock annotation implementation
        $beanAnnotation = $this->getMockBuilder('AppserverIo\Psr\EnterpriseBeans\Annotations\Resource')
            ->setConstructorArgs(array('Resource', $values))
            ->getMockForAbstractClass();

        // create a mock annotation
        $annotation = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionAnnotation')
            ->setMethods(array('getAnnotationName', 'getValues', 'newInstance'))
            ->setConstructorArgs(array('Resource', $values))
            ->getMock();

        // mock the ReflectionAnnotation methods
        $annotation
            ->expects($this->once())
            ->method('getAnnotationName')
            ->will($this->returnValue('EnterpriseBean'));
        $annotation
            ->expects($this->once())
            ->method('getValues')
            ->will($this->returnValue($values));
        $annotation
            ->expects($this->once())
            ->method('newInstance')
            ->will($this->returnValue($beanAnnotation));

        // initialize the annotation aliases
        $aliases = array(Resource::ANNOTATION => Resource::__getClass());

        // initialize the reflection method
        $reflectionMethod = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionMethod')
                                 ->setConstructorArgs(array(__CLASS__, array(), $aliases))
                                 ->setMethods(
                                     array(
                                         'hasAnnotation',
                                         'getAnnotation',
                                         'getClassName',
                                         'getMethodName'
                                     )
                                 )
                                 ->getMock();

        // mock the methods
        $reflectionMethod
            ->expects($this->once())
            ->method('hasAnnotation')
            ->with(Resource::ANNOTATION)
            ->will($this->returnValue(true));
        $reflectionMethod
            ->expects($this->once())
            ->method('getAnnotation')
            ->with(Resource::ANNOTATION)
            ->will($this->returnValue($annotation));
        $reflectionMethod
            ->expects($this->exactly(2))
            ->method('getClassName')
            ->will($this->returnValue(__CLASS__));
        $reflectionMethod
            ->expects($this->exactly(2))
            ->method('getMethodName')
            ->will($this->returnValue('injectDummyResource'));

        // initialize the descriptor from the reflection method
        $this->descriptor->fromReflectionMethod($reflectionMethod);

        // check that the descriptor has been initialized successfully
        $this->assertSame('env/DummyResource', $this->descriptor->getName());
        $this->assertSame('Reference to a timer service', $this->descriptor->getDescription());
        $this->assertSame('php:global/example/TimerServiceContextInterface', $this->descriptor->getLookup());
        $this->assertSame('AppserverIo\Psr\Timer\TimerServiceContextInterface', $this->descriptor->getType());
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
        $this->assertSame('env/TimerServiceContextInterface', $this->descriptor->getName());
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
        $descriptorToMerge = $this->getMockForAbstractClass('AppserverIo\Description\ResReferenceDescriptor');

        // initialize the configuration of the descriptor to be merged
        $nodeToMerge = new ResRefNode();
        $nodeToMerge->initFromFile(__DIR__ . '/_files/dd-res-ref-to-merge.xml');
        $descriptorToMerge->fromConfiguration($nodeToMerge);

        // merge the descriptors
        $this->descriptor->merge($descriptorToMerge);

        // check if all values have been initialized
        $this->assertSame('env/MyTimerServiceContextInterface', $this->descriptor->getName());
        $this->assertSame('Another reference to a timer service', $this->descriptor->getDescription());
        $this->assertSame('php:global/example/MyTimerServiceContextInterface', $this->descriptor->getLookup());
        $this->assertSame('AppserverIo\Psr\Timer\MyTimerServiceContextInterface', $this->descriptor->getType());
        $this->assertInstanceOf('AppserverIo\Description\InjectionTargetDescriptor', $injectTarget = $this->descriptor->getInjectionTarget());
        $this->assertSame('AppserverIo\Apps\Example\Services\MySampleProcessor', $injectTarget->getTargetClass());
        $this->assertSame('injectTimerService', $injectTarget->getTargetMethod());
        $this->assertNull($injectTarget->getTargetProperty());
    }
}
