<?php

/**
 * AppserverIo\Description\StatefulSessionBeanDescriptorTest
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
use AppserverIo\Psr\EnterpriseBeans\Annotations\Stateful;

/**
 * Test implementation for the StatefulSessionBeanDescriptor class implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 *
 * @Stateful
 */
class StatefulSessionBeanDescriptorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The descriptor instance we want to test.
     *
     * @var \AppserverIo\Description\StatefulSessionBeanDescriptor
     */
    protected $descriptor;

    /**
     * Initializes the descriptor instance we want to test.
     *
     * @return void
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->descriptor = new StatefulSessionBeanDescriptor();
    }

    /**
     * Tests the static newDescriptorInstance() method.
     *
     * @return void
     */
    public function testNewDescriptorInstance()
    {
        $this->assertInstanceOf(
            'AppserverIo\Description\StatefulSessionBeanDescriptor',
            StatefulSessionBeanDescriptor::newDescriptorInstance()
        );
    }

    /**
     * Tests that initialization from a reflection class works as expected.
     *
     * @return void
     */
    public function testFromReflectionClass()
    {

        // initialize the annotation aliases
        $aliases = array(Stateful::ANNOTATION => Stateful::__getClass());

        // create the reflection class
        $reflectionClass = new ReflectionClass(__CLASS__, array(), $aliases);

        // check that the descriptor has been initialized
        $this->assertSame($this->descriptor, $this->descriptor->fromReflectionClass($reflectionClass));
        $this->assertSame('StatefulSessionBeanDescriptorTest', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Description\StatefulSessionBeanDescriptorTest', $this->descriptor->getClassName());
        $this->assertCount(0, $this->descriptor->getEpbReferences());
        $this->assertCount(0, $this->descriptor->getResReferences());
        $this->assertCount(0, $this->descriptor->getReferences());
    }

    /**
     * Tests that initialization from a reflection class without @Stateful
     * annotation won't work.
     *
     * @return void
     */
    public function testFromInvalidReflectionClass()
    {

        // initialize the annotation aliases
        $aliases = array(Stateful::ANNOTATION => Stateful::__getClass());

        // create the reflection class
        $reflectionClass = new ReflectionClass('\stdClass', array(), $aliases);

        // check that the descriptor has not been initialized
        $this->assertNull($this->descriptor->fromReflectionClass($reflectionClass));
    }

    /**
     * Tests that initialization from a deployment descriptor class works as expected.
     *
     * @return void
     */
    public function testFromDeploymentDescriptor()
    {

        // load the deployment descriptor node
        $node = new \SimpleXMLElement(file_get_contents(__DIR__ . '/_files/dd-statefulsessionbean.xml'));

        // initialize the descriptor from the nodes data
        $this->descriptor->fromDeploymentDescriptor($node);

        // check that the descriptor has been initialized
        $this->assertSame($this->descriptor, $this->descriptor->fromDeploymentDescriptor($node));
        $this->assertSame('UserProcessor', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Apps\Example\Services\UserProcessor', $this->descriptor->getClassName());
    }

    /**
     * Tests that initialization from an wrong deployment descriptor, e. g. a
     * message driven bean, won't work.
     *
     * @return void
     */
    public function testFromWrongDeploymentDescriptor()
    {

        // load the deployment descriptor node
        $node = new \SimpleXMLElement(file_get_contents(__DIR__ . '/_files/dd-messagedrivenbean.xml'));

        // check that the descriptor has not been initialized
        $this->assertNull($this->descriptor->fromDeploymentDescriptor($node));
    }

    /**
     * Tests that initialization from an invalid deployment descriptor won't work.
     *
     * @return void
     */
    public function testFromInvalidDeploymentDescriptor()
    {

        // load the deployment descriptor node
        $node = new \SimpleXMLElement(file_get_contents(__DIR__ . '/_files/dd-sessionbean.xml'));

        // check that the descriptor has not been initialized
        $this->assertNull($this->descriptor->fromDeploymentDescriptor($node));
    }
}
