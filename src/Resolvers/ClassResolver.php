<?php

namespace IOC\Resolvers;

class ClassResolver implements ClassResolverInterface
{
    /**
 	 * Class reflection of the resolved class
 	 *
 	 * @var ReflectionClass
	 */
    private $reflector;

    public function __construct(\ReflectionClass $reflector)
    {
        $this->reflector = $reflector;
    }

    /**
 	 * Get constructor arguments types to create instances from them.
 	 *
 	 * @return array
	 */
    public function getConstructorArguments(): array
    {
        $parameters = [];
        if (!$this->reflector->hasMethod('__construct')) {
            return [];
        }
        $data = $this->reflector->getConstructor()->getParameters();
        foreach ($data as $argumentIndex => $arguments) {
            $parameters[] = $arguments->getClass();
        }

        return $parameters;
    }

    /**
 	 * Get class full name with namespace.
 	 *
 	 * @return string
	 */
    public function getClassName(): string
    {
        return $this->reflector->getName();
    }

    /**
 	 * Get class name without namespace.
 	 *
 	 * @return string
	 */
    public function getClassShortName(): string
    {
        return $this->reflector->getShortName();
    }

    /**
 	 * Check if class exists
     * Returns false if class don't exist true if exist
 	 *
 	 * @param string $class
 	 * @return bool
	 */
    public function classExists(string $class): bool
    {
        return class_exists($class) ? true : false;
    }

    /**
 	 * Create instance of the current reflector
     * Arguments passed to the instance are optionall
 	 *
 	 * @param array $parameters
 	 * @return object
	 */
    public function createClassInstance(array $arguments = null)
    {
        return $this->reflector->newInstanceArgs($arguments);
    }
}
