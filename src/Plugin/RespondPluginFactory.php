<?php

namespace Spiffy\DebugPackage\Plugin;

use Spiffy\Inject\Injector;
use Spiffy\Inject\ServiceFactory;

class RespondPluginFactory implements ServiceFactory
{
    /**
     * @param Injector $i
     * @return RespondPlugin
     */
    public function createService(Injector $i)
    {
        /** @var \DebugBar\DebugBar $bar */
        $bar = $i->nvoke('debug.bar');

        return new RespondPlugin($bar->getCollector('time'));
    }
}