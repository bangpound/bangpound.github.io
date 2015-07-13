<?php

namespace AppBundle;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ClosureCompilerPass implements CompilerPassInterface
{
    private $pass;

    public function __construct($pass)
    {
        $this->pass = $pass;
    }

    public function process(ContainerBuilder $container)
    {
        call_user_func($this->pass, $container);
    }
}
