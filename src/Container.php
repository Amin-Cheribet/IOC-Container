<?php

namespace IOC;

class Container
{
    /**
     * Container instances.
     *
     * @var array
     */
    private $instances = [];

    /**
     * Classes short names.
     *
     * @var array
     */
    private $aliases = [];

    /**
     * Create an instance from a given full namespace fo class
     * Or from predefined aliases
     *
     * @param string $className
     * @param array $arguments
     *
     * @return object
     */
    public function build(string $className, array $arguments = [])
    {
        $builder = new InstanceBuilder($this->aliases, $className, $arguments);
        $instanceName = isset($this->aliases[$className]) ? $className : $builder->classResolver->getClassShortName();

        return $this->instances[$instanceName] = $builder->build();
    }

    /**
     * Bind instance into the container.
     *
     * @param string $className
     * @param Closure $action
     */
    public function bind(string $className, \Closure $action): void
    {
        if (array_key_exists($className, $this->instances)) {
            throw new \Exception("$className can't be registred (already exisits)", 15);
        }

        $this->instances[$className] = $action();
    }

    /**
     * Register a short name (aliase) of a class
     *
     * @param string $key
     * @param string $aliase
     */
    public function register(string $key, string $aliase): void
    {
        if (array_key_exists($key, $this->aliases)) {
            throw new \Exception("$key aliase already exists", 16);
        }

        $this->aliases[$key] = $aliase;
    }

    /**
     * Get an instance from container by it's class name.
     *
     * @param string $class
     *
     * @return object
     */
    public function get(string $class)
    {
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }
        throw new \Exception("$class does not exist", 1);
    }

    /**
     * return an instance from the container.
     *
     * @param string $className
     *
     * @return object
     */
    public function __get(string $className)
    {
        return $this->instances[$className];
    }
}
