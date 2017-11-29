<?php
$app->get('/', 'App\Controller\BlogController:home');

$app->get('/bot/run', 'App\Controller\BotController:run');
$app->get('/bot/status', 'App\Controller\BotController:status');
$app->get('/bot/kill', 'App\Controller\BotController:kill');

/*
$app->get('/jobs/add', 'App\Controller\JobsController:add');
$app->get('/jobs/init', 'App\Controller\JobsController:init');
$app->get('/jobs/reset', 'App\Controller\JobsController:reset');
$app->get('/jobs/delete/{id}', 'App\Controller\JobsController:delete');
*/

$app->patch('/', 'App\Controller\WorkerController:run');
