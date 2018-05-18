<?php

/**
 * AppserverIo\Description\Configuration\MetadataConfigurationInterface
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

namespace AppserverIo\Description\Configuration;

/**
 * Interface for the Doctrine Entity Manager's metadata configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2018 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/description
 * @link      http://www.appserver.io
 */
interface MetadataConfigurationInterface
{

    /**
     * Constant for the parameter 'isDevMode'.
     *
     * @var string
     */
    const PARAM_IS_DEV_MODE = 'isDevMode';

    /**
     * Constant for the parameter 'proxyDir'.
     *
     * @var string
     */
    const PARAM_PROXY_DIR = 'proxyDir';

    /**
     * Constant for the parameter 'proxyNamespace'.
     *
     * @var string
     */
    const PARAM_PROXY_NAMESPACE = 'proxyNamespace';

    /**
     * Constant for the parameter 'useSimpleAnnotationReader'.
     *
     * @var string
     */
    const PARAM_USE_SIMPLE_ANNOTATION_READER = 'useSimpleAnnotationReader';

    /**
     * Constant for the parameter 'autoGenerateProxyClasses'.
     *
     * @var string
     */
    const PARAM_AUTO_GENERATE_PROXY_CLASSES = 'autoGenerateProxyClasses';

    /**
     * Returns the class name for the metadata configuration driver.
     *
     * @return string The class name for the metadata configuration driver
     */
    public function getType();

    /**
     * Returns the factory class name for the metadata configuration driver.
     *
     * @return string The factory class name for the metadata configuration driver
     */
    public function getFactory();
}
