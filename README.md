
# Features:
- this container will resolve all of your dependencies and their dependencies and so on.

# How to install:
```
composer require mohamed-amine/di-container
```
# How to use:

## Basic example:

```php
use DI\DI;

$container = DI::container();

// instead of 
$object = new Myclass(new Class1(new SubClass(), new Class2();

// use this
$container->build('NameSpace\MyClass');


// call a method from MyClass object
$container->get('MyClass')->someMethod();

```

## How to use arguments (without auto-wiring):

you can add arguments inside an array as a second parameter:

```php
$container->build('Namespace\MyClass', ['parameter1', 'parameter2']);
```

## Use Service Provider:

create a trait 'ServiceProvider.php' with the namespace ```App```
NOTE: You must use the namespace ```App``` and a file with the name 'ServiceProvider.php' like this:
```php
namespace App;

/**
 * Provide short names to the dependency injection container
 */
trait ServiceProvider
{
    private $serviceProviders = [
        'Router' => \Router\Router::class,
        'Kernel' => \Kernel\Kernel::class,
        'Launcher' => \Kernel\Launcher::class,
    ];
}
```

### after adding this ServiceProvider we will be able to use short-names:

```php
// instead of :
$container->build('Router\Router');

// you can use this :
$container->build('Router\Router');

```
