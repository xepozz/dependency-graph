<?php
declare(strict_types=1);

namespace Xepozz\DependencyGraph;

use Xepozz\DependencyGraph\Node\Class\ClassNode;
use Xepozz\DependencyGraph\Node\Parameter\ParameterNode;

class DependencyGraphBuilder
{
    private array $reflections = [];
    private array $additionalClasses = [];
    private array $built = [];

    public function parse(string $class, array $onlyMethods = []): array|\Generator
    {
        if (array_key_exists($class, $this->built)) {
            return;
        }

        $reflection = $this->reflections[$class] ??= new \ReflectionClass($class);

        yield from $this->parseClass($reflection, $onlyMethods);
        $this->built[$class] = true;

        foreach ($this->additionalClasses as $additionalClass => $v) {
            unset($this->additionalClasses[$additionalClass]);
            yield from $this->parse($additionalClass, $onlyMethods);
            $this->built[$additionalClass] = true;
        }
    }

    /**
     * @param \ReflectionMethod[] $refs
     * @return \Generator
     */
    private function collectMethods(array $refs): \Generator
    {
        foreach ($refs as $ref) {
            yield from [$ref->getName() => $this->parseParameters($ref)];
        }
    }

    private function parseParameters(\ReflectionMethod $constructor): \Generator
    {
        foreach ($constructor->getParameters() as $parameter) {
            $name = $parameter->getName();
            $types = [];
            $allowsNull = false;
            $isBuiltin = false;
            $isVariadic = $parameter->isVariadic();
            $hasDefaultValue = $parameter->isDefaultValueAvailable();
            $defaultValue = $parameter->isDefaultValueAvailable()
                ? $parameter->getDefaultValue()
                : null;

            if ($parameter->getType() instanceof \ReflectionUnionType) {
                $types = array_map(
                    static fn(\ReflectionNamedType $p) => $p->getName(),
                    $parameter->getType()->getTypes()
                );
            } elseif ($parameter->getType() !== null) {
                $types = [$parameter->getType()->getName()];
                $allowsNull = $parameter->getType()->allowsNull();
                $isBuiltin = $parameter->getType()->isBuiltin();
            }

            $additionalClasses = array_map(
                static fn() => true,
                array_flip(
                    array_filter(
                        $types,
                        static fn(string $type) => class_exists($type)
                    )
                )
            );

            yield $name => new ParameterNode(
                $name,
                $types,
                $allowsNull,
                $isBuiltin,
                $isVariadic,
                $hasDefaultValue,
                $defaultValue,
            );
            if ($additionalClasses !== []) {
                $this->additionalClasses = array_merge($this->additionalClasses, $additionalClasses);
            }
        }
    }

    private function parseClass(\ReflectionClass $reflection, array $onlyMethods): \Generator
    {
        $className = $reflection->getName();
        $methods = $reflection->getMethods();
        if ($onlyMethods !== []) {
            $methods = array_filter(
                $methods,
                static fn(\ReflectionMethod $ref) => in_array($ref->getName(), $onlyMethods, true)
            );
        }
        $methods = $methods === []
            ? new \ArrayObject([])
            : $this->collectMethods($methods);
        $implements = $this->collectImplements($reflection->getInterfaces());

        yield $className => new ClassNode(
            $className,
            $methods,
            $implements,
        );
    }

    /**
     * @param \ReflectionClass[] $interfaces
     */
    private function collectImplements(array $interfaces): \Generator
    {
        foreach ($interfaces as $interface) {
            yield $interface->getName();
        }
    }
}