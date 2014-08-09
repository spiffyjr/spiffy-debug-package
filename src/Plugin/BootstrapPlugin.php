<?php

namespace Spiffy\DebugPackage\Plugin;

use DebugBar\StandardDebugBar;
use Spiffy\Event\Manager;
use Spiffy\Event\Plugin;
use Spiffy\Framework\Application;
use Spiffy\Framework\ApplicationEvent;

/*
 * Bootstrapping is done before any other services are available. In order for DebugBar to display
 * this information we have to temporarily store the data (session). The CollectTimePlugin will
 * add this and other event data to the time collector automatically.
 */
final class BootstrapPlugin implements Plugin
{
    const BOOTSTRAP_START = 'FRAMEWORK_BOOTSTRAP_START';
    const BOOTSTRAP_END = 'FRAMEWORK_BOOTSTRAP_END';

    /**
     * {@inheritDoc}
     */
    public function plug(Manager $events)
    {
        $events->on(Application::EVENT_BOOTSTRAP, [$this, 'bootstrapStart'], 10000);
        $events->on(Application::EVENT_BOOTSTRAP, [$this, 'bootstrapStop'], -10000);
    }
    
    public function bootstrapStart()
    {
        $_SESSION[self::BOOTSTRAP_START] = microtime(true);
    }

    public function bootstrapStop()
    {
        $_SESSION[self::BOOTSTRAP_END] = microtime(true);
    }
}
