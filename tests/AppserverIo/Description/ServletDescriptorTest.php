<?php

/**
 * AppserverIo\Description\ServletDescriptorTest
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
use AppserverIo\Psr\EnterpriseBeans\Annotations\Resource;
use AppserverIo\Psr\EnterpriseBeans\Annotations\EnterpriseBean;
use AppserverIo\Psr\Servlet\Annotations\Route;

/**
 * Test implementation for the ServletDescriptor class implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class ServletDescriptorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The descriptor instance we want to test.
     *
     * @var \AppserverIo\Description\ServletDescriptor
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
     * Initializes the method we wan to test.
     *
     * @return void
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->descriptor = $this->getMockForAbstractClass('AppserverIo\Description\ServletDescriptor');
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
     * Tests the setter/getter for the EPB references.
     *
     * @return void
     */
    public function testSetGetEpbReferences()
    {
        $this->descriptor->setEpbReferences($epbReferences = array(new \stdClass()));
        $this->assertSame($epbReferences, $this->descriptor->getEpbReferences());
    }

    /**
     * Tests the setter/getter for the resource references.
     *
     * @return void
     */
    public function testSetGetResReferences()
    {
        $this->descriptor->setResReferences($resReferences = array(new \stdClass()));
        $this->assertSame($resReferences, $this->descriptor->getResReferences());
    }

    /**
     * Tests if the deployment initialization from a reflection class with a bean annotation
     * containing the name attribute works as expected.
     *
     * @return void
     */
    public function testFromReflectionClassWithAnnotationContainingNameAttribute()
    {

        // prepare the annotation values
        $values = array(
            'name' => 'testServlet',
            'displayName' => 'Test Servlet',
            'description' => 'A test servlet implementation',
            'urlPattern' => array('/annotated.do', '/annotated.do*'),
            'initParams' => array('testParam' => 'testValue')
        );

        // create a mock annotation implementation
        $beanAnnotation = $this->getMockBuilder('AppserverIo\Psr\Servlet\Annotations\Route')
                               ->setConstructorArgs(array('Route', $values))
                               ->getMockForAbstractClass();

        // create a mock annotation
        $annotation = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionAnnotation')
                           ->setMethods(array('getAnnotationName', 'getValues', 'newInstance'))
                           ->setConstructorArgs(array('Route', $values))
                           ->getMock();

        // mock the ReflectionAnnotation methods
        $annotation
            ->expects($this->once())
            ->method('getAnnotationName')
            ->will($this->returnValue('Route'));
        $annotation
            ->expects($this->once())
            ->method('getValues')
            ->will($this->returnValue($values));
        $annotation
            ->expects($this->once())
            ->method('newInstance')
            ->will($this->returnValue($beanAnnotation));

        // initialize the annotation aliases
        $aliases = array(
            Route::ANNOTATION => Route::__getClass()
        );

        // create a servlet instance
        $servlet = $this->getMockBuilder('AppserverIo\Psr\Servlet\ServletInterface')
                        ->setMethods(get_class_methods('AppserverIo\Psr\Servlet\ServletInterface'))
                        ->getMock();

        // create a PHP \ReflectionClass instance
        $phpReflectionClass = $this->getMockBuilder('\ReflectionClass')
                                   ->setMethods(
                                       array(
                                           'isAbstract',
                                           'isInterface',
                                           'getProperties',
                                           'getMethods'
                                       )
                                   )
                                   ->disableOriginalConstructor()
                                   ->getMock();

        // mock the methods
        $phpReflectionClass
            ->expects($this->once())
            ->method('isAbstract')
            ->will($this->returnValue(false));
        $phpReflectionClass
            ->expects($this->once())
            ->method('isInterface')
            ->will($this->returnValue(false));
        $phpReflectionClass
            ->expects($this->once())
            ->method('getProperties')
            ->will($this->returnValue(array()));
        $phpReflectionClass
            ->expects($this->once())
            ->method('getMethods')
            ->will($this->returnValue(array()));

        // create a ReflectionClass instance
        $reflectionClass = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionClass')
                                ->setMethods(
                                    array(
                                        'toPhpReflectionClass',
                                        'implementsInterface',
                                        'hasAnnotation',
                                        'getAnnotation'
                                    )
                                )
                                ->setConstructorArgs(array($servlet, array(), $aliases))
                                ->getMock();

        // mock the methods
        $reflectionClass
            ->expects($this->any())
            ->method('toPhpReflectionClass')
            ->will($this->returnValue($phpReflectionClass));
        $reflectionClass
            ->expects($this->once())
            ->method('implementsInterface')
            ->will($this->returnValue(true));
        $reflectionClass
            ->expects($this->any())
            ->method('hasAnnotation')
            ->with(Route::ANNOTATION)
            ->will($this->returnValue(true));
        $reflectionClass
            ->expects($this->any())
            ->method('getAnnotation')
            ->with(Route::ANNOTATION)
            ->will($this->returnValue($annotation));

        // mock the methods
        $this->descriptor
            ->expects($this->any())
            ->method('newAnnotationInstance')
            ->with($reflectionClass)
            ->will($this->returnValue($annotation));

        // initialize the descriptor instance
        $this->descriptor->fromReflectionClass($reflectionClass);

        // check the name parsed from the reflection class
        $this->assertSame($phpReflectionClass->getName(), $this->descriptor->getClassName());
        $this->assertSame('testServlet', $this->descriptor->getName());
        $this->assertCount(0, $this->descriptor->getEpbReferences());
        $this->assertCount(0, $this->descriptor->getResReferences());
        $this->assertCount(0, $this->descriptor->getReferences());
    }
}
