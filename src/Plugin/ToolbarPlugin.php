<?php

namespace Spiffy\DebugPackage\Plugin;

use DebugBar\DebugBar;
use Spiffy\Event\Manager;
use Spiffy\Event\Plugin;
use Spiffy\Framework\Application;
use Spiffy\Framework\ApplicationEvent;

final class ToolbarPlugin implements Plugin
{
    /** @var \DebugBar\DebugBar */
    private $bar;

    /**
     * @param DebugBar $bar
     */
    public function __construct(DebugBar $bar)
    {
        $this->bar = $bar;
    }

    /**
     * @param Manager $events
     * @return void
     */
    public function plug(Manager $events)
    {
        $events->on(Application::EVENT_RESPOND, [$this, 'renderToolbar'], -15000);
    }

    /**
     * @param ApplicationEvent $e
     */
    public function renderToolbar(ApplicationEvent $e)
    {
        $renderer = $this->bar->getJavascriptRenderer();
        $renderer->setIncludeVendors(true);
        $renderer->setBaseUrl('//cdn.rawgit.com/maximebf/php-debugbar/master/src/DebugBar/Resources');

        $response = $e->getResponse();
        $content = $response->getContent();

        $content = preg_replace('/<\/head>/i', $renderer->renderHead() . "\n</head>", $content, 1);
        $content = preg_replace('/<\/body>/i', $renderer->render() . "\n</body>", $content, 1);

        $response->setContent($content);
    }
}
