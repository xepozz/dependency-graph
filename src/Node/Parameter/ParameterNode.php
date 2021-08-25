<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Node\Parameter;

class ParameterNode implements ParameterNodeInterface
{
    private string $name;
    private array $types;
    private bool $nullable;
    private bool $isBuiltin;
    private bool $isVariadic;
    private bool $hasDefaultValue;
    private $defaultValue;


    public function __construct(
        string $name,
        array  $types,
        bool   $nullable,
        bool   $isBuiltin,
        bool   $isVariadic,
        bool   $hasDefaultValue,
               $defaultValue,
    )
    {
        $this->name = $name;
        $this->types = $types;
        $this->nullable = $nullable;
        $this->isBuiltin = $isBuiltin;
        $this->isVariadic = $isVariadic;
        $this->hasDefaultValue = $hasDefaultValue;
        $this->defaultValue = $defaultValue;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }

    public function isBuiltin(): bool
    {
        return $this->isBuiltin;
    }

    public function asArray(): array
    {
        return [
            'name' => $this->name,
            'types' => array_values($this->types),
            'nullable' => $this->nullable,
            'isBuiltin' => $this->isBuiltin,
            'isVariadic' => $this->isVariadic,
            'hasDefaultValue' => $this->hasDefaultValue,
            'defaultValue' => $this->defaultValue,
        ];
    }

}