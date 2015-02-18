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
use AppserverIo\Lang\Reflection\ReflectionProperty;
use AppserverIo\Lang\Reflection\ReflectionMethod;

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
     * Tests the static newDescriptorInstance() method.
     *
     * @return void
     */
    public function testNewDescriptorInstance()
    {
        $this->assertInstanceOf(
            'AppserverIo\Description\ServletDescriptor',
            ServletDescriptor::newDescriptorInstance()
        );
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
     * Tests the setter/getter for the URL patterns.
     *
     * @return void
     */
    public function testSetGetUrlPatterns()
    {
        $this->descriptor->setUrlPatterns($urlPatterns = array('/index', '/index*'));
        $this->assertSame($urlPatterns, $this->descriptor->getUrlPatterns());
    }

    /**
     * Tests the setter/getter for the initialization parameters.
     *
     * @return void
     */
    public function testSetGetInitParams()
    {
        $this->descriptor->setInitParams($initParams = array(array('paramName', 'paramValue')));
        $this->assertSame($initParams, $this->descriptor->getInitParams());
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
            Route::ANNOTATION => Route::__getClass(),
            Resource::ANNOTATION => Resource::__getClass(),
            EnterpriseBean::ANNOTATION => EnterpriseBean::__getClass()
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
                                           'isInterface'
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

        // create a ReflectionClass instance
        $reflectionClass = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionClass')
                                ->setMethods(
                                    array(
                                        'toPhpReflectionClass',
                                        'implementsInterface',
                                        'hasAnnotation',
                                        'getAnnotation',
                                        'getProperties',
                                        'getMethods'
                                    )
                                )
                                ->setConstructorArgs(array($servlet, array(), $aliases))
                                ->getMock();

        // initialize the mock ReflectionProperty instances
        $properties = array(
            new ReflectionProperty(__CLASS__, 'dummyResource', array(), $aliases),
            new ReflectionProperty(__CLASS__, 'dummyEnterpriseBean', array(), $aliases)
        );

        // initialize the mock ReflectionMethod instances
        $methods = array(
            new ReflectionMethod(__CLASS__, 'injectDummyResource', array(), $aliases),
            new ReflectionMethod(__CLASS__, 'injectDummyEnterpriseBean', array(), $aliases)
        );

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
        $reflectionClass
            ->expects($this->once())
            ->method('getProperties')
            ->will($this->returnValue($properties));
        $reflectionClass
            ->expects($this->once())
            ->method('getMethods')
            ->will($this->returnValue($methods));

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
        $this->assertSame('A test servlet implementation', $this->descriptor->getDescription());
        $this->assertSame('Test Servlet', $this->descriptor->getDisplayName());
        $this->assertCount(1, $this->descriptor->getEpbReferences());
        $this->assertCount(1, $this->descriptor->getResReferences());
        $this->assertCount(2, $this->descriptor->getReferences());
    }

    /**
     * Tests that initialization from a reflection class that not implements
     * the Servlet interface won't work.
     *
     * @return void
     */
    public function testFromReflectionClassWithInvalidInterface()
    {

        // create the reflection class
        $reflectionClass = new ReflectionClass('\stdClass', array(), array());

        // check that the descriptor has not been initialized
        $this->assertNull($this->descriptor->fromReflectionClass($reflectionClass));
    }

    /**
     * Tests that initialization from a reflection class that reflects and abstract
     * Servlet interface won't work.
     *
     * @return void
     */
    public function testFromReflectionClassIsAbstract()
    {

        // create a servlet instance
        $servlet = $this->getMockBuilder('AppserverIo\Psr\Servlet\ServletInterface')
                        ->setMethods(get_class_methods('AppserverIo\Psr\Servlet\ServletInterface'))
                        ->getMock();

        // create a PHP \ReflectionClass instance
        $phpReflectionClass = $this->getMockBuilder('\ReflectionClass')
                                   ->setMethods(array('isAbstract', 'isInterface'))
                                   ->disableOriginalConstructor()
                                   ->getMock();

        // mock the methods
        $phpReflectionClass
            ->expects($this->once())
            ->method('isAbstract')
            ->will($this->returnValue(true));
        $phpReflectionClass
            ->expects($this->once())
            ->method('isInterface')
            ->will($this->returnValue(false));

        // create a ReflectionClass instance
        $reflectionClass = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionClass')
                                ->setMethods(array('toPhpReflectionClass', 'implementsInterface'))
                                ->setConstructorArgs(array($servlet, array(), array()))
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

        // check that the descriptor has not been initialized
        $this->assertNull($this->descriptor->fromReflectionClass($reflectionClass));
    }

    /**
     * Tests that initialization from a reflection class that reflects and abstract
     * Servlet interface won't work.
     *
     * @return void
     */
    public function testFromReflectionClassIsInterface()
    {

        // create a servlet instance
        $servlet = $this->getMockBuilder('AppserverIo\Psr\Servlet\ServletInterface')
                        ->setMethods(get_class_methods('AppserverIo\Psr\Servlet\ServletInterface'))
                        ->getMock();

        // create a PHP \ReflectionClass instance
        $phpReflectionClass = $this->getMockBuilder('\ReflectionClass')
                                   ->setMethods(array('isAbstract', 'isInterface'))
                                   ->disableOriginalConstructor()
                                   ->getMock();

        // mock the methods
        $phpReflectionClass
            ->expects($this->once())
            ->method('isInterface')
            ->will($this->returnValue(true));

        // create a ReflectionClass instance
        $reflectionClass = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionClass')
                                ->setMethods(array('toPhpReflectionClass', 'implementsInterface'))
                                ->setConstructorArgs(array($servlet, array(), array()))
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

        // check that the descriptor has not been initialized
        $this->assertNull($this->descriptor->fromReflectionClass($reflectionClass));
    }

    /**
     * Tests if the deployment initialization from a deployment descriptor
     * works as expected.
     *
     * @return void
     */
    public function testFromDeploymentDescriptor()
    {

        // load the deployment descriptor node
        $node = new \SimpleXMLElement(file_get_contents(__DIR__ . '/_files/dd-servlet.xml'));

        // initialize the descriptor from the nodes data
        $this->descriptor->fromDeploymentDescriptor($node);

        // check if all values have been initialized
        $this->assertSame('AppserverIo\Example\DummyServlet', $this->descriptor->getClassName());
        $this->assertSame('dummyServlet', $this->descriptor->getName());
        $this->assertSame('A dummy servlet implementation.', $this->descriptor->getDescription());
        $this->assertSame('Dummy Servlet', $this->descriptor->getDisplayName());
        $this->assertCount(0, $this->descriptor->getInitParams());
        $this->assertCount(1, $this->descriptor->getEpbReferences());
        $this->assertCount(1, $this->descriptor->getResReferences());
        $this->assertCount(2, $this->descriptor->getReferences());
    }

    /**
     * Tests that initialization from an invalid deployment descriptor won't work.
     *
     * @return void
     */
    public function testFromInvalidDeploymentDescriptor()
    {

        // load the deployment descriptor node
        $node = new \SimpleXMLElement(file_get_contents(__DIR__ . '/_files/dd-statefulsessionbean.xml'));

        // check that the descriptor has not been initialized
        $this->assertNull($this->descriptor->fromDeploymentDescriptor($node));
    }

    /**
     * Tests if the merge method works successfully.
     *
     * @return void
     */
    public function testMergeSuccessful()
    {

        // load the deployment descriptor node
        $node = new \SimpleXMLElement(file_get_contents(__DIR__ . '/_files/dd-servlet.xml'));

        // initialize the descriptor from the nodes data
        $this->descriptor->fromDeploymentDescriptor($node);

        // initialize the descriptor to merge
        $descriptorToMerge = $this->getMockForAbstractClass('AppserverIo\Description\ServletDescriptor');
        $nodeToMerge = new \SimpleXMLElement(file_get_contents(__DIR__ . '/_files/dd-servlet-to-merge.xml'));
        $descriptorToMerge->fromDeploymentDescriptor($nodeToMerge);

        // we add a dummy URL pattern => because parsing from deployment descriptor is NOT possible
        $descriptorToMerge->addUrlPattern('/index*');

        // merge the descriptors
        $this->descriptor->merge($descriptorToMerge);

        // check if all values have been merged
        $this->assertSame('AppserverIo\Example\DummyServlet', $this->descriptor->getClassName());
        $this->assertSame('myDummyServlet', $this->descriptor->getName());
        $this->assertSame('My dummy servlet implementation.', $this->descriptor->getDescription());
        $this->assertSame('My Dummy Servlet', $this->descriptor->getDisplayName());
        $this->assertCount(1, $this->descriptor->getUrlPatterns());
        $this->assertCount(1, $this->descriptor->getInitParams());
        $this->assertCount(2, $this->descriptor->getEpbReferences());
        $this->assertCount(1, $this->descriptor->getResReferences());
        $this->assertCount(3, $this->descriptor->getReferences());
    }

    /**
     * Tests if the merge method fails with an exception if the class
     * name doesn't match when try to merge to descriptor instances.
     *
     * @return void
     * @expectedException AppserverIo\Psr\Servlet\ServletException
     */
    public function testMergeWithException()
    {

        // load the deployment descriptor node
        $node = new \SimpleXMLElement(file_get_contents(__DIR__ . '/_files/dd-servlet.xml'));

        // initialize the descriptor from the nodes data
        $this->descriptor->fromDeploymentDescriptor($node);

        // initialize the descriptor to merge
        $descriptorToMerge = $this->getMockForAbstractClass('AppserverIo\Description\ServletDescriptor');
        $nodeToMerge = new \SimpleXMLElement(file_get_contents(__DIR__ . '/_files/dd-servlet-to-merge-with-exception.xml'));
        $descriptorToMerge->fromDeploymentDescriptor($nodeToMerge);

        // merge the descriptors
        $this->descriptor->merge($descriptorToMerge);
    }
}
