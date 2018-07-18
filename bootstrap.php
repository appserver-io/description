<?php

/**
 * bootstrap.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category  Library
 * @package   Lang
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2014 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */

use Doctrine\Common\Annotations\AnnotationRegistry;

// configure the autoloader
$loader = require 'vendor/autoload.php';
$loader->add('AppserverIo\\Description', 'src');

// load the annotation registries for the annotation reader
AnnotationRegistry::registerAutoloadNamespaces(
    array(
        'AppserverIo\Psr\Servlet\Annotations' => __DIR__ . '/vendor/appserver-io-psr/servlet/src',
        'AppserverIo\Psr\EnterpriseBeans\Annotations' => __DIR__ . '/vendor/appserver-io-psr/epb/src'
    )
);
