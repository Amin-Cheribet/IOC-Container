<?php

namespace IOC\Holders;

interface InstancesHolderInterface
{
    public function __get(string $key): object;
    public function __set(string $key, object $value): void;
    public function __isset(string $key): bool;
}
