<?php

namespace IOC\Resolvers;

class ClassNameResolver implements ClassNameResolverInterface
{
    use \ServiceProviders\IOCProvider;

    private $className;

    public function __construct(string $className)
    {
        $this->className = $className;
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
        $className = isset($this->serviceProviders[$className]) ? $this->serviceProviders[$className] : $className;

        if (class_exists($className)) {
            return $className;
        }

        return $this->resolveInterface(new InterfaceResolver($className));
    }

    private function resolveInterface(InterfaceResolverInterface $interfaceResolver): string
    {
        $className = $interfaceResolver->resolveInterfaceClass($this->className);
        return isset($this->serviceProvider[$className]) ? $this->serviceProvider[$className] : $className ;
    }
}
