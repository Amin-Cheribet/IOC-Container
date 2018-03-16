<?php

namespace IOC\Resolvers;

class ClassNameResolver implements ClassNameResolverInterface
{
    /**
 	 * Class name
 	 *
     * @var string
	 */
    private $className;

    public function __construct(array $aliases, string $className)
    {
        $this->className = $className;
        $this->aliases   = $aliases;
    }

    /**
 	 * Get Class name from it's full namespace.
 	 *
 	 * @return string
	 */
    public function getRealClassName(): string
    {
        $classFullName = $this->resolveClassNameFromAliases($this->className);

        if (!class_exists($classFullName)) {
            throw new \Exception("$classFullName Resolved from $this->className is not found", 1);
        }

        return $classFullName;
    }

    /**
 	 * Resolve class full namespace from aliases.
 	 *
 	 * @param string $className
     *
 	 * @return string
	 */
    private function resolveClassNameFromAliases(string $className): string
    {
        $className = $this->aliases[$className] ?? $className;

        if (class_exists($className)) {
            return $className;
        }

        return $this->resolveInterface(new InterfaceResolver($className));
    }

    /**
 	 * Resolve class name from interface name.
 	 *
 	 * @param InterfaceResolverInterface $interfaceResolver
     *
 	 * @return string
	 */
    private function resolveInterface(InterfaceResolverInterface $interfaceResolver): string
    {
        $className = $interfaceResolver->resolveInterfaceClass($this->className);
        return $this->aliases[$className] ?? $className;
    }
}
