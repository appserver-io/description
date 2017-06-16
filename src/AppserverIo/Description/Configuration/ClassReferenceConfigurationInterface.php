<?php

/**
 * AppserverIo\Description\Configuration\ClassReferenceConfigurationInterface
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

namespace AppserverIo\Description\Configuration;

/**
 * Interface for a class reference DTO implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
interface ClassReferenceConfigurationInterface
{

    /**
     * Return's the class reference name information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The class reference name information
     */
    public function getClassRefName();

    /**
     * Return's the class reference type information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The class reference type information
     */
    public function getClassRefType();

    /**
     * Return's the class description information.
     *
     * @return \AppserverIo\Description\Api\Node\ValueNode The class description information
     */
    public function getDescription();

    /**
     * Return's the class injection target information.
     *
     * @return \AppserverIo\Description\Api\Node\InjectionTargetNode The class injection target information
     */
    public function getInjectionTarget();
}
