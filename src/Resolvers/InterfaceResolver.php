<?php

namespace IOC\Resolvers;

class InterfaceResolver implements InterfaceResolverInterface
{
    public function __construct(string $className)
    {
        return $this->resolveInterfaceClass($className);
    }

    public function resolveInterfaceClass(string $className): string
    {
        $splits        = $this->splitName($className);
        $realClassName = $this->extractClassName(array_pop($splits));
        return $this->bindClassName(array_merge($splits, [$realClassName]));
    }

    private function splitName(string $className): array
    {
        return explode('\\', $className);
    }

    private function extractClassName(string $className): string
    {
        return str_replace('Interface', '', $className);
    }

    private function bindClassName(array $splits): string
    {
        return implode('\\', $splits);
    }
}
