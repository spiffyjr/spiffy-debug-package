<?php

namespace Spiffy\DebugPackage;

use Spiffy\Event\Manager;
use Spiffy\Event\Plugin;
use Spiffy\Framework\Application;
use Spiffy\Framework\ApplicationEvent;

class TestPlugin implements Plugin
{
    /**
     * {@inheritDoc}
     */
    public function plug(Manager $events)
    {
        $events->on(Application::EVENT_RESPOND, function (ApplicationEvent $e) {
            $response = $e->getResponse();
            $content = $response->getContent();
            $content = preg_replace('/<\/body>/i', 'before end of body'. "\n</body>", $content, 1);

            $response->setContent($content);
        }, -10000);
    }
}
