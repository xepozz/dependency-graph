<?php
declare(strict_types=1);
require_once 'vendor/autoload.php';


class Level1Class
{
}

class Level2Class extends Level1Class
{
}

class Level3Class extends Level2Class
{
}

/** @deprecated */
class Level4Class extends Level3Class
{
}

class L4Exception extends Level3Class
{
}

abstract class Level3Abstract extends Level2Class
{
}

class L4AExtendsAbstract extends Level3Abstract
{
}

/* false-positives: not all exceptions named with exception-suffix */

class Level2Exception extends Exception
{
    public function __construct(Exception $exception, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class Level3Exception extends Level2Exception
{
    public function __construct(Level2Exception $exception, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class Level4Exception extends Level3Exception
{
    public function __construct(Level3Exception $exception, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class ExceptionNamedAccordingToDDD extends Level4Exception
{
    public function __construct(Level4Exception $exception, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

$g = new \Xepozz\DependencyGraph\GraphDumper();

$iters = new AppendIterator();
$methods = ['__construct'];
$class=ExceptionNamedAccordingToDDD::class;
foreach (get_declared_classes() as $class) {
    $plan = new \Xepozz\DependencyGraph\DependencyGraphBuilder();
    $r = $plan->parse($class, $methods);
    $iters->append($r);
}

$c = $g->dump($iters);

$json_encode = json_encode($c, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
file_put_contents('debug.json', $json_encode);