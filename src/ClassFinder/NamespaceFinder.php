<?php

namespace IOC\ClassFinder;

use IOC\Holders\RegisteryHolder as RegisteryHolder;

class NamespaceFinder implements NamespaceFinderInterface
{
    private string $className;
    private RegisteryHolder $classesHolder;
    private RegisteryHolder $typesHolder;

    public function __construct(string $className, RegisteryHolder $classesHolder, RegisteryHolder $typesHolder)
    {
        $this->className = $className;
        $this->classesHolder = $classesHolder;
        $this->typesHolder = $typesHolder;
    }

    public function getRealClassName(): string
    {
        if (class_exists($this->className)) {
            return $this->className;
        }
        if ($this->inHolder(new ClassFinder($this->classesHolder))) {
            return $this->classesHolder->{$this->className};
        }
        if ($this->inHolder(new TypeFinder($this->typesHolder))) {
            return $this->typesHolder->{$this->className};
        }

        throw new \Exception("$this->className can't be found", 1);
    }

    private function inHolder(FinderInterface $finder): bool
    {
        return $finder->find($this->className);
    }
}
