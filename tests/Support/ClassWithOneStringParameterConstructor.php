<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Test\Support;

class ClassWithOneStringParameterConstructor
{
    public function __construct(string $name)
    {
    }
}