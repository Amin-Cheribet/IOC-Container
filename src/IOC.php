<?php

namespace IOC;

class IOC
{
    /**
 	 * The IOC container
 	 *
 	 * @var Container
	 */
    private static $container;

    /**
 	 * This static method return an instance of IOC class (this class).
 	 *
     * @return Container
	 */
    public static function createContainer(): Container
    {
        return static::$container = new Container();
    }

    /**
 	 * Return an instance of the Container class
 	 *
 	 * @return Container
	 */
    public static function container(): Container
    {
        return static::$container;
    }
}
