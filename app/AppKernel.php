<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
          new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
          new Symfony\Bundle\SecurityBundle\SecurityBundle(),
          new Symfony\Bundle\TwigBundle\TwigBundle(),
          new Symfony\Bundle\MonologBundle\MonologBundle(),
          new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
          new Symfony\Bundle\AsseticBundle\AsseticBundle(),
          new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
          new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
          new AppBundle\AppBundle(),

          new \Sculpin\Bundle\MarkdownBundle\SculpinMarkdownBundle,
          new \Sculpin\Bundle\MarkdownTwigCompatBundle\SculpinMarkdownTwigCompatBundle,
          new \Sculpin\Bundle\PaginationBundle\SculpinPaginationBundle,
          new \Sculpin\Bundle\SculpinBundle\SculpinBundle,
          new \Sculpin\Bundle\ThemeBundle\SculpinThemeBundle,
          new \Sculpin\Bundle\TwigBundle\SculpinTwigBundle,
          new \Sculpin\Bundle\ContentTypesBundle\SculpinContentTypesBundle,
          new Bangpound\Sculpin\Bundle\OEmbedBundle\SculpinOEmbedBundle(),
          new \CoreSphere\ConsoleBundle\CoreSphereConsoleBundle(),
          new Bangpound\Bundle\ConsoleBundle\BangpoundConsoleBundle($this),
          new Bcremer\Sculpin\Bundle\CommonMarkBundle\SculpinCommonMarkBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }

    protected function getKernelParameters()
    {
        return array_merge(parent::getKernelParameters(), array(
          'sculpin.project_dir' => dirname($this->rootDir),
        ));
    }
}
