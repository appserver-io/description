<?php

/**
 * AppserverIo\Description\FactoryDescriptor
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
 * @copyright 2018 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Description;

use AppserverIo\Description\Configuration\ConfigurationInterface;
use AppserverIo\Psr\Application\ApplicationInterface;
use AppserverIo\Psr\EnterpriseBeans\Description\PersistenceUnitFactoryDescriptorInterface;
use AppserverIo\Description\Configuration\PersistenceUnitConfigurationInterface;

/**
 * Descriptor implementation for a persistence unit factory.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2018 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
class PersistenceUnitFactoryDescriptor extends BeanDescriptor implements PersistenceUnitFactoryDescriptorInterface
{

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\PersistenceUnitFactoryDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new PersistenceUnitFactoryDescriptor();
    }

    /**
     * Initializes a bean configuration instance from the passed configuration node.
     *
     * @param \AppserverIo\Description\Configuration\ConfigurationInterface $configuration The bean configuration
     *
     * @return void
     */
    public function fromConfiguration(ConfigurationInterface $configuration)
    {

        // query whether or not we've preference configuration
        if (!$configuration instanceof PersistenceUnitConfigurationInterface) {
            return;
        }

        // query for the name and set it
        if ($name = (string) $configuration->getName()) {
            $this->setName(sprintf('%sFactory', DescriptorUtil::trim($name)));
        }

        // query for the class name and set it
        if ($className = (string) $configuration->getFactory()) {
            $this->setClassName(DescriptorUtil::trim($className));
        }

        // initialize  the reference to the application
        $applicationReference = ResReferenceDescriptor::newDescriptorInstance($this);
        $applicationReference->setName('Application');
        $applicationReference->setType(ApplicationInterface::IDENTIFIER);
        $applicationReference->setPosition(0);

        // initialize and set the injection target for the reference to the application
        $injectionTarget = InjectionTargetDescriptor::newDescriptorInstance();
        $injectionTarget->setTargetClass($configuration->getFactory());
        $injectionTarget->setTargetMethod('__construct');
        $injectionTarget->setTargetMethodParameterName('application');
        $applicationReference->setInjectionTarget($injectionTarget);

        // add the reference to the application
        $this->addResReference($applicationReference);

        // initialize the reference to the configuration
        $configurationReference = ResReferenceDescriptor::newDescriptorInstance($this);
        $configurationReference->setName('PersistenceUnitNode');
        $configurationReference->setType(sprintf('%sConfiguration', DescriptorUtil::trim($name)));
        $configurationReference->setPosition(1);

        // initialize and set the injection target for the reference to the configuration
        $injectionTarget = InjectionTargetDescriptor::newDescriptorInstance();
        $injectionTarget->setTargetClass($configuration->getFactory());
        $injectionTarget->setTargetMethod('__construct');
        $injectionTarget->setTargetMethodParameterName('persistenceUnitNode');
        $configurationReference->setInjectionTarget($injectionTarget);

        // add the reference to the configuration
        $this->addResReference($configurationReference);

        // return the instance
        return $this;
    }
}
