<?php

namespace IOC\Resolvers;

interface ClassNameResolverInterface
{
    public function getRealClassName(): string;
}
