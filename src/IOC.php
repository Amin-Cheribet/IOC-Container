<?php

namespace IOC;

use Exception;

class IOC
{
    public $classes = [];

    public static function container()
    {
        return new static();
    }

    public function build(string $className, array $arguments = [])
    {
        $builder = new InstanceBuilder($className, $arguments);
        return $this->classes[$builder->classResolver->getClassShortName()] = $builder->build();
    }

    public function get(string $class)
    {
        if (isset($this->classes[$class])) {
            return $this->classes[$class];
        }
        throw new Exception("$class does not exist", 1);
    }

    public function __get(string $className)
    {
        return $this->classes[$className];
    }
}
