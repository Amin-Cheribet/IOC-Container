<?php

namespace DI\Resolvers;

use Exception;

class DependencyResolver
{
    public function validateDependencies(array $parameters)
    {
        foreach ($parameters as $$parameter) {
            if (!class_exists($parameter->name)) {
                throw new Exception("$parameter->name is not a class", 1);
            }
        }
    }
}
