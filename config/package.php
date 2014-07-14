<?php

return [
    'debug' => [],
    'framework' => [
        'plugins' => [
            'Spiffy\DebugPackage\Plugin\RespondPlugin'
        ],
        'twig' => ['paths' => [__DIR__ . '/../view']],
    ]
];
