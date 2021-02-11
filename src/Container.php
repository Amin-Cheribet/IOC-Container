<?php

namespace IOC;

use IOC\Holders\ClassesAliases as ClassesAliases;
use IOC\Holders\TypesAliases as TypesAliases;
use IOC\Holders\InstancesHolder as InstancesHolder;

class Container
{
    private InstanceFactory $factory;
    private ClassesAliases $classesAliases;
    private TypesAliases $typesAliases;
    private InstancesHolder $instances;

    public function __construct()
    {
        $this->classesAliases = new ClassesAliases();
        $this->typesAliases   = new TypesAliases();
        $this->instances      = new InstancesHolder();
    }

    public function build(string $className, ...$arguments): Object
    {
        $this->factory     = new InstanceFactory($className, $this->classesAliases, $this->typesAliases);
        $instanceShortName = (isset($this->classesAliases->$className)) ? $className : $this->factory->instanceResolver->getShortName();

        return $this->instances->{$instanceShortName} = $this->factory->create($arguments);
    }

    /**
     * Bind instance into the container.
     *
     */
    public function bind(string $instanceName, \Closure $action): void
    {
        $this->instances->$instanceName = $action();
    }

    /**
     * Delete Instance from the container.
     *
     */
    public function destroy(string $instanceName): void
    {
        unset($this->instances->$instanceName);
    }

    /**
     * Register a short name (aliase) of a class
     *
     */
    public function register(string $key, string $aliase): void
    {
        $this->classesAliases->$key = $aliase;
    }

    /**
     * Register a short name (aliase) of a Type
     *
     */
    public function registerType(string $key, string $aliase): void
    {
        $this->typesAliases->$key = $aliase;
    }

    /**
     * Get an instance from container by it's class name.
     *
     */
    public function get(string $instance): object
    {
        return $this->instances->$instance;
    }

    /**
     * return an instance from the container.
     *
     */
    public function __get(string $instance): object
    {
        return $this->get($instance);
    }

    public function __isset(string $instance): bool
    {
        return (isset($this->instances->$instance)) ? true: false;
    }

    public function __unset(string $instance): void
    {
        unset($this->instances->$instance);
    }
}
