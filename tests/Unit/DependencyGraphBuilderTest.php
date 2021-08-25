<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Test\Unit;

use PHPUnit\Framework\TestCase;
use Xepozz\DependencyGraph\GraphDumper;
use Xepozz\DependencyGraph\Node\Class\ClassNodeInterface;
use Xepozz\DependencyGraph\Node\Parameter\ParameterNode;
use Xepozz\DependencyGraph\Node\Parameter\ParameterNodeInterface;
use Xepozz\DependencyGraph\Node\Parameter\LazyParameterNode;
use Xepozz\DependencyGraph\DependencyGraphBuilder;
use Xepozz\DependencyGraph\Test\Support\ClassWithEmptyConstructor;
use Xepozz\DependencyGraph\Test\Support\ClassWithOneClassParameterConstructor;
use Xepozz\DependencyGraph\Test\Support\ClassWithOneIntegerParameterConstructor;
use Xepozz\DependencyGraph\Test\Support\ClassWithOneIntegerParameterWithDefaultValueConstructor;
use Xepozz\DependencyGraph\Test\Support\ClassWithOneIntegerVariadicParameterConstructor;
use Xepozz\DependencyGraph\Test\Support\ClassWithOneStringParameterConstructor;
use Xepozz\DependencyGraph\Test\Support\ClassWithoutConstructor;
use Xepozz\DependencyGraph\Test\Support\ClassWithTwoUnionTypeClassesParameterConstructor;

class DependencyGraphBuilderTest extends TestCase
{
    /**
     * @dataProvider classProvider
     */
    public function testMain(string $class, array $expectedResult): void
    {
        $builder = new DependencyGraphBuilder();
        $actualResult = $builder->parse($class);

//        print_r(
//            [
//                $this->iterToArray($expectedResult),
//                $this->iterToArray($actualResult),
//            ],
//        );
        $expected = $this->iterToArray($expectedResult);
        $actual = $this->iterToArray($actualResult);

        file_put_contents('out.json', json_encode($actual, JSON_PRETTY_PRINT));

        $this->assertEquals(
            $expected,
            $actual
        );

    }

    public function classProvider(): array
    {
        return [
            [
                ClassWithoutConstructor::class,
                [
                    ClassWithoutConstructor::class => [
                        'name' => ClassWithoutConstructor::class,
                        'methods' => [],
                        'implements' => [],
                    ],
                ],
            ],
            [
                ClassWithEmptyConstructor::class,
                [
                    ClassWithEmptyConstructor::class => [
                        'name' => ClassWithEmptyConstructor::class,
                        'methods' => [],
                        'implements' => [],
                    ],
                ],
            ],
            [
                ClassWithOneIntegerParameterConstructor::class,
                [
                    ClassWithOneIntegerParameterConstructor::class => [
                        'name' => ClassWithOneIntegerParameterConstructor::class,
                        'methods' => [
                            '__construct' => [
                                'name' => new ParameterNode(
                                    'name',
                                    ['int'],
                                    false,
                                    true,
                                    false,
                                    false,
                                    null
                                ),
                            ],
                        ],
                        'implements' => [],
                    ],
                ],
            ],
            [
                ClassWithOneIntegerParameterConstructor::class,
                [
                    ClassWithOneIntegerParameterConstructor::class => [
                        'name' => ClassWithOneIntegerParameterConstructor::class,
                        'methods' => [
                            '__construct' => [
                                'name' => new ParameterNode(
                                    'name',
                                    ['int'],
                                    false,
                                    true,
                                    false,
                                    false,
                                    null
                                ),
                            ],
                        ],
                        'implements' => [],
                    ],
                ],
            ],
            [
                ClassWithOneIntegerParameterWithDefaultValueConstructor::class,
                [
                    ClassWithOneIntegerParameterWithDefaultValueConstructor::class => [
                        'name' => ClassWithOneIntegerParameterWithDefaultValueConstructor::class,
                        'methods' => [
                            '__construct' => [
                                'name' => new ParameterNode(
                                    'name',
                                    ['int'],
                                    false,
                                    true,
                                    false,
                                    true,
                                    12345
                                ),
                            ],
                        ],
                        'implements' => [],
                    ],
                ],
            ],
            [
                ClassWithOneIntegerVariadicParameterConstructor::class,
                [
                    ClassWithOneIntegerVariadicParameterConstructor::class => [
                        'name' => ClassWithOneIntegerVariadicParameterConstructor::class,
                        'methods' => [
                            '__construct' => [
                                'name' => new ParameterNode(
                                    'name',
                                    ['int'],
                                    false,
                                    true,
                                    true,
                                    false,
                                    null
                                ),
                            ],
                        ],
                        'implements' => [],
                    ],
                ],
            ],
            [
                ClassWithOneStringParameterConstructor::class,
                [
                    ClassWithOneStringParameterConstructor::class => [
                        'name' => ClassWithOneStringParameterConstructor::class,
                        'methods' => [
                            '__construct' => [
                                'name' => new ParameterNode(
                                    'name',
                                    ['string'],
                                    false,
                                    true,
                                    false,
                                    false,
                                    null
                                ),
                            ],
                        ],
                        'implements' => [],
                    ],
                ],
            ],
            [
                ClassWithOneClassParameterConstructor::class,
                [
                    ClassWithOneClassParameterConstructor::class => [
                        'name' => ClassWithOneClassParameterConstructor::class,
                        'methods' => [
                            '__construct' => [
                                'name' => [
                                    'name' => 'name',
                                    'types' => [ClassWithEmptyConstructor::class],
                                    'isBuiltin' => false,
                                    'isVariadic' => false,
                                    'nullable' => false,
                                    'hasDefaultValue' => false,
                                    'defaultValue' => null,
                                ],
                            ],
                        ],
                        'implements' => [],
                    ],
                    ClassWithEmptyConstructor::class => [
                        'name' => ClassWithEmptyConstructor::class,
                        'methods' => [],
                        'implements' => [],
                    ],
                ],
            ],
            [
                ClassWithTwoUnionTypeClassesParameterConstructor::class,
                [
                    ClassWithTwoUnionTypeClassesParameterConstructor::class => [
                        'name' => ClassWithTwoUnionTypeClassesParameterConstructor::class,
                        'methods' => [
                            '__construct' => [
                                'name' => [
                                    'name' => 'name',
                                    'types' => [
                                        ClassWithEmptyConstructor::class,
                                        ClassWithoutConstructor::class,
                                    ],
                                    'isBuiltin' => false,
                                    'isVariadic' => false,
                                    'nullable' => false,
                                    'hasDefaultValue' => false,
                                    'defaultValue' => null,
                                ],
                            ],
                        ],
                        'implements' => [],
                    ],
                    ClassWithEmptyConstructor::class => [
                        'name' => ClassWithEmptyConstructor::class,
                        'methods' => [],
                        'implements' => [],
                    ],
                    ClassWithoutConstructor::class => [
                        'name' => ClassWithoutConstructor::class,
                        'methods' => [],
                        'implements' => [],
                    ],
                ],
            ],
        ];
    }

    private function iterToArray($actualResult): array
    {
        $g = new GraphDumper();
        return $g->dump($actualResult);
    }
}