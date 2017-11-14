<?php

/**
 * AppserverIo\Description\BeanDescriptorTest
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

use AppserverIo\Description\Api\Node\BeanNode;
use AppserverIo\Lang\Reflection\ReflectionClass;
use AppserverIo\Psr\EnterpriseBeans\Annotations\Inject;
use AppserverIo\Psr\EnterpriseBeans\Annotations\Resource;
use AppserverIo\Psr\EnterpriseBeans\Annotations\EnterpriseBean;
use AppserverIo\Psr\EnterpriseBeans\Annotations\PersistenceUnit;

/**
 * Test implementation for the BeanDescriptor class implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 *
 * @Inject
 */
class BeanDescriptorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The descriptor instance we want to test.
     *
     * @var \AppserverIo\Description\BeanDescriptor
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
     * Dummy resource reference.
     *
     * @PersistenceUnit(name="PersistenceUnit")
     */
    protected $dummyPersistenceUnit;

    /**
     * Initializes the method we wan to test.
     *
     * @return void
     * @see \PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->descriptor = new BeanDescriptor();
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
     * Injects the dummy persistence unit instance.
     *
     * @param mixed $dummyPersistenceUnit The dummy persistence unit
     *
     * @return void
     * @PersistenceUnit(name="PersistenceUnit")
     */
    public function injectDummyPersistenceUnit($dummyPersistenceUnit)
    {
        $this->dummyPersistenceUnit = $dummyPersistenceUnit;
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
     * Tests the setter/getter for the persistence unit references.
     *
     * @return void
     */
    public function testSetGetPersistenceUnitReferences()
    {
        $this->descriptor->setPersistenceUnitReferences($persistenceUnitReferences = array(new \stdClass()));
        $this->assertSame($persistenceUnitReferences, $this->descriptor->getPersistenceUnitReferences());
    }

    /**
     * Tests if the deployment initialization from a reflection class with a bean annotation
     * containing the name attribute works as expected.
     *
     * @return void
     */
    public function testFromReflectionClassWithAnnotationContainingNameAttribute()
    {

        // initialize the annotation aliases
        $aliases = array(
            Inject::ANNOTATION => Inject::__getClass(),
            Resource::ANNOTATION => Resource::__getClass(),
            EnterpriseBean::ANNOTATION => EnterpriseBean::__getClass(),
            PersistenceUnit::ANNOTATION => PersistenceUnit::__getClass()
        );

        // create a reflection class
        $reflectionClass = new ReflectionClass(__CLASS__, array(), $aliases);

        // initialize the descriptor instance
        $this->descriptor->fromReflectionClass($reflectionClass);

        // check the name parsed from the reflection class
        $this->assertSame(__CLASS__, $this->descriptor->getClassName());
        $this->assertSame('BeanDescriptorTest', $this->descriptor->getName());
        $this->assertCount(1, $this->descriptor->getEpbReferences());
        $this->assertCount(1, $this->descriptor->getResReferences());
        $this->assertCount(1, $this->descriptor->getPersistenceUnitReferences());
        $this->assertCount(3, $this->descriptor->getReferences());
    }

    /**
     * Tests if the deployment initialization from a reflection class with a bean annotation
     * without the name attribute works as expected.
     *
     * @return void
     */
    public function testFromReflectionClassWithAnnotationWithoutNameAttribute()
    {

        // initialize the annotation aliases
        $aliases = array(
            Inject::ANNOTATION => Inject::__getClass(),
            Resource::ANNOTATION => Resource::__getClass(),
            EnterpriseBean::ANNOTATION => EnterpriseBean::__getClass(),
            PersistenceUnit::ANNOTATION => PersistenceUnit::__getClass()
        );

        // create a reflection class
        $reflectionClass = new ReflectionClass(__CLASS__, array(), $aliases);

        // initialize the descriptor instance
        $this->descriptor->fromReflectionClass($reflectionClass);

        // check the name parsed from the reflection class
        $this->assertSame(__CLASS__, $this->descriptor->getClassName());
        $this->assertSame('BeanDescriptorTest', $this->descriptor->getName());
        $this->assertCount(1, $this->descriptor->getEpbReferences());
        $this->assertCount(1, $this->descriptor->getResReferences());
        $this->assertCount(1, $this->descriptor->getPersistenceUnitReferences());
        $this->assertCount(3, $this->descriptor->getReferences());
    }

    /**
     * Tests if the deployment initialization from a deployment descriptor
     * works as expected.
     *
     * @return void
     */
    public function testFromConfiguration()
    {

        // initialize the configuration
        $node = new BeanNode();
        $node->initFromFile(__DIR__ . '/_files/dd-bean.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // check if all values have been initialized
        $this->assertSame('Randomizer', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Apps\Example\Services\Randomizer', $this->descriptor->getClassName());
    }

    /**
     * Tests if the merge method works successfully.
     *
     * @return void
     */
    public function testMergeSuccessful()
    {

        // initialize the configuration
        $node = new BeanNode();
        $node->initFromFile(__DIR__ . '/_files/dd-bean.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // initialize the descriptor to merge
        $descriptorToMerge = $this->getMockForAbstractClass('AppserverIo\Description\BeanDescriptor');

        // initialize the configuration of the descriptor to be merged
        $nodeToMerge = new BeanNode();
        $nodeToMerge->initFromFile(__DIR__ . '/_files/dd-bean-to-merge.xml');
        $descriptorToMerge->fromConfiguration($nodeToMerge);

        // merge the descriptors
        $this->descriptor->merge($descriptorToMerge);

        // check if all values have been merged
        $this->assertSame('Randomizer', $this->descriptor->getName());
        $this->assertSame('AppserverIo\Apps\Example\Services\RandomizerNew', $this->descriptor->getClassName());
    }

    /**
     * Tests if the merge method fails with an exception if the class
     * name doesn't match when try to merge to descriptor instances.
     *
     * @return void
     * @expectedException AppserverIo\Psr\EnterpriseBeans\EnterpriseBeansException
     */
    public function testMergeWithException()
    {

        // initialize the configuration
        $node = new BeanNode();
        $node->initFromFile(__DIR__ . '/_files/dd-bean.xml');

        // initialize the descriptor from the nodes data
        $this->descriptor->fromConfiguration($node);

        // initialize the descriptor to merge
        $descriptorToMerge = $this->getMockForAbstractClass('AppserverIo\Description\BeanDescriptor');

        // initialize the configuration of the descriptor to be merged
        $nodeToMerge = new BeanNode();
        $nodeToMerge->initFromFile(__DIR__ . '/_files/dd-bean-to-merge-with-exception.xml');
        $descriptorToMerge->fromConfiguration($nodeToMerge);

        // merge the descriptors
        $this->descriptor->merge($descriptorToMerge);
    }
}
