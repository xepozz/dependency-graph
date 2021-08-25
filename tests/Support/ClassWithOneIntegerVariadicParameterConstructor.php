<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Test\Support;

class ClassWithOneIntegerVariadicParameterConstructor
{
    public function __construct(int ...$name)
    {
    }
}