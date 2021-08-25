<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Node\Parameter;

use Xepozz\DependencyGraph\Node\ArrayableNodeInterface;

interface ParameterNodeInterface extends ArrayableNodeInterface
{
    public function getName(): string;

    public function getTypes(): array;

    public function isNullable(): bool;

    public function isBuiltin(): bool;
}