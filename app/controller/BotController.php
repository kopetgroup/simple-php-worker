<?php
namespace App\Controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Predis as Predis;

final class BotController {

  public function run(Request $request, Response $response){

    $ec = $this->worker();
    if($ec){
      $s = 'bot running';
    }else{
      $sh = str_replace('/app/controller','/worker/init.sh',__DIR__);
      exec('nohup '.$sh.' > /dev/null 2>&1 &');
      $s = 'bot started';
    }
    $ec = $this->worker();
    $ed = [
      'status' => $s,
      'worker' => $ec
    ];
    $response = $response
      ->withAddedHeader('Access-Control-Allow-Methods','POST, GET, OPTIONS')
      ->withAddedHeader('Access-Control-Allow-Origin','*');
    $r = $response->withJson($ed);
    return $r;
  }

  public function status(Request $request, Response $response){
    $ec = $this->worker();
    $response = $response
      ->withAddedHeader('Access-Control-Allow-Methods','POST, GET, OPTIONS')
      ->withAddedHeader('Access-Control-Allow-Origin','*');
    $r = $response->withJson($ec);
    return $r;
  }

  public function kill(Request $request, Response $response){
    $ec = $this->worker();
    $ed = [];
    foreach($ec as $i){
      shell_exec('kill -9 '.$i['pid']);
      $ed[] = [
        'pid' => $i['pid'],
        'res' => 'killed'
      ];
    }
    $response = $response
      ->withAddedHeader('Access-Control-Allow-Methods','POST, GET, OPTIONS')
      ->withAddedHeader('Access-Control-Allow-Origin','*');
    $r = $response->withJson($ed);
    return $r;
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
      if(strpos($e,$dr)!==false && substr($d,-1)!=='/'){
        $ec[] = [
          'pid' => $i,
          'user' => $c[0],
          'path' => $d,
        ];
      }
    }
    return $ec;
  }

}
