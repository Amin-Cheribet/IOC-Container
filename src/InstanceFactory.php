<?php

namespace IOC;

use IOC\ClassFinder\NamespaceFinder;
use IOC\ClassFinder\NamespaceFinderInterface;
use IOC\InstanceResolver\InstanceResolver;
use IOC\Holders\Holder as Holder;
use IOC\Holders\RegisteryHolder as RegisteryHolder;

class InstanceFactory
{
    public $instanceResolver;
    private $classesHolder;
    private $typesAliases;

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
    public function create(...$arguments)
    {
        if (!empty($arguments[0])) {
            return $this->createInstance($this->instanceResolver, $arguments[0]);
        }
        $constructorParameters  = $this->instanceResolver->getConstructorParameters();

        return empty($constructorParameters) ? $this->createInstance($this->instanceResolver) : $this->resolveInstanceDependencies($this->instanceResolver, $constructorParameters);
    }

    private function createDependency(string $className)
    {
        $classNamespace        = $this->resolveClassRealName(new NamespaceFinder($className, $this->classesHolder, $this->typesAliases));
        $instanceResolver      = new InstanceResolver($classNamespace);
        $constructorParameters = $instanceResolver->getConstructorParameters();

        return empty($constructorParameters) ? $this->createInstance($instanceResolver) : $this->resolveInstanceDependencies($instanceResolver, $constructorParameters);
    }

    /**
     * Resolve class real name from full namespace.
     *
     * @param ClassNameResolver $classNameResolver
     * @return string
     */
    private function resolveClassRealName(NamespaceFinderInterface $classNameResolver): string
    {
        return $classNameResolver->getRealClassName();
    }

    /**
     * Create arguments instances
     *
     * @param array $constructorParameters
     * @return object
     */
    private function resolveInstanceDependencies(InstanceResolver $instanceResolver, array $constructorParameters)
    {
        foreach ($constructorParameters as $value) {
            $dependencies[] = $this->createDependency($value);
        }

        return $this->createInstance($instanceResolver, $dependencies);
    }

    /**
     * Create instance of object
     *
     * @param array $arguments
     * @return object
     */
    private function createInstance(InstanceResolver $instanceResolver, array $arguments = [])
    {
        return $instanceResolver->createClassInstance($arguments);
    }
}
