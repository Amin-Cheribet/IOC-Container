<?php
namespace IOC\ClassFinder;

interface FinderInterface
{
    public function find(string $className): boolean;
}
