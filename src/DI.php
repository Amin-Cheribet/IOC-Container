<?php

namespace DI;

use App;
use Exception;

class DI
{
    use App\ServiceProvider;

    public $classes    = [];
    private $reflectors = [];

    public static function container()
    {
        return new static();
    }

    public function build(string $class, array $arguments = null)
    {
        $reflector = new \ReflectionClass($this->resolveClassLocation($class));
        $this->reflectors[$reflector->getShortName()] = $reflector;
        return $this->classes[$reflector->getShortName()] = $this->resolveClass(new Resolvers\ClassResolver($reflector), $arguments);
    }

    private function resolveClassLocation(string $class)
    {
        return isset($this->serviceProviders[$class]) ? $this->serviceProviders[$class] : $class;
    }

    public function get(string $class)
    {
        if (isset($this->classes[$class])) {
            return $this->classes[$class];
        }
        throw new Exception("$class does not exist", 1);
    }

    private function resolveClass(Resolvers\ClassResolver $classResolver, array $arguments = null)
    {
        if ($arguments) {
            return $this->createInstance($classResolver, $arguments);
        }

        $parameters = $classResolver->getConstructorParameters();
        return empty($parameters) ? $this->createInstance($classResolver) : $this->resolveDependencies(new Resolvers\DependencyResolver(), $classResolver, $parameters);

        throw new Exception($classResolver->getClassName()." does not exist", 1);
    }

    private function resolveDependencies(Resolvers\DependencyResolver $dependencyResolver, Resolvers\ClassResolver $classResolver, array $parameters)
    {
        $dependencyResolver->validateDependencies($parameters);
        foreach ($parameters as $key) {
            $dependencies[] = $this->build($key->name);
        }
        $this->createInstance($classResolver, $dependencies);
    }

    private function serviceProvider()
    {
        //
    }

    private function createInstance(Resolvers\ClassResolver $classResolver, array $parameters = [])
    {
        return $classResolver->createClassInstance($parameters);
    }
}
