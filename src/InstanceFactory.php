<?php

namespace IOC;

use IOC\ClassFinder\NamespaceFinder;
use IOC\InstanceREsolver\InstanceResolver;
use IOC\Holders\Holder as Holder;

class InstanceBuilder
{
    private $instanceResolver;
    private $instance;
    private $classShortName;
    private $classesHolder;
    private $interfacesHolder;

    /**
     * Create an instance from given class name
     * And create instances from it's arguments
     * if it's arguments are valide classes
     *
     * @return object
     */
    public function create(string $className, mixed ...$arguments)
    {
        if (!empty($this->arguments)) {
            return $this->createInstance($this->arguments);
        }
        $this->classNamespace   = $this->resolveClassRealName(new NamespaceFinder($className, $this->classesHolder, $this->interfacesHolder));
        $this->instanceResolver = new InstanceResolver($this->classNamespace);
        $this->classShortName   = $this->instanceShortName ?? $this->instanceResolver->getShortName();
        $constructorParameters  = $this->instanceResolver->getConstructorParameters();

        $this->instance = empty($constructorParameters) ? $this->createInstance() : $this->resolveInstanceDependencies($constructorParameters);
    }

    public function initiat(RegisteryHolder $classesHolder, RegisteryHolder $interfacesHolder)
    {
        $this->classesHolder   = $classesHolder;
        $this->interfacesHolder = $interfacesHolder;
    }

    public function getInsatnce()
    {
        return $this->instance;
    }

    public function getClassName()
    {
        return $this->classShortName;
    }

    /**
     * Resolve class real name from full namespace.
     *
     * @param ClassNameResolver $classNameResolver
     * @return string
     */
    private function resolveClassRealName(ClassFinder $classNameResolver): string
    {
        return $classNameResolver->getRealClassName();
    }

    /**
     * Create arguments instances
     *
     * @param array $constructorParameters
     * @return object
     */
    private function resolveInstanceDependencies(array $constructorParameters)
    {
        foreach ($constructorParameters as $value => $key) {
            $dependencies[] = $this->create($key->getClass()->getNamespaceName());
        }

        return $this->createInstance($dependencies);
    }

    /**
     * Create instance of object
     *
     * @param array $arguments
     * @return object
     */
    private function createInstance(mixed ...$arguments)
    {
        return $this->instanceResolver->createClassInstance($arguments);
    }
}
