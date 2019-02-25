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
        $this->typesAliases    = new Holders\typesAliases();
        $this->instances      = new Holders\InstancesHolder();
    }

    public function build(string $className, ...$arguments)
    {
        $this->factory     = new InstanceFactory($this->classesAliases, $this->typesAliases);
        $instanceResolver  = $this->factory->create($className, $arguments);
        $instanceShortName = (isset($this->classesAliases->$className)) ? $className : $instanceResolver->getClassShortName();

        return $this->instances->{$instanceShortName} = $instanceResolver->getInstance();
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
     * Register a short name (aliase) of a class
     *
     * @param string $key
     * @param string $aliase
     */
    public function registerInteface(string $key, string $aliase): void
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
