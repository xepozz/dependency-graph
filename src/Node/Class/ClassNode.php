<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Node\Class;

class ClassNode implements ClassNodeInterface
{
    private string $name;
    private \Traversable $methods;
    private \Traversable $interfaces;

    public function __construct(
        string       $name,
        \Traversable $methods,
        \Traversable $interfaces,
    )
    {
        $this->name = $name;
        $this->methods = $methods;
        $this->interfaces = $interfaces;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMethods(): \Traversable
    {
        return $this->methods;
    }

    public function asArray(): array
    {
        return [
            'name' => $this->name,
            'methods' => array_map(
                static fn(\Generator $generator) => iterator_to_array($generator),
                iterator_to_array($this->methods)
            ),
            'implements' => iterator_to_array($this->interfaces)
        ];
    }

}