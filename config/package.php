<?php

return [
    'debug' => [
        'enabled' => isset($_ENV['debug']) ? $_ENV['debug'] : false,

        /*
         * Whether to include vendor assets. Can be true, false, or an array
         * of types to include.
         *
         * e.g., ['css'], ['js'], ['css', 'js'] (same as true).
         */
        'include_vendors' => true,

        /*
         * Base url to load assets from if include_vendors is true. By default this uses
         * the rawgit CDN. If you use something like Assetic you can set this yourself.
         */
        'base_url' => '//cdn.rawgit.com/maximebf/php-debugbar/master/src/DebugBar/Resources',

        /*
         * Definition of collectors to add to the bar.
         */
        'collectors' => [
            'exceptions' => 'DebugBar\DataCollector\ExceptionsCollector',
            'memory' => 'DebugBar\DataCollector\MemoryCollector',
            'messages' => 'DebugBar\DataCollector\MessagesCollector',
            'php_info' => 'DebugBar\DataCollector\PhpInfoCollector',
            'request_data' => 'DebugBar\DataCollector\RequestDataCollector',
            'time_data' => 'DebugBar\DataCollector\TimeDataCollector',
        ]
    ],
    'framework' => [
        'plugins' => [
            'debug.plugin.respond',
            'debug.plugin.toolbar',
        ],
        'twig' => ['paths' => [__DIR__ . '/../view']],
    ]
];
