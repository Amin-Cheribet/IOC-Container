<?php

namespace DI\Resolvers;

class ClassResolver
{
    private $reflector;

    public function __construct(\ReflectionClass $reflector)
    {
        $this->reflector = $reflector;
    }

    public function getConstructorParameters()
    {
        if (!$this->reflector->hasMethod('__construct')) {
            return [];
        }
        $data = $this->reflector->getConstructor()->getParameters();
        foreach ($data as $argumentIndex => $arguments) {
            $parameters[] = $arguments->getClass();
        }

        return $parameters;
    }

    public function getMethodParameters(\ReflectionClass $reflector, string $method)
    {
        $data = $reflector->getMethod($method)->getParameters();
        foreach ($data as $argumentIndex => $arguments) {
            $parameters[] = $arguments->getClass();
        }

        return $parameters;
    }

    public function getClassName()
    {
        return $this->reflector->getName();
    }

    public function getClassShortName()
    {
        return $this->reflector->getShortName();
    }

    public function classExists(string $class)
    {
        return class_exists($class) ? true : false;
    }

    public function createClassInstance(array $parameters = null)
    {
        return $this->reflector->newInstanceArgs($parameters);
    }
}
