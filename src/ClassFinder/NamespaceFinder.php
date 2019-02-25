<?php
namespace IOC\ClassFinder;

class NamespaceFinder
{
    private $className;
    private $classesHolder;
    private $interfacesHolder;
    private $classNamespace;

    public function __construct(string $className, RegisteryHolder $classesHolder, RegisteryHolder $interfacesHolder)
    {
        $this->className        = $className;
        $this->classesHolder    = $classesHolder;
        $this->interfacesHolder = $interfacesHolder;
    }

    public function getRealClassName(): string
    {
        if (class_exists($this->className)) {
            return $this->className;
        }
        if ($this->inHolder(new ClassTypeFinder($this->classesHolder))) {
            return $this->classesHolder->{$this->className};
        }
        if ($this->inHolder(new InterfaceTypeFinder($this->interfacesHolder))) {
            return $this->interfacesHolder->{$this->className};
        }

        throw new \Exception("$this->className does can't be found", 1);
    }

    private function inHolder(FinderInterface $finder): boolean
    {
        return $finder->find($this->className);
    }
}
