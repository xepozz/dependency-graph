<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph\Node\Method;

use Xepozz\DependencyGraph\Node\ArrayableNodeInterface;

interface MethodNodeInterface extends ArrayableNodeInterface
{
    public function getName(): string;

    public function getParameters(): array;
}