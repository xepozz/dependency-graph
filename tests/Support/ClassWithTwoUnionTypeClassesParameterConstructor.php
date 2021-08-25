<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Test\Support;

class ClassWithTwoUnionTypeClassesParameterConstructor
{
    public function __construct(ClassWithEmptyConstructor|ClassWithoutConstructor $name)
    {
    }
}