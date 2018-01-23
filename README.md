
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

## Use without auto-wiring:

to disable auto-wiring you need to put a second arguments with parameters inside an array

```php
$container->build('Namespace\MyClass', ['parameter1', 'parameter2']);
```

## Use Service Provider:

create a trait 'ServiceProvider.php' with the namespace App
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
$container->build('Router');

// instead of :

$container->build('Router\Router');
```
