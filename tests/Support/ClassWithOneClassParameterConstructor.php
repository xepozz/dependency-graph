<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Test\Support;

class ClassWithOneClassParameterConstructor
{
    public function __construct(ClassWithEmptyConstructor $name)
    {
    }
}