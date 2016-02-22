# Version 5.0.0

## Bugfixes

* None

## Features

* Add method replaceProperties() to recursively replace variables in value nodes with values from a property file
* Remove protected replacePropertiesInString() and replacePropertiesInStream() methods => switch properties library

# Version 4.0.0

## Bugfixes

* None

## Features

* Add method replaceProperties() to recursively replace variables in node values with values from a property file

# Version 3.0.1

## Bugfixes

* None

## Features

* Add PHPUnit tests for AbstractNode and AbstractValueNode classes

# Version 3.0.0

## Bugfixes

* None

## Features

* Add preInit() and postInit() callbacks to AbstractNode class

# Version 2.0.0

## Bugfixes

* None

## Features

* Using configuration based initialization and replace fromDeploymentDescriptor() with fromConfiguration() method

# Version 1.2.2

## Bugfixes

* None

## Features

* Use value of beanName instead of name when beanInterface value is not specified

# Version 1.2.1

## Bugfixes

* Introduced type check on merge to avoid Fatal Errors on mismatches

## Features

* None

# Version 1.2.0

## Bugfixes

* None

## Features

* Add persistence unit descriptor functionality for Doctrine integration

# Version 1.1.0

## Bugfixes

* None

## Features

* Implement post-detach and pre-attach lifecycle callback annotation and deployment descriptor parsing

# Version 1.0.0

## Bugfixes

* None

## Features

* Move deployment descriptors from appserver-io/appserver to this package to allow framework decoupling