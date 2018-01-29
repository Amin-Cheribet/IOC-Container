<?php

namespace DI\Resolvers;

interface ClassNameResolverInterface
{
    public function getRealClassName(): string;
}
