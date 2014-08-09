<?php

namespace Spiffy\DebugPackage\Plugin;

use DebugBar\DataCollector\TimeDataCollector;
use Spiffy\Event\Manager;
use Spiffy\Event\Plugin;
use Spiffy\Framework\Application;

final class RespondPlugin implements Plugin
{
    /** @var TimeDataCollector */
    private $collector;
    
    public function __construct(TimeDataCollector $collector)
    {
        $this->collector = $collector;
    }
    
    /**
     * {@inheritDoc}
     */
    public function plug(Manager $events)
    {
        $events->on(Application::EVENT_RESPOND, [$this, 'respondStart'], 10000);
        $events->on(Application::EVENT_RESPOND, [$this, 'respondStop'], -10000);
        
        $events->on(Application::EVENT_ROUTE, [$this, 'routeStart'], 10000);
        $events->on(Application::EVENT_ROUTE, [$this, 'routeStop'], -10000);
        
        $events->on(Application::EVENT_DISPATCH, [$this, 'dispatchStart'], 10000);
        $events->on(Application::EVENT_DISPATCH, [$this, 'dispatchStop'], -10000);
        
        $events->on(Application::EVENT_RENDER, [$this, 'renderStart'], 10000);
        $events->on(Application::EVENT_RENDER, [$this, 'renderStop'], -10000);

        $events->on(Application::EVENT_ROUTE, [$this, 'addBootstrapTime'], 10001);
    }
    
    public function respondStart()
    {
        $this->collector->startMeasure('framework.respond');
    }

    public function respondStop()
    {
        $this->collector->stopMeasure('framework.respond');
    }

    public function routeStart()
    {
        $this->collector->startMeasure('framework.route');
    }

    public function routeStop()
    {
        $this->collector->stopMeasure('framework.route');
    }

    public function dispatchStart()
    {
        $this->collector->startMeasure('framework.dispatch');
    }

    public function dispatchStop()
    {
        $this->collector->stopMeasure('framework.dispatch');
    }

    public function renderStart()
    {
        $this->collector->startMeasure('framework.render');
    }

    public function renderStop()
    {
        $this->collector->stopMeasure('framework.render');
    }

    public function addBootstrapTime()
    {
        if (!isset($_SESSION[BootstrapPlugin::BOOTSTRAP_START]) || !isset($_SESSION[BootstrapPlugin::BOOTSTRAP_END])) {
            return;
        }

        $this->collector->addMeasure(
            'framework.bootstrap',
            $_SESSION[BootstrapPlugin::BOOTSTRAP_START],
            $_SESSION[BootstrapPlugin::BOOTSTRAP_END]
        );
    }
}
