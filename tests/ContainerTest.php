<?php

use PHPUnit\Framework\TestCase;

require 'Example.php';
class ContainerTest extends TestCase
{
    public function testBuildAndGet()
    {
        $container = IOC\IOC::createContainer();
        $container->build('Example');
        $this->assertInstanceof(Example::class, $container->Example);
    }

    public function testBind()
    {
        $container = IOC\IOC::createContainer();
        $container->bind('Example', function () {
            return new Example;
        });
        $this->assertInstanceof(Example::class, $container->Example);
    }

    public function testRegister()
    {
        $container = IOC\IOC::createContainer();
        $container->register('ExampleShortName', 'Example');
        $container->build('ExampleShortName');
        $this->assertInstanceof(Example::class, $container->ExampleShortName);
        // test in case of registering a new short name that exists
        $this->expectException(\Exception::class);
        $container->register('ExampleShortName', 'Example');
    }

    public function testGet()
    {
        $container = IOC\IOC::createContainer();
        $container->build('Example');
        $this->assertInstanceof(Example::class, $container->get('Example'));
        $this->assertInstanceof(Example::class, $container->Example);
    }
}
