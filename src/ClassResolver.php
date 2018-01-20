<?php

namespace DI;

class ClassResolver
{
    private $reflector;

    public function __construct(\ReflectionClass $reflector)
    {
        $this->reflector = $reflector;
    }

    public function getConstructorParameters()
    {
        $data = $this->reflector->getConstructor()->getParameters();
        foreach ($data as $argumentIndex => $arguments) {
            $parameters[] = $arguments->getClass();
        }

        return $parameters;
    }

    public function getMethodParameters()
    {
        $data = $this->reflector->getConstructor()->getParameters();
        foreach ($data as $argumentIndex => $arguments) {
            $parameters[] = $arguments->getClass();
        }

        return $parameters;
    }

    public function getClassName()
    {
        return $this->reflector->getName();
    }

    public function classExisits(string $class)
    {
        if (class_exists($class)) {
            return true;
        }
        return false;
    }

    public function createInstance(array $parameters)
    {
        return $reflector->newInstanceArgs($parameters);
    }
}
