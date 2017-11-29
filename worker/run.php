<?php
require __DIR__ . '/../vendor/autoload.php';
session_start();

//load dot env
$dotenv = new \Dotenv\Dotenv(__DIR__, '../.env');
$dotenv->load();

$hostname = trim(shell_exec('hostname -I'));
slack('bot initiate');

while(true) {

  slack('bot running: ->  '.$hostname.' / '.$job);
  sleep(4);

}

function slack($msg=''){
  if($msg==''){
    $msg = 'test bot';
  }
  shell_exec('curl -sSX POST \
    --data \'{"text":"'.$msg.' @'.date('Y-m-d H:i:s').'"}\' \
    -H \'Content-type: application/json\' \
    \''.$_SERVER['SLACKBOT'].'\'');
}
exit;
