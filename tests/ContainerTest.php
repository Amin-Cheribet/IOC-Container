<?php

use PHPUnit\Framework\TestCase;

require 'Example.php';
require 'Example2.php';
require 'Example3.php';

class ContainerTest extends TestCase
{
    public function testBuildSimple()
    {
        $container = IOC\IOC::createContainer();
        $container->build('Example2');
        $this->assertInstanceof(Example2::class, $container->Example2);
    }

    public function testBuildWithDependency()
    {
        $container = IOC\IOC::createContainer();
        $container->build('Example');
        $this->assertInstanceof(Example::class, $container->Example);
    }

    public function testBind()
    {
        $container = IOC\IOC::createContainer();
        $container->bind('Example', function () {
            return new Example(new Example2, new Example3);
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
