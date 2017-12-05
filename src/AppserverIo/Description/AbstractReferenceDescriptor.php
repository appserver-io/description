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
abstract class AbstractReferenceDescriptor extends AbstractNameAwareDescriptor implements ReferenceDescriptorInterface
{

    /**
     * Prefix for resource references.
     *
     * @var string
     */
    const REF_DIRECTORY = 'env';

    /**
     * The injection target.
     *
     * @var \AppserverIo\Psr\EnterpriseBeans\Description\InjectionTargetDescriptorInterface
     */
    protected $injectionTarget;

    /**
     * The parent descriptor instance.
     *
     * @var \AppserverIo\Psr\Deployment\DescriptorInterface
     */
    protected $parent;

    /**
     * Initializes the reference descriptor with the parent descriptor.
     *
     * @param \AppserverIo\Description\NameAwareDescriptorInterface $parent The parent descriptor instance
     */
    public function __construct(NameAwareDescriptorInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Return's the parent descriptor instance.
     *
     * @return \AppserverIo\Psr\Deployment\DescriptorInterface
     */
    public function getParent()
    {
        return $this->parent;
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
        return sprintf('%s/%s/%s', $this->getParent()->getName(), self::REF_DIRECTORY, $this->getName());
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
