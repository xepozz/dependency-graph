<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Node;

interface ArrayableNodeInterface
{
    public function asArray(): array;
}