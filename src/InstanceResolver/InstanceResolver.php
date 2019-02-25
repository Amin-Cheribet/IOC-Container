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
        $parameters = [];
        if (!$this->hasMethod('__construct')) {
            return [];
        }
        var_dump($this);
        $data = $this->getConstructor()->getParameters();
        var_dump($data[0]->getClass());
        foreach ($data as $parameter) {
            $parameters[] = $parameter->getClass()->getName();
        }

        return $parameters;
    }

    public function createClassInstance(array $parameters = null)
    {
        return $this->newInstanceArgs($parameters);
    }
}
