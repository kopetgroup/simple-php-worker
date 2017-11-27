<?php
return [
  'settings' => [

    // Slim Settings
    'determineRouteBeforeAppMiddleware' => false,
    'displayErrorDetails' => true,

    // monolog settings
    'logger' => [
        'name' => 'app',
        'path' => __DIR__ . '/../../logs/app.log',
    ]

  ]
];
