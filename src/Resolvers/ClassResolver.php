<?php

namespace IOC\Resolvers;

class ClassResolver implements ClassResolverInterface
{
    private $reflector;

    public function __construct(\ReflectionClass $reflector)
    {
        $this->reflector = $reflector;
    }

    public function getConstructorParameters(): array
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

    public function getMethodParameters(\ReflectionClass $reflector, string $method): array
    {
        $data = $reflector->getMethod($method)->getParameters();
        foreach ($data as $argumentIndex => $arguments) {
            $parameters[] = $arguments->getClass();
        }

        return $parameters;
    }

    public function getClassName(): string
    {
        return $this->reflector->getName();
    }

    public function getClassShortName(): string
    {
        return $this->reflector->getShortName();
    }

    public function classExists(string $class): bool
    {
        return class_exists($class) ? true : false;
    }

    public function createClassInstance(array $parameters = null)
    {
        return $this->reflector->newInstanceArgs($parameters);
    }
}
