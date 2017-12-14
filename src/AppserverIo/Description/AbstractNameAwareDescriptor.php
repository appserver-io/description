<?php

/**
 * AppserverIo\Description\AbstractNameAwareDescriptor
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
 * Abstract descriptor implementation that provides a descriptor name.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2017 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
abstract class AbstractNameAwareDescriptor extends AbstractDescriptor implements NameAwareDescriptorInterface
{

    /**
     * The descriptor's reference name.
     *
     * @var string
     */
    protected $name;

    /**
     * The flag to mark the bean shared or not.
     *
     * @var boolean
     */
    protected $shared = true;

    /**
     * Set's the reference name.
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
     * Return's the reference name.
     *
     * @return string The reference name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set's the flag to mark the bean shared or not.
     *
     * @param boolean $shared TRUE if the bean has to be shared, else FALE
     *
     * @return void
     */
    public function setShared($shared = true)
    {
        $this->shared = $shared;
    }

    /**
     * Return's the flag that marks a bean shared or not.
     *
     * @return boolean TRUE if the bean is shared, else FALSE
     */
    public function isShared()
    {
        return $this->shared;
    }
}
