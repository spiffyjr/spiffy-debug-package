<?php

namespace Spiffy\DebugPackage\Plugin;

use DebugBar\StandardDebugBar;
use Spiffy\Event\Manager;
use Spiffy\Event\Plugin;
use Spiffy\Framework\Application;
use Spiffy\Framework\ApplicationEvent;

final class RespondPlugin implements Plugin
{
    /** @var StandardDebugBar */
    private $bar;
    
    /**
     * {@inheritDoc}
     */
    public function plug(Manager $events)
    {
        $events->on(Application::EVENT_BOOTSTRAP, [$this, 'initialize'], 15000);
        
        $events->on(Application::EVENT_BOOTSTRAP, [$this, 'bootstrapStart'], 10000);
        $events->on(Application::EVENT_BOOTSTRAP, [$this, 'bootstrapStop'], -10000);

        $events->on(Application::EVENT_RESPOND, [$this, 'respondStart'], 10000);
        $events->on(Application::EVENT_RESPOND, [$this, 'respondStop'], -10000);
        
        $events->on(Application::EVENT_ROUTE, [$this, 'routeStart'], 10000);
        $events->on(Application::EVENT_ROUTE, [$this, 'routeStop'], -10000);
        
        $events->on(Application::EVENT_DISPATCH, [$this, 'dispatchStart'], 10000);
        $events->on(Application::EVENT_DISPATCH, [$this, 'dispatchStop'], -10000);
        
        $events->on(Application::EVENT_RENDER, [$this, 'renderStart'], 10000);
        $events->on(Application::EVENT_RENDER, [$this, 'renderStop'], -10000);
        
        $events->on(Application::EVENT_RESPOND, [$this, 'renderToolbar'], -15000);
    }
    
    public function initialize(ApplicationEvent $e)
    {
        $this->bar = new StandardDebugBar();
    }

    public function bootstrapStart(ApplicationEvent $e)
    {
        $this->bar['time']->startMeasure('bootstrap');
    }

    public function bootstrapStop(ApplicationEvent $e)
    {
        $this->bar['time']->stopMeasure('bootstrap');
    }

    public function respondStart(ApplicationEvent $e)
    {
        $this->bar['time']->startMeasure('respond');
    }

    public function respondStop(ApplicationEvent $e)
    {
        $this->bar['time']->stopMeasure('respond');
    }

    public function routeStart(ApplicationEvent $e)
    {
        $this->bar['time']->startMeasure('route');
    }

    public function routeStop(ApplicationEvent $e)
    {
        $this->bar['time']->stopMeasure('route');
    }

    public function dispatchStart(ApplicationEvent $e)
    {
        $this->bar['time']->startMeasure('dispatch');
    }

    public function dispatchStop(ApplicationEvent $e)
    {
        $this->bar['time']->stopMeasure('dispatch');
    }
    
    public function renderStart(ApplicationEvent $e)
    {
        $this->bar['time']->startMeasure('render');
    }

    public function renderStop(ApplicationEvent $e)
    {
        $this->bar['time']->stopMeasure('render');
    }
    
    public function renderToolbar(ApplicationEvent $e)
    {
        $renderer = $this->bar->getJavascriptRenderer();
        $renderer->setIncludeVendors(false);

        $this->bar->addCollector(new \DebugBar\Bridge\DoctrineCollector($e->getApplication()->getInjector()->nvoke('doctrine-orm.main.logger')));

        $response = $e->getResponse();
        $content = $response->getContent();

        list($cssCollection, $jsCollection) = $renderer->getAsseticCollection();
        
        $css = sprintf('<style type="text/css">%s</style>', $cssCollection->dump());
        $js = sprintf('<script type="text/javascript">%s</script>', $jsCollection->dump());
        
        $content = preg_replace('/<\/head>/i', $css . $js . "\n</head>", $content, 1);
        $content = preg_replace('/<\/body>/i', $renderer->render() . "\n</body>", $content, 1);
        
        $response->setContent($content);
    }
}
