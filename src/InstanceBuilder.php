<?php

namespace IOC;

use IOC\Resolvers\ClassNameResolver;
use IOC\Resolvers\ClassResolver;

class InstanceBuilder
{
    public $classResolver;
    public $className;
    public $arguments;

    public function __construct(array $aliases, string $className, array $arguments = [])
    {
        $this->className = $this->resolveClassRealName(new ClassNameResolver($aliases, $className));
        $this->arguments = $arguments;
        $this->setClassResolver(new ClassResolver(new \ReflectionClass($this->className)));
    }

    /**
 	 * Create an instance from given class name
     * And create instances from it's arguments
     * if it's arguments are valide classes
 	 *
 	 * @return object
	 */
    public function build()
    {
        if (!empty($this->arguments)) {
            return $this->createInstance($this->arguments);
        }
        $parameters = $this->classResolver->getConstructorArguments();

        return empty($parameters) ? $this->createInstance() : $this->resolveDependencies($parameters);
    }

    /**
 	 * Resolve class real name from full namespace.
 	 *
 	 * @param ClassNameResolver
     *
 	 * @return string
	 */
    private function resolveClassRealName(ClassNameResolver $classNameResolver): string
    {
        return $classNameResolver->getRealClassName();
    }

    /**
 	 * Create arguments instances
 	 *
 	 * @param array $parameters
	 */
    private function resolveDependencies(array $parameters): object
    {
        foreach ($parameters as $value => $key) {
            $dependencies[] = $this->build($key->name);
        }

        return $this->createInstance($dependencies);
    }

    /**
 	 * Create instance
 	 *
 	 * @param type
 	 * @return object
	 */
    private function createInstance(array $arguments = [])
    {
        return $this->classResolver->createClassInstance($arguments);
    }

    /**
 	 * Set ClassResolver to $this->classResolver.
 	 *
 	 * @param ClassResolver $resolver
	 */
    private function setClassResolver(ClassResolver $resolver): void
    {
        $this->classResolver = $resolver;
    }
}
