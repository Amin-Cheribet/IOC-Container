<?php

namespace DI\Resolvers;

class ClassNameResolver implements ClassNameResolverInterface
{
    use \App\ServiceProvider;

    public function __construct(string $className)
    {
        return $this->getRealClassName($className);
    }

    public function getRealClassName(string $className): string
    {
        $realName = $this->resolveRealName($className);

        if (!class_exists($realName)) {
            throw new \Exception("$className is not found", 1);
        }

        return $realName;
    }

    private function resolveRealName(string $className): string
    {
        $className = isset($this->serviceProviders[$className]) ? $this->serviceProviders[$className] : $className;

        if (class_exists($className)) {
            return $className;
        }

        return $this->resolveInterface(new InterfaceResolver($className));
    }

    private function resolveInterface(InterfaceNameResolver $interfaceResolver): string
    {
        $className = $interfaceResolver->resolveInterfaceClass();
        return isset($this->serviceProvider[$className]) ? $this->serviceProvider[$className] : $className ;
    }
}
