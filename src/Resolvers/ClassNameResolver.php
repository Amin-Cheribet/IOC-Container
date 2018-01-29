<?php

namespace DI\Resolvers;

class ClassNameResolver implements ClassNameResolverInterface
{
    use \App\ServiceProvider;

    private $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function getRealClassName(): string
    {
        return $this->resolveRealName($this->className);
    }

    private function resolveRealName(string $className): string
    {
        $className = isset($this->serviceProviders[$className]) ? $this->serviceProviders[$className] : $className;

        if (class_exists($className)) {
            return $className;
        }

        if (interface_exists($className)) {
            return $this->resolveInterface(new InterfaceResolver($className));
        }

        throw new \Exception("$className is not found", 1);
    }

    private function resolveInterface(InterfaceNameResolver $interfaceResolver): string
    {
        return $interfaceResolver->resolveInterfaceClass();
    }
}
