<?php

namespace IOC\Resolvers;

interface ClassResolverInterface
{
    public function getConstructorArguments(): array;
    public function getClassName(): string;
    public function getClassShortName(): string;
    public function classExists(string $class): bool;
    public function createClassInstance(array $arguments = null);
}
