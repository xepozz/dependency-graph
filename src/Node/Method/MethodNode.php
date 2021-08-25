<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Node\Method;

class MethodNode implements MethodNodeInterface
{
    private string $name;
    private \Generator $parameters;

    public function __construct(
        string     $name,
        \Generator $parameters
    )
    {
        $this->name = $name;
        $this->parameters = $parameters;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParameters(): array
    {
        return iterator_to_array($this->parameters);
    }

    public function asArray(): array
    {
        return [
            'name' => $this->name,
            'parameters' => array_map(
                fn(\Generator $generator) => iterator_to_array($generator),
                iterator_to_array($this->parameters)
            ),
        ];
    }
}