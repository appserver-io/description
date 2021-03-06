<?php

/**
 * AppserverIo\Description\EpbReferenceDescriptorTest
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
use AppserverIo\Description\Api\Node\EpbRefNode;
use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;

/**
 * Test implementation for the EpbReferenceDescriptor class implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class EpbReferenceDescriptorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The descriptor instance we want to test.
     *
     * @var \AppserverIo\Description\EpbReferenceDescriptor
     */
    protected $descriptor;

    /**
     * Dummy bean reference.
     *
     * @EPB\EnterpriseBean(description="A Description", lookup="php:global/example/DummyEnterpriseBean")
     */
    protected $dummyEnterpriseBean;

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
        $this->descriptor = new EpbReferenceDescriptor($parent);
    }

    /**
     * Injects the dummy bean instance.
     *
     * @param mixed $dummyEnterpriseBean The dummy bean
     *
     * @return void
     * @EPB\EnterpriseBean(name="SampleProcessor", description="A Description", lookup="php:global/example/SampleProcessor")
     */
    public function injectDummyEnterpriseBean($dummyEnterpriseBean)
    {
        $this->dummyEnterpriseBean = $dummyEnterpriseBean;
    }

    /**
     * Injects the dummy bean instance.
     *
     * @param mixed $dummyEnterpriseBean The dummy bean
     *
     * @return void
     * @EPB\EnterpriseBean
     */
    public function injectDummyEnterpriseBeanWithoutAttributes($dummyEnterpriseBean)
    {
        $this->dummyEnterpriseBean = $dummyEnterpriseBean;
    }

    /**
     * Tests the static newDescriptorInstance() method.
     *
     * @return void
     */
    public function testNewDescriptorInstance()
    {
        $this->assertInstanceOf(
            'AppserverIo\Description\EpbReferenceDescriptor',
            EpbReferenceDescriptor::newDescriptorInstance($this->getMock('AppserverIo\Psr\EnterpriseBeans\Description\NameAwareDescriptorInterface'))
        );
    }

    /**
     * Test that the fromReflectionClass() methods has not yet been implemented.
     *
     * @return void
     * @expectedException \Exception
     */
    public function testFromReflectionClass()
    {
        $this->descriptor->fromReflectionClass(new ReflectionClass('\stdClass'));
    }

    /**
     * Test that initization with the fromReflectionMethod() method
     * works as expected.
     *
     * @return void
     */
    public function testFromReflectionMethod()
    {

        // initialize the reflection method
        $reflectionMethod = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionMethod')
                                 ->setConstructorArgs(array(__CLASS__, array(), array()))
                                 ->setMethods(array('getClassName', 'getMethodName'))
                                 ->getMock();

        // mock the methods
        $reflectionMethod
            ->expects($this->exactly(3))
            ->method('getClassName')
            ->will($this->returnValue(__CLASS__));
        $reflectionMethod
            ->expects($this->exactly(3))
            ->method('getMethodName')
            ->will($this->returnValue('injectDummyEnterpriseBean'));

        // initialize the descriptor from the reflection method
        $this->assertSame($this->descriptor, $this->descriptor->fromReflectionMethod($reflectionMethod));

        // check that the descriptor has been initialized successfully
        $this->assertSame('SampleProcessor', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/SampleProcessor', $this->descriptor->getRefName());
        $this->assertSame('A Description', $this->descriptor->getDescription());
        $this->assertSame('SampleProcessorLocal', $this->descriptor->getBeanInterface());
        $this->assertSame('SampleProcessor', $this->descriptor->getBeanName());
        $this->assertSame('php:global/example/SampleProcessor', $this->descriptor->getLookup());
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
            ->will($this->returnValue('injectDummyEnterpriseBeanWithoutAttributes'));

        // initialize the descriptor from the reflection method
        $this->descriptor->fromReflectionMethod($reflectionMethod);

        // check that the descriptor has been initialized successfully
        $this->assertSame('DummyEnterpriseBean', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/DummyEnterpriseBean', $this->descriptor->getRefName());
        $this->assertSame('DummyEnterpriseBeanLocal', $this->descriptor->getBeanInterface());
        $this->assertSame('DummyEnterpriseBean', $this->descriptor->getBeanName());
        $this->assertNull($this->descriptor->getDescription());
        $this->assertNull($this->descriptor->getLookup());
    }

    /**
     * Test that initization with the fromReflectionProperty() method
     * and an empty annotation works as expected.
     *
     * @return void
     */
    public function testFromReflectionPropertyAndAnnotationWithSomeAttributes()
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
            ->will($this->returnValue('dummyEnterpriseBean'));

        // initialize the descriptor from the reflection property
        $this->descriptor->fromReflectionProperty($reflectionProperty);

        // check that the descriptor has been initialized successfully
        $this->assertSame('DummyEnterpriseBean', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/DummyEnterpriseBean', $this->descriptor->getRefName());
        $this->assertSame('DummyEnterpriseBeanLocal', $this->descriptor->getBeanInterface());
        $this->assertSame('DummyEnterpriseBean', $this->descriptor->getBeanName());
        $this->assertSame('A Description', $this->descriptor->getDescription());
        $this->assertSame('php:global/example/DummyEnterpriseBean', $this->descriptor->getLookup());
    }

    /**
     * Initializes the descriptor from a deployment descriptor.
     *
     * @return void
     */
    public function testFromConfiguration()
    {

        // initialize the configuration
        $node = new EpbRefNode();
        $node->initFromFile(__DIR__ . '/_files/dd-epb-ref.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // check if all values have been initialized
        $this->assertSame('UserProcessor', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/UserProcessor', $this->descriptor->getRefName());
        $this->assertSame('Some Description', $this->descriptor->getDescription());
        $this->assertSame('php:global/example/UserProcessor', $this->descriptor->getLookup());
        $this->assertSame('UserProcessorLocal', $this->descriptor->getBeanInterface());
        $this->assertSame('UserProcessor', $this->descriptor->getBeanName());
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
        $node = new EpbRefNode();
        $node->initFromFile(__DIR__ . '/_files/dd-epb-ref.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // initialize the descriptor to merge
        $descriptorToMerge = $this->getMockBuilder('AppserverIo\Description\EpbReferenceDescriptor')
                                  ->disableOriginalConstructor()
                                  ->getMockForAbstractClass();

        // initialize the configuration of the descriptor to be merged
        $nodeToMerge = new EpbRefNode();
        $nodeToMerge->initFromFile(__DIR__ . '/_files/dd-epb-ref-to-merge.xml');
        $descriptorToMerge->fromConfiguration($nodeToMerge);

        // merge the descriptors
        $this->descriptor->merge($descriptorToMerge);

        // check if all values have been initialized
        $this->assertSame('MyUserProcessor', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/MyUserProcessor', $this->descriptor->getRefName());
        $this->assertSame('Another Description', $this->descriptor->getDescription());
        $this->assertSame('php:global/example/MyUserProcessor', $this->descriptor->getLookup());
        $this->assertSame('MyUserProcessorLocal', $this->descriptor->getBeanInterface());
        $this->assertSame('MyUserProcessor', $this->descriptor->getBeanName());
        $this->assertInstanceOf('AppserverIo\Description\InjectionTargetDescriptor', $injectTarget = $this->descriptor->getInjectionTarget());
        $this->assertSame('AppserverIo\Apps\Example\Services\ASampleProcessor', $injectTarget->getTargetClass());
        $this->assertSame('aSampleProcessor', $injectTarget->getTargetProperty());
        $this->assertNull($injectTarget->getTargetMethod());
    }
}
