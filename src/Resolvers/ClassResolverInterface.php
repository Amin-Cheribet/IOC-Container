<?php

namespace DI\Resolvers;

interface ClassResolverInterface
{
    public function getConstructorParameters(): array;
    public function getMethodParameters(\ReflectionClass $reflector, string $method): array;
    public function getClassName(): string;
    public function getClassShortName(): string;
    public function classExists(string $class): bool;
    public function createClassInstance(array $parameters = null);
}
