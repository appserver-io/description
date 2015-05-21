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

use AppserverIo\Psr\EnterpriseBeans\Annotations\Resource;
use AppserverIo\Psr\EnterpriseBeans\Annotations\EnterpriseBean;
use AppserverIo\Lang\Reflection\ReflectionClass;
/**
 * Test implementation for the SessionBeanDescriptor class implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class SessionBeanDescriptorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The abstract descriptor instance we want to test.
     *
     * @var \AppserverIo\Description\SessionBeanDescriptor
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
        $this->descriptor = $this->getMockForAbstractClass('AppserverIo\Description\SessionBeanDescriptor');
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
     * Dummy method to test lifecycle callback.
     *
     * @return void
     * @PostConstruct
     */
    public function initialize()
    {
    }

    /**
     * Dummy method to test lifecycle callback.
     *
     * @return void
     * @PreDestroy
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

        // prepare the annotation values
        $values = array();

        // create a mock annotation implementation
        $beanAnnotation = $this->getMockBuilder('AppserverIo\Psr\EnterpriseBeans\Annotations\AbstractBeanAnnotation')
                               ->setConstructorArgs(array('Stateless', $values))
                               ->getMockForAbstractClass();

        // create a mock annotation
        $annotation = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionAnnotation')
                           ->setMethods(array('getAnnotationName', 'getValues', 'newInstance'))
                           ->setConstructorArgs(array('Stateless', $values))
                           ->getMock();

        // mock the ReflectionAnnotation methods
        $annotation
            ->expects($this->once())
            ->method('getAnnotationName')
            ->will($this->returnValue('Stateless'));
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
            Resource::ANNOTATION => Resource::__getClass(),
            EnterpriseBean::ANNOTATION => EnterpriseBean::__getClass()
        );

        // create a reflection class
        $reflectionClass = new ReflectionClass(__CLASS__, array(), $aliases);

        // mock the methods
        $this->descriptor
            ->expects($this->once())
            ->method('newAnnotationInstance')
            ->with($reflectionClass)
            ->will($this->returnValue($annotation));

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
     * Tests if the deployment initialization from a reflection class with a invalid
     * @Local bean annotation throws an exception.
     *
     * @return void
     * @expectedException \Exception
     */
    public function testFromReflectionClassWithInvalidLocalAnnotation()
    {

        // prepare the annotation values
        $values = array();

        // create a mock annotation implementation
        $beanAnnotation = $this->getMockBuilder('AppserverIo\Psr\EnterpriseBeans\Annotations\AbstractBeanAnnotation')
                               ->setConstructorArgs(array('Stateless', $values))
                               ->getMockForAbstractClass();

        // create a mock annotation
        $annotation = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionAnnotation')
                           ->setMethods(array('getAnnotationName', 'getValues', 'newInstance'))
                           ->setConstructorArgs(array('Stateless', $values))
                           ->getMock();

        // mock the ReflectionAnnotation methods
        $annotation
            ->expects($this->once())
            ->method('getAnnotationName')
            ->will($this->returnValue('Stateless'));
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
            Resource::ANNOTATION => Resource::__getClass(),
            EnterpriseBean::ANNOTATION => EnterpriseBean::__getClass()
        );

        // create a mock reflection class
        $reflectionClass = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionClass')
                                ->setMethods(array('hasAnnotation'))
                                ->setConstructorArgs(array(__CLASS__, array(), $aliases))
                                ->getMock();
        $reflectionClass
            ->expects($this->once())
            ->method('hasAnnotation')
            ->with('Local')
            ->will($this->returnValue(true));

        // mock the methods
        $this->descriptor
            ->expects($this->once())
            ->method('newAnnotationInstance')
            ->with($reflectionClass)
            ->will($this->returnValue($annotation));

        // initialize the descriptor instance
        $this->descriptor->fromReflectionClass($reflectionClass);
    }

    /**
     * Tests if the deployment initialization from a reflection class with a invalid
     * @Remote bean annotation throws an exception.
     *
     * @return void
     * @expectedException \Exception
     */
    public function testFromReflectionClassWithInvalidRemoteAnnotation()
    {

        // prepare the annotation values
        $values = array();

        // create a mock annotation implementation
        $beanAnnotation = $this->getMockBuilder('AppserverIo\Psr\EnterpriseBeans\Annotations\AbstractBeanAnnotation')
                               ->setConstructorArgs(array('Stateless', $values))
                               ->getMockForAbstractClass();

        // create a mock annotation
        $annotation = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionAnnotation')
                           ->setMethods(array('getAnnotationName', 'getValues', 'newInstance'))
                           ->setConstructorArgs(array('Stateless', $values))
                           ->getMock();

        // mock the ReflectionAnnotation methods
        $annotation
            ->expects($this->once())
            ->method('getAnnotationName')
            ->will($this->returnValue('Stateless'));
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
            Resource::ANNOTATION => Resource::__getClass(),
            EnterpriseBean::ANNOTATION => EnterpriseBean::__getClass()
        );

        // create a mock reflection class
        $reflectionClass = $this->getMockBuilder('AppserverIo\Lang\Reflection\ReflectionClass')
                                ->setMethods(array('hasAnnotation'))
                                ->setConstructorArgs(array(__CLASS__, array(), $aliases))
                                ->getMock();

        // mock the methods
        $reflectionClass
            ->expects($this->exactly(2))
            ->method('hasAnnotation')
            ->withConsecutive(array('Local'), array('Remote'))
            ->willReturnOnConsecutiveCalls(false, true);

        // mock the methods
        $this->descriptor
            ->expects($this->once())
            ->method('newAnnotationInstance')
            ->with($reflectionClass)
            ->will($this->returnValue($annotation));

        // initialize the descriptor instance
        $this->descriptor->fromReflectionClass($reflectionClass);
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
        $node = new \SimpleXMLElement(file_get_contents(__DIR__ . '/_files/dd-sessionbean-to-merge.xml'));

        // initialize the descriptor from the nodes data
        $this->descriptor->fromDeploymentDescriptor($node);

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
     * Tests if the merge method works successfully.
     *
     * @return void
     */
    public function testMergeSuccessful()
    {

        // load the deployment descriptor node
        $node = new \SimpleXMLElement(file_get_contents(__DIR__ . '/_files/dd-sessionbean.xml'));

        // initialize the descriptor from the nodes data
        $this->descriptor->fromDeploymentDescriptor($node);

        // initialize the descriptor to merge
        $descriptorToMerge = $this->getMockForAbstractClass('AppserverIo\Description\SessionBeanDescriptor');
        $nodeToMerge = new \SimpleXMLElement(file_get_contents(__DIR__ . '/_files/dd-sessionbean-to-merge.xml'));
        $descriptorToMerge->fromDeploymentDescriptor($nodeToMerge);

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
