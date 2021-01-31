<?php

namespace IOC;

use IOC\ClassFinder\NamespaceFinder;
use IOC\ClassFinder\NamespaceFinderInterface;
use IOC\InstanceResolver\InstanceResolver as InstanceResolver;
use IOC\Holders\RegisteryHolder as RegisteryHolder;

class InstanceFactory
{
    public InstanceResolver $instanceResolver;
    private RegisteryHolder $classesHolder;
    private RegisteryHolder $typesAliases;

    public function __construct(string $className, RegisteryHolder $classesHolder, RegisteryHolder $typesAliases)
    {
        $this->classesHolder    = $classesHolder;
        $this->typesAliases     = $typesAliases;
        $classNamespace         = $this->resolveClassRealName(new NamespaceFinder($className, $this->classesHolder, $this->typesAliases));
        $this->instanceResolver = new InstanceResolver($classNamespace);
    }

    /**
     * Create an instance from given class name
     * And create instances from it's arguments
     * if it's arguments are valide classes
     *
     */
    public function create(...$arguments): Object
    {
        if (!empty($arguments[0])) {
            return $this->createInstance($this->instanceResolver, $arguments[0]);
        }
        $constructorParameters  = $this->instanceResolver->getConstructorParameters();

        return empty($constructorParameters) ? $this->createInstance($this->instanceResolver) : $this->resolveInstanceDependencies($this->instanceResolver, $constructorParameters);
    }

    private function createDependency(string $className): Object
    {
        $classNamespace        = $this->resolveClassRealName(new NamespaceFinder($className, $this->classesHolder, $this->typesAliases));
        $instanceResolver      = new InstanceResolver($classNamespace);
        $constructorParameters = $instanceResolver->getConstructorParameters();

        return empty($constructorParameters) ? $this->createInstance($instanceResolver) : $this->resolveInstanceDependencies($instanceResolver, $constructorParameters);
    }

    /**
     * Find class full namespace.
     */
    private function resolveClassRealName(NamespaceFinderInterface $classNameResolver): string
    {
        return $classNameResolver->getRealClassName();
    }

    /**
     * Create dependencies instances
     *
     * @return object
     */
    private function resolveInstanceDependencies(InstanceResolver $instanceResolver, array $constructorParameters): Object
    {
        foreach ($constructorParameters as $value) {
            $dependencies[] = $this->createDependency($value);
        }

        return $this->createInstance($instanceResolver, $dependencies);
    }

    /**
     * Create instance of an object from it's classReflection
     *
     * @return object
     */
    private function createInstance(InstanceResolver $instanceResolver, array $arguments = []): Object
    {
        return $instanceResolver->createClassInstance($arguments);
    }
}
