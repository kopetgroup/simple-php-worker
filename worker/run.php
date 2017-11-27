<?php
require __DIR__ . '/../vendor/autoload.php';
session_start();

//load dot env
$dotenv = new \Dotenv\Dotenv(__DIR__, '../.env');
$dotenv->load();

slack('bot initiate');

//load redis
if(isset($_SERVER['REDIS'])){
  $r = $_SERVER['REDIS'];
}else{
  $r = '';
}
//$redis = new \Predis\Client($r);
//looping
while(true) {

  /*
  $e = $redis->keys('1*');
  asort($e);
  $e = array_values($e);
  $job = $e[0];

  $date = date('Y-m-d H:i:s');

  //cek job
  if(!empty($job)){

    //get job
    echo 'running job: "'.$job.'" @'.$date."\n";
    slack('bot running: '.$job);

    echo shell_exec('php $PWD/public/index.php '.$job);
    //echo shell_exec('curl -sSXPATCH http://localhost:8080');
    echo "\n";
    //delete job
    #$redis->lpop('job');
    sleep(2);

  }else{
    //slack('bot entek ');
    echo 'job entek. @'.$date."\n";
    sleep(10);
  }
  */
  //echo 'running job: "'.$job.'" -> '.$_SERVER['HTTP_HOST'].' @'.$date."\n";
  $argv = $GLOBALS['argv'];
  slack('bot running: ->  '.$argv[1].' / '.$job);
  sleep(4);

}

function slack($msg=''){
  if($msg==''){
    $msg = 'test bot';
  }
  shell_exec('curl -sSX POST \
    --data \'{"text":"'.$msg.' @'.date('Y-m-d H:i:s').'"}\' \
    -H \'Content-type: application/json\' \
    \'https://hooks.slack.com/services/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\'');
}
exit;
