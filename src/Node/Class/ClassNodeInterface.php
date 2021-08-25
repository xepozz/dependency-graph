<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Node\Class;

use Xepozz\DependencyGraph\Node\ArrayableNodeInterface;

interface ClassNodeInterface extends ArrayableNodeInterface
{
    public function getName(): string;

    public function getMethods(): \Traversable;
}