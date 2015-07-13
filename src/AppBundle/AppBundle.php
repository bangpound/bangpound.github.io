<?php

namespace AppBundle;

use Symfony\Bundle\AsseticBundle\DependencyInjection\DirectoryResourceDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ClosureCompilerPass(function (ContainerBuilder $container) {
            $container->getDefinition('file_locator')->addArgument(['/Users/bjd/workspace/bangpound.github.io/source']);
        }));

//        $container->getDefinition('twig.loader.filesystem')->addMethodCall('addPath', array(dirname('/Users/bjd/workspace/bangpound.github.io/source')));
//        $container->setDefinition(
//          'assetic.twig_directory_resource.sculpin',
//          new DirectoryResourceDefinition('', 'twig', array('/Users/bjd/workspace/bangpound.github.io/source'))
//        );
    }
}
