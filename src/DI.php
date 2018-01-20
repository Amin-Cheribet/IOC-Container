<?php

namespace DI;

class DI
{
    private $parameters = [];
    private $instance;

    public function __construct(string $className)
    {
        $reflector = new ReflectionClass($className);
        $this->resolve(new ClassResolver($reflector));
    }

    public function get()
    {
        return $this->instance;
    }

    public function resolve(ClassResolver $resolver)
    {
        $this->parameters[$resolver->getClassName()] = $resolver->getConstructorParameters();
        if ($resolver->classExists($resolver->getClassName())) {
            $this->instance = $resolver->createInstance($resolver->getClassName());
        }
    }
}
