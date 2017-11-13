<?php

/**
 * AppserverIo\Description\AbstractReferenceDescriptor
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

/**
 * Utility class that stores a bean reference configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
abstract class AbstractReferenceDescriptor implements ReferenceDescriptorInterface
{

    /**
     * Prefix for resource references.
     *
     * @var string
     */
    const REF_DIRECTORY = 'env';

    /**
     * The reference name.
     *
     * @var string
     */
    protected $name;

    /**
     * Sets the reference name.
     *
     * @param string $name The reference name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the reference name.
     *
     * @return string The reference name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return's the unique reference name.
     *
     * @return string The unique reference name
     */
    public function getRefName()
    {
        return sprintf('%s/%s', self::REF_DIRECTORY, $this->getName());
    }
}
