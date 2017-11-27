<?php
// DIC configuration
$container = $app->getContainer();

//load dot env
$dotenv = new Dotenv\Dotenv(__DIR__, '../../.env');
$dotenv->load();

//Override the default Not Found Handler
$container['notFoundHandler'] = function ($c) {
  return function ($request, $response) use ($c) {
    return $c['response']
      ->withStatus(404)
      ->withHeader('Content-Type', 'text/html')
      ->write('404 Dude!');
  };
};

$container['notAllowedHandler'] = function ($c) {
  return function ($request, $response) use ($c) {
    return $c['response']
      ->withStatus(404)
      ->withHeader('Content-Type', 'text/html')
      ->write('Dude! this page is Forbidden');
  };
};


// monolog
$container['logger'] = function ($c) {
  $settings = $c->get('settings');
  $logger = new Monolog\Logger($settings['logger']['name']);
  $logger->pushProcessor(new Monolog\Processor\UidProcessor());
  $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['logger']['path'], Monolog\Logger::DEBUG));
  return $logger;
};

// predis
$container['redis'] = function ($c) {
  $r = new Predis\Client();
  return $r;
};


/*
  Controller
*/
$container[App\Controller\BlogController::class] = function ($c) {
  return new App\Controller\BlogController($c->logger);
};

$container[App\Controller\WorkerController::class] = function ($c) {
  return new App\Controller\WorkerController(
    $c->logger,
    $c->redis
  );
};
