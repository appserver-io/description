<?php

/**
 * AppserverIo\Description\Api\Node\NodeValue
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
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Description\Api\Node;

use AppserverIo\Properties\PropertiesUtil;
use AppserverIo\Properties\PropertiesInterface;
use AppserverIo\Properties\Filter\PropertyStreamFilterParams;
use AppserverIo\Configuration\Interfaces\ValueInterface;
use AppserverIo\Configuration\Interfaces\ConfigurationInterface;

/**
 * Represents a node's value.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class NodeValue implements ValueInterface
{

    /**
     * The nodes value.
     *
     * @var string
     */
    protected $value;

    /**
     * Initializes the node with the value.
     *
     * @param \AppserverIo\Configuration\Interfaces\ConfigurationInterface $configuration The configuration instance
     *
     * @return void
     */
    public function initFromConfiguration(ConfigurationInterface $configuration)
    {
        $this->value = $configuration->getValue();
    }

    /**
     * Initializes the node with the passed data.
     *
     * @param string $value The value to initialize the node with
     */
    public function __construct($value = '')
    {
        $this->value = $value;
    }

    /**
     * Sets the node's value.
     *
     * @param string $value The value to set
     *
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Returns the node value.
     *
     * @return string The node value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Implements toString method
     *
     * @return string
     * @see \AppserverIo\Description\Api\Node\NodeValue::getValue()
     */
    public function __toString()
    {
        return $this->getValue();
    }

    /**
     * Replace the variables in the node's value with the values found in the
     * passed properties instance.
     *
     * @param \AppserverIo\Properties\PropertiesInterface $properties The properties with the values to replace
     * @param string                                      $pattern    The pattern that declares the variables
     *
     * @return void
     */
    public function replaceProperties(PropertiesInterface $properties, $pattern = PropertyStreamFilterParams::PATTERN)
    {
        // query whether or not the node value is a string
        if (is_string($this->value)) {
            // load the properties utility and replace the properties in the node value
            $this->value = PropertiesUtil::singleton()->replacePropertiesInString($properties, $this->value, $pattern);
        }
    }
}
