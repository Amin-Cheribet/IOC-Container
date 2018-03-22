<?php

use PHPUnit\Framework\TestCase;

class IOCTest extends TestCase
{
    public function testCreateContainer()
    {
        $ioc = IOC\IOC::createContainer();
        $this->assertInstanceof(IOC\Container::class, $ioc);
    }

    public function testGetContainerInstance()
    {
        $container = IOC\IOC::container();
        $this->assertInstanceof(IOC\Container::class, $container);
    }
}
