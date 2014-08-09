<?php

namespace Spiffy\DebugPackage;

use DebugBar\DebugBar;
use Spiffy\Inject\Injector;
use Spiffy\Inject\InjectorUtils;
use Spiffy\Inject\ServiceFactory;

class DebugBarFactory implements ServiceFactory
{
    /**
     * @param Injector $i
     * @return mixed
     */
    public function createService(Injector $i)
    {
        $bar = new DebugBar();
        $config = $i['debug'];

        foreach ($config['collectors'] as $collector) {
            $bar->addCollector(InjectorUtils::get($i, $collector));
        }

        return $bar;
    }
}
