<?php

/**
 * AppserverIo\Description\PersistenceUnitReferenceDescriptorTest
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
use AppserverIo\Description\Api\Node\PersistenceUnitRefNode;
use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;

/**
 * Test implementation for the ResReferenceDescriptorTest class implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class PersistenceUnitReferenceDescriptorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The descriptor instance we want to test.
     *
     * @var \AppserverIo\Description\PersistenceUnitReferenceDescriptor
     */
    protected $descriptor;

    /**
     * Dummy persistence unit.
     *
     * @EPB\PersistenceUnit(name="ReferenceToMyPersistenceUnit", unitName="MyPersistenceUnit")
     */
    protected $dummyPersistenceUnit;

    /**
     * Dummy persistence unit without attributes.
     *
     * @EPB\PersistenceUnit
     */
    protected $dummyPersistenceUnitWithoutAttributes;

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
        $this->descriptor = new PersistenceUnitReferenceDescriptor($parent);
    }

    /**
     * Injects the dummy persistence unit instance without attributes.
     *
     * @param mixed $dummyPersistenceUnit The dummy persistence unit
     *
     * @return void
     * @EPB\PersistenceUnit
     */
    public function injectDummyPersistenceUnitWithoutAttributes($dummyPersistenceUnitWithoutAttributes)
    {
        $this->dummyPersistenceUnitWithoutAttributes = $dummyPersistenceUnitWithoutAttributes;
    }

    /**
     * Injects the dummy persistence unit instance.
     *
     * @param mixed $dummyPersistenceUnit The dummy persistence unit
     *
     * @return void
     * @EPB\PersistenceUnit(name="ReferenceToMyPersistenceUnit", unitName="MyPersistenceUnit")
     */
    public function injectDummyPersistenceUnit($dummyPersistenceUnit)
    {
        $this->dummyPersistenceUnit = $dummyPersistenceUnit;
    }

    /**
     * Tests the static newDescriptorInstance() method.
     *
     * @return void
     */
    public function testNewDescriptorInstance()
    {
        $this->assertInstanceOf(
            'AppserverIo\Description\PersistenceUnitReferenceDescriptor',
            PersistenceUnitReferenceDescriptor::newDescriptorInstance($this->getMock('AppserverIo\Psr\EnterpriseBeans\Description\NameAwareDescriptorInterface'))
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
                                   ->setMethods(array('getClassName', 'getPropertyName'))
                                   ->getMock();

        // mock the methods
        $reflectionProperty
            ->expects($this->exactly(2))
            ->method('getClassName')
            ->will($this->returnValue(__CLASS__));
        $reflectionProperty
            ->expects($this->exactly(2))
            ->method('getPropertyName')
            ->will($this->returnValue('dummyPersistenceUnit'));

        // initialize the descriptor from the reflection property
        $this->descriptor->fromReflectionProperty($reflectionProperty);

        // check that the descriptor has been initialized successfully
        $this->assertSame('ReferenceToMyPersistenceUnit', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/ReferenceToMyPersistenceUnit', $this->descriptor->getRefName());
        $this->assertSame('MyPersistenceUnit', $this->descriptor->getUnitName());
    }

    /**
     * Test that initization with the fromReflectionProperty() method
     * and an empty annotation works as expected.
     *
     * @return void
     */
    public function testFromReflectionPropertyAndAnnotationWithoutAttributes()
    {

        // initialize the reflection property
        $reflectionProperty = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionProperty')
                                   ->setConstructorArgs(array(__CLASS__, array(), array()))
                                   ->setMethods(array('getClassName', 'getPropertyName'))
                                   ->getMock();

        // mock the methods
        $reflectionProperty
            ->expects($this->exactly(2))
            ->method('getClassName')
            ->will($this->returnValue(__CLASS__));
        $reflectionProperty
            ->expects($this->exactly(4))
            ->method('getPropertyName')
            ->will($this->returnValue('dummyPersistenceUnitWithoutAttributes'));

        // initialize the descriptor from the reflection property
        $this->descriptor->fromReflectionProperty($reflectionProperty);

        // check that the descriptor has been initialized successfully
        $this->assertSame('DummyPersistenceUnitWithoutAttributes', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/DummyPersistenceUnitWithoutAttributes', $this->descriptor->getRefName());
        $this->assertSame('DummyPersistenceUnitWithoutAttributes', $this->descriptor->getUnitName());
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
            ->will($this->returnValue('injectDummyPersistenceUnitWithoutAttributes'));

        // initialize the descriptor from the reflection method
        $this->descriptor->fromReflectionMethod($reflectionMethod);

        // check that the descriptor has been initialized successfully
        $this->assertSame('DummyPersistenceUnitWithoutAttributes', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/DummyPersistenceUnitWithoutAttributes', $this->descriptor->getRefName());
        $this->assertSame('DummyPersistenceUnitWithoutAttributes', $this->descriptor->getUnitName());
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
            ->expects($this->exactly(3))
            ->method('getClassName')
            ->will($this->returnValue(__CLASS__));
        $reflectionMethod
            ->expects($this->exactly(3))
            ->method('getMethodName')
            ->will($this->returnValue('injectDummyPersistenceUnit'));

        // initialize the descriptor from the reflection method
        $this->descriptor->fromReflectionMethod($reflectionMethod);

        // check that the descriptor has been initialized successfully
        $this->assertSame('ReferenceToMyPersistenceUnit', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/ReferenceToMyPersistenceUnit', $this->descriptor->getRefName());
        $this->assertSame('MyPersistenceUnit', $this->descriptor->getUnitName());
    }

    /**
     * Initializes the descriptor from a deployment descriptor.
     *
     * @return void
     */
    public function testFromConfiguration()
    {

        // initialize the configuration
        $node = new PersistenceUnitRefNode();
        $node->initFromFile(__DIR__ . '/_files/dd-persistence-unit-ref.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // check that the descriptor has been initialized successfully
        $this->assertSame('ReferenceToMyPersistenceUnit', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/ReferenceToMyPersistenceUnit', $this->descriptor->getRefName());
        $this->assertSame('MyPersistenceUnit', $this->descriptor->getUnitName());
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
        $node = new PersistenceUnitRefNode();
        $node->initFromFile(__DIR__ . '/_files/dd-persistence-unit-ref.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // initialize the descriptor to merge
        $descriptorToMerge = $this->getMockBuilder('AppserverIo\Description\PersistenceUnitReferenceDescriptor')
                                  ->disableOriginalConstructor()
                                  ->getMockForAbstractClass();

        // initialize the configuration of the descriptor to be merged
        $nodeToMerge = new PersistenceUnitRefNode();
        $nodeToMerge->initFromFile(__DIR__ . '/_files/dd-persistence-unit-ref-to-merge.xml');
        $descriptorToMerge->fromConfiguration($nodeToMerge);

        // merge the descriptors
        $this->descriptor->merge($descriptorToMerge);

        // check if all values have been initialized
        $this->assertSame('ReferenceToMyNewPersistenceUnit', $this->descriptor->getName());
        $this->assertSame('env/SomeBean/ReferenceToMyNewPersistenceUnit', $this->descriptor->getRefName());
        $this->assertSame('MyNewPersistenceUnit', $this->descriptor->getUnitName());
        $this->assertInstanceOf('AppserverIo\Description\InjectionTargetDescriptor', $injectTarget = $this->descriptor->getInjectionTarget());
        $this->assertSame('AppserverIo\Apps\Example\Services\NewSampleProcessor', $injectTarget->getTargetClass());
        $this->assertSame('injectMyNewPersistenceUnit', $injectTarget->getTargetMethod());
    }
}
