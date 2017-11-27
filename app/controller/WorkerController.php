<?php
namespace App\Controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

final class WorkerController {

  private $logger;
  private $redis;

  public function __construct($logger,$redis) {
    $this->logger = $logger;
    $this->redis = $redis;
  }

  /*
    Run Job.
    1. cek job via redis
    2. nek enek job, garap. terus kill
  */
  public function run(Request $request, Response $response){

    $argv = $GLOBALS['argv'];
    print_r($argv);
    echo 'kopet';
    exit;

  }

}
