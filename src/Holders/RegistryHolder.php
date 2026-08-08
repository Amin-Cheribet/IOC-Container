<?php

namespace IOC\Holders;

interface RegistryHolder
{
    public function __get(string $key): string;
    public function __set(string $key, string $value): void;
    public function __isset(string $key): bool;
}
