<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Node\Parameter;

class LazyParameterNode implements ParameterNodeInterface
{
    private \Closure $name;
    private \Closure $type;
    private \Closure $nullable;
    private \Closure $isBuiltin;

    public function __construct(
        \Closure $name,
        \Closure $type,
        \Closure $nullable,
        \Closure $isBuiltin,
    )
    {
        $this->name = $name;
        $this->type = $type;
        $this->nullable = $nullable;
        $this->isBuiltin = $isBuiltin;
    }

    public function getName(): string
    {
        return ($this->name)();
    }

    public function getTypes(): array
    {
        return ($this->type)();
    }

    public function isNullable(): bool
    {
        return ($this->nullable)();
    }

    public function isBuiltin(): bool
    {
        return ($this->isBuiltin)();
    }

    public function asArray(): array
    {
        return [
            'name' => ($this->name)(),
            'type' => ($this->type)(),
            'nullable' => ($this->nullable)(),
            'isBuiltin' => ($this->isBuiltin)(),
        ];
    }
}