<?php

/**
 * AppserverIo\Description\InjectionTargetDescriptorTest
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

/**
 * Test implementation for the InjectionTargetDescriptor class implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class InjectionTargetDescriptorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The descriptor instance we want to test.
     *
     * @var \AppserverIo\Description\InjectionTargetDescriptor
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
        $this->descriptor = new InjectionTargetDescriptor();
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
            'AppserverIo\Description\InjectionTargetDescriptor',
            InjectionTargetDescriptor::newDescriptorInstance()
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
     * Test that the fromReflectionPropery() method works as expected.
     *
     * @return void
     */
    public function testFromReflectionProperty()
    {
        $this->descriptor->fromReflectionProperty(new ReflectionProperty(__CLASS__, 'dummyEnterpriseBean'));
        $this->assertSame(__CLASS__, $this->descriptor->getTargetClass());
        $this->assertSame('dummyEnterpriseBean', $this->descriptor->getTargetProperty());
        $this->assertNull($this->descriptor->getTargetMethod());
    }

    /**
     * Test that the fromReflectionMethod() method works as expected.
     *
     * @return void
     */
    public function testFromReflectionMethod()
    {
        $this->descriptor->fromReflectionMethod(new ReflectionMethod(__CLASS__, 'injectDummyEnterpriseBean'));
        $this->assertSame(__CLASS__, $this->descriptor->getTargetClass());
        $this->assertSame('injectDummyEnterpriseBean', $this->descriptor->getTargetMethod());
        $this->assertNull($this->descriptor->getTargetProperty());
    }

    /**
     * Tests if the merge method, based on a TargetInjectionDescriptor initialized from
     * a property works successfully.
     *
     * @return void
     */
    public function testMergeSuccessfulWithProperty()
    {

        // initialize a new descriptor from one of our properties
        $descriptor = InjectionTargetDescriptor::newDescriptorInstance();
        $descriptor->fromReflectionProperty(new ReflectionProperty(__CLASS__, 'dummyResource'));

        // initialize a descriptor from another property
        $this->descriptor->fromReflectionProperty(new ReflectionProperty(__CLASS__, 'dummyEnterpriseBean'));
        $this->descriptor->merge($descriptor);

        // check the descriptor values
        $this->assertSame(__CLASS__, $this->descriptor->getTargetClass());
        $this->assertSame('dummyResource', $this->descriptor->getTargetProperty());
        $this->assertNull($this->descriptor->getTargetMethod());
    }

    /**
     * Tests if the merge method, based on a TargetInjectionDescriptor initialized from
     * a method works successfully.
     *
     * @return void
     */
    public function testMergeSuccessfulWithMethod()
    {

        // initialize a new descriptor from one of our properties
        $descriptor = InjectionTargetDescriptor::newDescriptorInstance();
        $descriptor->fromReflectionMethod(new ReflectionMethod(__CLASS__, 'injectDummyResource'));

        // initialize a descriptor from another method
        $this->descriptor->fromReflectionMethod(new ReflectionMethod(__CLASS__, 'injectDummyEnterpriseBean'));
        $this->descriptor->merge($descriptor);

        // check the descriptor values
        $this->assertSame(__CLASS__, $this->descriptor->getTargetClass());
        $this->assertSame('injectDummyResource', $this->descriptor->getTargetMethod());
        $this->assertNull($this->descriptor->getTargetProperty());
    }
}
