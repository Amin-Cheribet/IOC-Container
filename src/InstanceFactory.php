<?php

namespace IOC;

use IOC\ClassFinder\NamespaceFinder;
use IOC\ClassFinder\NamespaceFinderInterface;
use IOC\InstanceResolver\InstanceResolver;
use IOC\Holders\Holder as Holder;
use IOC\Holders\RegisteryHolder as RegisteryHolder;

class InstanceFactory
{
    private $instanceResolver;
    private $instance;
    private $classShortName;
    private $classesHolder;
    private $interfacesHolder;
    private $classNameFlag = true;

    public function __construct(RegisteryHolder $classesHolder, RegisteryHolder $interfacesHolder)
    {
        $this->classesHolder   = $classesHolder;
        $this->interfacesHolder = $interfacesHolder;
    }

    /**
     * Create an instance from given class name
     * And create instances from it's arguments
     * if it's arguments are valide classes
     *
     */
    public function create(string $className, ...$arguments): self
    {
        $this->classNamespace   = $this->resolveClassRealName(new NamespaceFinder($className, $this->classesHolder, $this->interfacesHolder));
        $this->instanceResolver = new InstanceResolver($this->classNamespace);
        $this->setClassShortName($className, $this->instanceResolver->getShortName());
        if (!empty($arguments)) {
            $this->instance = $this->createInstance($arguments[0]);
            return $this;
        }
        $constructorParameters  = $this->instanceResolver->getConstructorParameters();

        $this->instance = empty($constructorParameters) ? $this->createInstance() : $this->resolveInstanceDependencies($constructorParameters);
        return $this;
    }

    private function setClassShortName(string $userName, string $realName): void
    {
        if ($this->classNameFlag) {
            $this->classShortName = $userName;
            if (class_exists($userName)) {
                $this->classShortName = $realName;
            }
        }
        $this->raisFlag();
    }

    private function raisFlag(): void
    {
        $this->classNameFlag = false;
    }

    public function getInstance()
    {
        return $this->instance;
    }

    public function getClassShortName()
    {
        return $this->classShortName;
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
    private function resolveInstanceDependencies(array $constructorParameters)
    {
        foreach ($constructorParameters as $value) {
            $dependencies[] = $this->create($value->getClass()->getNamespaceName());
        }

        return $this->createInstance($dependencies);
    }

    /**
     * Create instance of object
     *
     * @param array $arguments
     * @return object
     */
    private function createInstance(array $arguments = [])
    {
        return $this->instanceResolver->createClassInstance($arguments);
    }
}
