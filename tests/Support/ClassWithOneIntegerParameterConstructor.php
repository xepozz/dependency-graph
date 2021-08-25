<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Test\Support;

class ClassWithOneIntegerParameterConstructor
{
    public function __construct(int $name)
    {
    }
}