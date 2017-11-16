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

use AppserverIo\Lang\Reflection\ReflectionParameter;
use AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface;

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
     * The reference description.
     *
     * @var string
     */
    protected $description;

    /**
     * The injection target.
     *
     * @var \AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface
     */
    protected $injectionTarget;

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
     * Sets the reference description.
     *
     * @param string $description The reference description
     *
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the reference description.
     *
     * @return string The reference description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the injection target specification.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface $injectionTarget The injection target specification
     *
     * @return void
     */
    public function setInjectionTarget(InjectionTargetDescriptorInterface $injectionTarget)
    {
        $this->injectionTarget = $injectionTarget;
    }

    /**
     * Returns the injection target specification.
     *
     * @return \AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface The injection target specification
     */
    public function getInjectionTarget()
    {
        return $this->injectionTarget;
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

    /**
     * Compares the name of the passed reflection parameter with the injection target parameter name
     * and return's TRUE if the names are equal, else FALSE.
     *
     * @param \AppserverIo\Lang\Reflection\ReflectionParameter $reflectionParameter The reflection parameter to compare
     *
     * @return boolean TRUE if the names are equal, else FALSE
     */
    public function equals(ReflectionParameter $reflectionParameter)
    {
        return strtolower($reflectionParameter->getParameterName()) === strtolower($this->getInjectionTarget()->getTargetMethodParameterName());
    }
}
