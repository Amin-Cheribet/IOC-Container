<?php

namespace IOC\InstanceResolver;

/**
 *
 */
class InstanceBuilder extends \ReflectionClass
{
    public function __construct(string $class)
    {
        parent::__construct($class);
    }
}
