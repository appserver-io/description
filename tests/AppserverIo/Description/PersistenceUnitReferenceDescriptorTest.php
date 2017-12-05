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
use AppserverIo\Psr\EnterpriseBeans\Annotations\PersistenceUnit;

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
     * Dummy bean reference.
     *
     * @EnterpriseBean(name="SessionBean")
     */
    protected $dummyEnterpriseBean;

    /**
     * Dummy persistence unit reference.
     *
     * @PersistenceUnit(name="MyPersistenceUnit")
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
        $parent = $this->getMockBuilder($nameAwareInterface = 'AppserverIo\Description\NameAwareDescriptorInterface')
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
     * Injects the dummy persistence unit instance.
     *
     * @param mixed $dummyPersistenceUnit The dummy persistence unit
     *
     * @return void
     * @PersistenceUnit(name="MyPersistenceUnit")
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
            PersistenceUnitReferenceDescriptor::newDescriptorInstance($this->getMock('AppserverIo\Description\NameAwareDescriptorInterface'))
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
            'name' => 'ReferenceToMyPersistenceUnit',
            'unitName' => 'MyPersistenceUnit'
        );

        // create a mock annotation implementation
        $beanAnnotation = $this->getMockBuilder('AppserverIo\Psr\EnterpriseBeans\Annotations\PersistenceUnit')
            ->setConstructorArgs(array('Resource', $values))
            ->getMockForAbstractClass();

        // create a mock annotation
        $annotation = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionAnnotation')
            ->setMethods(array('getAnnotationName', 'getValues', 'newInstance'))
            ->setConstructorArgs(array('PersistenceUnit', $values))
            ->getMock();

        // mock the ReflectionAnnotation methods
        $annotation
            ->expects($this->once())
            ->method('getAnnotationName')
            ->will($this->returnValue('PersistenceUnit'));
        $annotation
            ->expects($this->once())
            ->method('getValues')
            ->will($this->returnValue($values));
        $annotation
            ->expects($this->once())
            ->method('newInstance')
            ->will($this->returnValue($beanAnnotation));

        // initialize the annotation aliases
        $aliases = array(PersistenceUnit::ANNOTATION => PersistenceUnit::__getClass());

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
            ->with(PersistenceUnit::ANNOTATION)
            ->will($this->returnValue(true));
        $reflectionProperty
            ->expects($this->once())
            ->method('getAnnotation')
            ->with(PersistenceUnit::ANNOTATION)
            ->will($this->returnValue($annotation));
        $reflectionProperty
            ->expects($this->once())
            ->method('getClassName')
            ->will($this->returnValue(__CLASS__));
        $reflectionProperty
            ->expects($this->once())
            ->method('getPropertyName')
            ->will($this->returnValue('dummyPersistenceUnit'));

        // initialize the descriptor from the reflection property
        $this->descriptor->fromReflectionProperty($reflectionProperty);

        // check that the descriptor has been initialized successfully
        $this->assertSame('ReferenceToMyPersistenceUnit', $this->descriptor->getName());
        $this->assertSame('SomeBean/env/ReferenceToMyPersistenceUnit', $this->descriptor->getRefName());
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

        // prepare the empty annotation values
        $values = array();

        // create a mock annotation implementation
        $beanAnnotation = $this->getMockBuilder('AppserverIo\Psr\EnterpriseBeans\Annotations\PersistenceUnit')
            ->setConstructorArgs(array('Resource', $values))
            ->getMockForAbstractClass();

        // create a mock annotation
        $annotation = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionAnnotation')
            ->setMethods(array('getAnnotationName', 'getValues', 'newInstance'))
            ->setConstructorArgs(array('PersistenceUnit', $values))
            ->getMock();

        // mock the ReflectionAnnotation methods
        $annotation
            ->expects($this->once())
            ->method('getAnnotationName')
            ->will($this->returnValue('PersistenceUnit'));
        $annotation
            ->expects($this->once())
            ->method('getValues')
            ->will($this->returnValue($values));
        $annotation
            ->expects($this->once())
            ->method('newInstance')
            ->will($this->returnValue($beanAnnotation));

        // initialize the annotation aliases
        $aliases = array(PersistenceUnit::ANNOTATION => PersistenceUnit::__getClass());

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
            ->with(PersistenceUnit::ANNOTATION)
            ->will($this->returnValue(true));
        $reflectionProperty
            ->expects($this->once())
            ->method('getAnnotation')
            ->with(PersistenceUnit::ANNOTATION)
            ->will($this->returnValue($annotation));
        $reflectionProperty
            ->expects($this->once())
            ->method('getClassName')
            ->will($this->returnValue(__CLASS__));
        $reflectionProperty
            ->expects($this->exactly(3))
            ->method('getPropertyName')
            ->will($this->returnValue('dummyPersistenceUnit'));

        // initialize the descriptor from the reflection property
        $this->descriptor->fromReflectionProperty($reflectionProperty);

        // check that the descriptor has been initialized successfully
        $this->assertSame('DummyPersistenceUnit', $this->descriptor->getName());
        $this->assertSame('SomeBean/env/DummyPersistenceUnit', $this->descriptor->getRefName());
        $this->assertSame('DummyPersistenceUnit', $this->descriptor->getUnitName());
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
        $beanAnnotation = $this->getMockBuilder('AppserverIo\Psr\EnterpriseBeans\Annotations\PersistenceUnit')
            ->setConstructorArgs(array('Resource', $values))
            ->getMockForAbstractClass();

        // create a mock annotation
        $annotation = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionAnnotation')
            ->setMethods(array('getAnnotationName', 'getValues', 'newInstance'))
            ->setConstructorArgs(array('PersistenceUnit', $values))
            ->getMock();

        // mock the ReflectionAnnotation methods
        $annotation
            ->expects($this->once())
            ->method('getAnnotationName')
            ->will($this->returnValue('PersistenceUnit'));
        $annotation
            ->expects($this->once())
            ->method('getValues')
            ->will($this->returnValue($values));
        $annotation
            ->expects($this->once())
            ->method('newInstance')
            ->will($this->returnValue($beanAnnotation));

        // initialize the annotation aliases
        $aliases = array(PersistenceUnit::ANNOTATION => PersistenceUnit::__getClass());

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
            ->with(PersistenceUnit::ANNOTATION)
            ->will($this->returnValue(true));
        $reflectionMethod
            ->expects($this->once())
            ->method('getAnnotation')
            ->with(PersistenceUnit::ANNOTATION)
            ->will($this->returnValue($annotation));
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
        $this->assertSame('DummyPersistenceUnit', $this->descriptor->getName());
        $this->assertSame('SomeBean/env/DummyPersistenceUnit', $this->descriptor->getRefName());
        $this->assertSame('DummyPersistenceUnit', $this->descriptor->getUnitName());
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
            'name' => 'ReferenceToMyPersistenceUnit',
            'unitName' => 'MyPersistenceUnit'
        );

        // create a mock annotation implementation
        $beanAnnotation = $this->getMockBuilder('AppserverIo\Psr\EnterpriseBeans\Annotations\PersistenceUnit')
            ->setConstructorArgs(array('PersistenceUnit', $values))
            ->getMockForAbstractClass();

        // create a mock annotation
        $annotation = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionAnnotation')
            ->setMethods(array('getAnnotationName', 'getValues', 'newInstance'))
            ->setConstructorArgs(array('PersistenceUnit', $values))
            ->getMock();

        // mock the ReflectionAnnotation methods
        $annotation
            ->expects($this->once())
            ->method('getAnnotationName')
            ->will($this->returnValue('PersistenceUnit'));
        $annotation
            ->expects($this->once())
            ->method('getValues')
            ->will($this->returnValue($values));
        $annotation
            ->expects($this->once())
            ->method('newInstance')
            ->will($this->returnValue($beanAnnotation));

        // initialize the annotation aliases
        $aliases = array(PersistenceUnit::ANNOTATION => PersistenceUnit::__getClass());

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
            ->with(PersistenceUnit::ANNOTATION)
            ->will($this->returnValue(true));
        $reflectionMethod
            ->expects($this->once())
            ->method('getAnnotation')
            ->with(PersistenceUnit::ANNOTATION)
            ->will($this->returnValue($annotation));
        $reflectionMethod
            ->expects($this->exactly(2))
            ->method('getClassName')
            ->will($this->returnValue(__CLASS__));
        $reflectionMethod
            ->expects($this->exactly(2))
            ->method('getMethodName')
            ->will($this->returnValue('injectDummyPersistenceUnit'));

        // initialize the descriptor from the reflection method
        $this->descriptor->fromReflectionMethod($reflectionMethod);

        // check that the descriptor has been initialized successfully
        $this->assertSame('ReferenceToMyPersistenceUnit', $this->descriptor->getName());
        $this->assertSame('SomeBean/env/ReferenceToMyPersistenceUnit', $this->descriptor->getRefName());
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
        $this->assertSame('SomeBean/env/ReferenceToMyPersistenceUnit', $this->descriptor->getRefName());
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
        $this->assertSame('SomeBean/env/ReferenceToMyNewPersistenceUnit', $this->descriptor->getRefName());
        $this->assertSame('MyNewPersistenceUnit', $this->descriptor->getUnitName());
        $this->assertInstanceOf('AppserverIo\Description\InjectionTargetDescriptor', $injectTarget = $this->descriptor->getInjectionTarget());
        $this->assertSame('AppserverIo\Apps\Example\Services\NewSampleProcessor', $injectTarget->getTargetClass());
        $this->assertSame('injectMyNewPersistenceUnit', $injectTarget->getTargetMethod());
    }
}
