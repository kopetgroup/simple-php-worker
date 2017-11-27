<?php
$app->get('/', 'App\Controller\BlogController:home');

$app->get('/jobs/run', 'App\Controller\JobsController:run');
$app->get('/jobs/status', 'App\Controller\JobsController:status');
$app->get('/jobs/kill', 'App\Controller\JobsController:kill');

$app->get('/jobs/add', 'App\Controller\JobsController:add');
$app->get('/jobs/init', 'App\Controller\JobsController:init');
$app->get('/jobs/reset', 'App\Controller\JobsController:reset');
$app->get('/jobs/delete/{id}', 'App\Controller\JobsController:delete');

$app->patch('/', 'App\Controller\WorkerController:run');
