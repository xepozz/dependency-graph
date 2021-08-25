<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph;

use Xepozz\DependencyGraph\Node\ArrayableNodeInterface;
use Xepozz\DependencyGraph\Node\Class\ClassNodeInterface;
use Xepozz\DependencyGraph\Node\Parameter\ParameterNodeInterface;

class GraphDumper
{
    public function dump(ArrayableNodeInterface|iterable $node): array
    {
        if ($node instanceof ArrayableNodeInterface) {
            return $this->dump($node->asArray());
        }
        $result = [];
        foreach ($node as $k => $v) {
            if ($v instanceof ArrayableNodeInterface) {
                $v = $this->dump($v->asArray());
            }
            if (is_iterable($v)) {
                $v = $this->dump($v);
            }
            $result[$k] = $v;
        }
        return $result;
    }
}