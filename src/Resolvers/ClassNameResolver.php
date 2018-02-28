<?php

namespace IOC\Resolvers;

class ClassNameResolver implements ClassNameResolverInterface
{
    private $className;

    public function __construct(array $aliases, string $className)
    {
        $this->className = $className;
        $this->aliases   = $aliases;
    }

    public function getRealClassName(): string
    {
        $classFullName = $this->resolveClassFullName($this->className);

        if (!class_exists($classFullName)) {
            throw new \Exception("$classFullName Resolved from $this->className is not found", 1);
        }

        return $classFullName;
    }

    private function resolveClassFullName(string $className): string
    {
        $className = $this->aliases[$className] ?? $className;

        if (class_exists($className)) {
            return $className;
        }

        return $this->resolveInterface(new InterfaceResolver($className));
    }

    private function resolveInterface(InterfaceResolverInterface $interfaceResolver): string
    {
        $className = $interfaceResolver->resolveInterfaceClass($this->className);
        return $this->aliases[$className] ?? $className;
    }
}
