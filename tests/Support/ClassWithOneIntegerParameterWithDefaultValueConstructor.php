<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Test\Support;

class ClassWithOneIntegerParameterWithDefaultValueConstructor
{
    public function __construct(int $name = 12345)
    {
    }
}