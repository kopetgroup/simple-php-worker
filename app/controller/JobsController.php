<?php
namespace App\Controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Predis as Predis;

final class JobsController {

  public function init(Request $request, Response $response){

    //redis
    $redis = new Predis\Client($_SERVER['REDIS']);
    $e = $redis->keys('1*');
    asort($e);
    $e = array_values($e);
    $e = $e[0];
    print_r($e);
    exit;

  }

  /*
    Run Job.
    1. cek job via redis
    2. nek enek job, garap. terus kill
  */
  public function add(Request $request, Response $response){

    //redis
    $redis = new Predis\Client($_SERVER['REDIS']);

    //add job
    $job = [
      'action' => 'ngiving',
      'total' => 100
    ];
    $id = str_replace('.','',microtime(true));
    $ed = $redis->set('1'.$id,json_encode($job));
    $ed = $redis->set('recent',$id);

    $response = $response
      ->withAddedHeader('Access-Control-Allow-Methods','POST, GET, OPTIONS')
      ->withAddedHeader('Access-Control-Allow-Origin','*');
    $r = $response->withJson([
      'status' => 'success',
      'job_id' => $id
    ]);
    return $r;

  }

  public function reset(Request $request, Response $response, $args){
    $redis = new Predis\Client($_SERVER['REDIS']);
    foreach($redis->keys('*') as $c){
      $redis->del($c);
    }
  }

  /*
    Delete Jobs
  */
  public function delete(Request $request, Response $response, $args){

    //redis
    $redis = new Predis\Client($_SERVER['REDIS']);
    $id = $redis->del($args['id']);


    $response = $response
      ->withAddedHeader('Access-Control-Allow-Methods','POST, GET, OPTIONS')
      ->withAddedHeader('Access-Control-Allow-Origin','*');
    $r = $response->withJson([
      'status' => 'success',
      'job_id' => $id
    ]);
    return $r;

  }

}
