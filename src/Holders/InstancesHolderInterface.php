<?php
namespace IOC\Holders;

interface InstancesHolderInterface
{
    public function __get(string $key);
    public function __set(string $key, $value): void;
    public function __isset(string $key): bool;
}
