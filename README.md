[![Build Status](https://travis-ci.org/MohamedAmine-C/IOC-Container.svg?branch=master)](https://travis-ci.org/MohamedAmine-C/IOC-Container)

# How to install:
### Via composer.json
``` "mohamed-amine/ioc-container": "^0.6" ```
# What can it do:

- create instances and resolve their dependencies automatically.
- resolve dependencies from types( like Interfaces) if they are registered.
- create instances from registred services locators.
- bind existing instances into the container (can be used for service providers).
- call instances from the container anywhere in your application.

# How to use it:
### Create the contianer:
in order to use all the features we need to create a container first
```php
  IOC\IOC::createContainer();
```
### Create an instance in the container:
- to create an instance and resolve it's dependencies automatically:
```php
  IOC\IOC::container()->build('namespace\MyClass');
```
  This will create the MyClass object and create all of it's dependencies recursively for example:
  ```php
  // instead of doing this
  new MyClass(ClassA(), new ClassB());
  // you can just do this and it will create ClassA & ClassB and pass them automatically
  IOC\IOC::container()->build('namespace\MyClass');
  ```
  In order for this to work you need to use type hinting in MyClass constructor :
  ```php
  ...
  public function __constructor(ClassA $classa, ClassB $classb) {...}
  ...
  ```
- if the instance require arguments we should pass them in an array as a second argument of 'build()' (note that automatic dependencies resolving can't be used in this case):
```php
  IOC\IOC::container()->build('namespace\MyClass', $argument1, $argument2);
```

### Bind instances into the container:
To bind an existing instance into the container
```php
  IOC\IOC::bind('MyClass',function() {
    return new namespace\MyClass();
  });
```
Now we will be able to access our instance anywhere in the application like this:
```php
  IOC\IOC::container()->MyClass;
  // or 
  IOC\IOC::container()->get('MyClass');
```

### Build instances from services locators (short names):

We can define service locators using the regiter method
```php
  IOC\IOC::container()->register('MyClass', namespace\MyClass::class);
```
Then we can build an instance using this service locator
```php
  IOC\IOC::container()->build('MyClass');
```

### Registering Types:
Types are registered to help the container to resolve classes dependencies,
for example if a class A have a dependency of Type SomeInterface which is an interface,
we will have to register this type first in order to be able to resolve it:
```php
  IOC\IOC::container()->registerType('SomeInterface', Namespace\SomeClass::class);
```

### Calling instances from the container:
we can call instances from the container using 2 methods
```php
  IOC\IOC::container()->MyInstance;
  // Or
  IOC\IOC::container()->get('MyInstance');
```
