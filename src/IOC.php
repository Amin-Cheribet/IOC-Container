<?php

namespace IOC;

class IOC
{
    private $instances = [];
    private $aliases   = [];

    public static function container()
    {
        return new static();
    }

    public function build(string $className, array $arguments = [])
    {
        $builder = new InstanceBuilder($this->aliases, $className, $arguments);
        $instanceName = $builder->classResolver->getClassShortName();
        return $this->instances[$instanceName] = $builder->build();
    }

    public function bind(string $className, \Closure $action)
    {
        if (array_key_exists($className, $this->instances)) {
            throw new \Exception("$className can't be registred (already exisits)", 15);
        }
        
        $this->instances[$className] = $action();
    }

    public function register($key, $aliase)
    {
        if (array_key_exists($key, $this->aliases)) {
            throw new \Exception("$key aliase already exists", 16);
        }

        $this->aliases[$key] = $aliase;
    }

    public function get(string $class)
    {
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }
        throw new \Exception("$class does not exist", 1);
    }

    public function __get(string $className)
    {
        return $this->instances[$className];
    }
}
