<?php
 
return [
    'debug.bar' => 'Spiffy\DebugPackage\DebugBarFactory',
    'debug.plugin.respond' => 'Spiffy\DebugPackage\Plugin\RespondPluginFactory',
    'debug.plugin.toolbar' => ['Spiffy\DebugPackage\Plugin\ToolbarPlugin', ['@debug.bar']],
];