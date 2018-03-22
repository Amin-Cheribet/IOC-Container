<?php

namespace IOC;

class IOC
{
    private static $container;

    /**
 	 * This static method return an instance of IOC class (this class).
 	 *
	 */
    public static function createContainer(): void
    {
        static::$container = new Container();
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
