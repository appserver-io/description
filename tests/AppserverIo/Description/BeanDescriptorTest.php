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

/**
 * Test implementation for the BeanDescriptor class implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
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
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->descriptor = $this->getMockForAbstractClass('AppserverIo\Description\BeanDescriptor');
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
