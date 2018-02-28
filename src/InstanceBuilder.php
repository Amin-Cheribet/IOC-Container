<?php

namespace IOC;

use IOC\Resolvers\ClassNameResolver;
use IOC\Resolvers\ClassResolver;

class InstanceBuilder
{
    public $classResolver;
    public $className;
    public $arguments;

    public function __construct(array $aliases, string $className, array $arguments = [])
    {
        $this->className = $this->resolveClassRealName(new ClassNameResolver($aliases, $className));
        $this->arguments = $arguments;
        $this->setClassResolver(new ClassResolver(new \ReflectionClass($this->className)));
    }

    public function build()
    {
        if (!empty($this->arguments)) {
            return $this->createInstance($this->arguments);
        }
        $parameters = $this->classResolver->getConstructorParameters();

        return empty($parameters) ? $this->createInstance() : $this->resolveDependencies($parameters);
    }

    private function resolveClassRealName(ClassNameResolver $classNameResolver)
    {
        return $classNameResolver->getRealClassName();
    }

    private function resolveDependencies(array $parameters)
    {
        foreach ($parameters as $value => $key) {
            $dependencies[] = $this->build($key->name);
        }
        $this->createInstance($dependencies);
    }

    private function createInstance(array $arguments = [])
    {
        return $this->classResolver->createClassInstance($arguments);
    }

    private function setClassResolver(ClassResolver $resolver)
    {
        $this->classResolver = $resolver;
    }
}
