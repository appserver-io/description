# Version 12.0.3

## Bugfixes

* Reset to version 12.0.0 and add PHPUnit test for constructor injection with three arguements with the same type

## Features

* None

# Version 12.0.2

## Bugfixes

* Make sure overriding an references from a deployment descriptors will be taken into account

## Features

* None

# Version 12.0.1

## Bugfixes

* Fixing descriptor reference handling

## Features

* None

# Version 12.0.0

## Bugfixes

* None

## Features

* Switch to Doctrine Annotations

# Version 11.0.0

## Bugfixes

* None

## Features

* Add persistence unit descriptor interfaces + implementations from appserver-io/appserver to this library

# Version 10.0.0

## Bugfixes

* None

## Features

* Move descriptor interfaces to appserver-io/epb
* Add FixtureDescriptor and MigrationDescriptor implementation

# Version 9.0.1

## Bugfixes

* Move appserver-io dependencies from require-dev to require

## Features

* None

# Version 9.0.0

## Bugfixes

* None

## Features

* Add new configuration + descriptors for DI method invocation

# Version 8.0.1

## Bugfixes

* Fixed error with missing method parameter name when initializing a InjectionTargetDescriptor from configuration

## Features

* None

# Version 8.0.0

## Bugfixes

* None

## Features

* Refactoring for new DI implemenation

# Version 7.0.1

## Bugfixes

* None

## Features

* Switch to latest appserver-io-psr/epb version 4.0.0

# Version 7.0.0

## Bugfixes

* None

## Features

* Add @PrePassivate + @PostActivate annotations to SFSB
* Add @PreAttach + @PostDetach annotations to SSB

# Version 6.0.0

## Bugfixes

* None

## Features

* Add remove method functionality

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