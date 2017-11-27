<?php
namespace App\Controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

final class BlogController {

  private $logger;

  public function __construct($logger) {
    $this->logger = $logger;
  }

  public function home(Request $request, Response $response){

    $this->logger->addInfo("Something interesting happened");

    $data = $_SERVER;

    $response = $response
      ->withAddedHeader('Access-Control-Allow-Methods','POST, GET, OPTIONS')
      ->withAddedHeader('Access-Control-Allow-Origin','*');

    $r = $response->withJson($data);
    return $r;
  }

}
