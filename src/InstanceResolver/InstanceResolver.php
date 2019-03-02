<?php

namespace IOC\InstanceResolver;

/**
 *
 */
class InstanceResolver extends \ReflectionClass
{
    public function __construct(string $class)
    {
        parent::__construct($class);
    }

    public function getConstructorParameters(): array
    {
        if (!$this->hasMethod('__construct')) {
            return [];
        }

        return $this->resolveParameters();
    }

    private function resolveParameters(): array
    {
        $parameters = [];
        $data = $this->getConstructor()->getParameters();
        foreach ($data as $parameter) {
            $parameters[] = $parameter->getClass()->getName();
        }

        return $parameters;
    }

    public function createClassInstance(array $parameters = [])
    {
        return $this->newInstanceArgs($parameters);
    }
}
