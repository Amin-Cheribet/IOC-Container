<?php

namespace IOC;

class Container
{
    private $factory;
    private $classesAliases;
    private $typesAliases;
    private $instances;

    public function __construct()
    {
        $this->classesAliases = new Holders\ClassesAliases();
        $this->typesAliases   = new Holders\TypesAliases();
        $this->instances      = new Holders\InstancesHolder();
    }

    public function build(string $className, ...$arguments)
    {
        $this->factory     = new InstanceFactory($className, $this->classesAliases, $this->typesAliases);
        $instanceShortName = (isset($this->classesAliases->$className)) ? $className : $this->factory->instanceResolver->getShortName();

        return $this->instances->$instanceShortName = $this->factory->create($arguments);
    }

    /**
     * Bind instance into the container.
     *
     * @param string $instanceName
     * @param Closure $action
     */
    public function bind(string $instanceName, \Closure $action): void
    {
        $this->instances->$instanceName = $action();
    }

    /**
     * Register a short name (aliase) of a class
     *
     * @param string $key
     * @param string $aliase
     */
    public function register(string $key, string $aliase): void
    {
        $this->classesAliases->$key = $aliase;
    }

    /**
     * Register a short name (aliase) of a Type
     *
     * @param string $key
     * @param string $aliase
     */
    public function registerType(string $key, string $aliase): void
    {
        $this->typesAliases->$key = $aliase;
    }

    /**
     * Get an instance from container by it's class name.
     *
     * @param string $instance
     *
     * @return object
     */
    public function get(string $instance)
    {
        return $this->instances->$instance;
    }

    /**
     * return an instance from the container.
     *
     * @param string $instance
     *
     * @return object
     */
    public function __get(string $instance)
    {
        return $this->get($instance);
    }
}
