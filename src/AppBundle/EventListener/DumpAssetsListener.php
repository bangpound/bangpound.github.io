<?php

namespace AppBundle\EventListener;

use Assetic\AssetManager;
use Assetic\AssetWriter;
use Assetic\Factory\LazyAssetManager;
use Sculpin\Core\Event\SourceSetEvent;
use Symfony\Bundle\AsseticBundle\Command\DumpCommand;

class DumpAssetsListener
{
    private $am;
    private $writer;

    public function __construct(LazyAssetManager $am, AssetWriter $writer)
    {
        $this->am = $am;
        $this->writer = $writer;
    }

    public function onAfterRun(SourceSetEvent $event)
    {
        $this->writer->writeManagerAssets($this->am);

        foreach ($this->am->getNames() as $name) {
            $formula = $this->am->hasFormula($name) ? $this->am->getFormula($name) : array();
            $debug = isset($formula[2]['debug']) ? $formula[2]['debug'] : $this->am->isDebug();
            $combine = isset($formula[2]['combine']) ? $formula[2]['combine'] : !$debug;
            if (!$combine) {
                foreach ($this->am->get($name) as $asset) {
                    $this->writer->writeAsset($asset);
                }
            }
        }
    }
}
