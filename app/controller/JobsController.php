<?php
namespace App\Controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Predis as Predis;

final class JobsController {

  public function run(){

    $ec = $this->worker();
    if($ec){
      echo 'bot running';
    }else{
      $sh = str_replace('/app/controller','/worker/init.sh',__DIR__);
      $rt = exec('nohup '.$sh);
      echo $rt;
    }
  }

  public function status(){
    $ec = $this->worker();
    print_r($ec);
  }

  public function kill(){
    $ec = $this->worker();
    foreach($ec as $i){
      echo 'pid '.$i['pid'].' killed';
      shell_exec('kill -9 '.$i['pid']);
    }
  }

  public function worker(){
    $dr = str_replace('/app/controller','/worker/',__DIR__);
    $ps = shell_exec('ps aux | grep '.$dr.'');
    $ps = explode("\n",$ps);
    $ec = [];
    foreach($ps as $e){
      $c = preg_replace(array('/\s{2,}/', '/[\t\n]/'), '|', $e);
      $c = explode('|',$c);
      $i = $c[1];
      $d = explode(' ',$e);
      $d = $d[count($d)-1];
      if($i && strpos($d,$dr)!==false && substr($d,-1)!=='/'){
        $ec[] = [
          'pid' => $i,
          'user' => $c[0],
          'path' => $d
        ];
      }
    }
    return $ec;
  }

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
