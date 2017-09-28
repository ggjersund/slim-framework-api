<?php
namespace Api\Controller\Account;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;
use \Firebase\JWT\JWT as JWT;
use \Respect\Validation\Validator as v;
use \Api\Classes\JWTManager as JWTManager;

class AccountPingController {
  protected $container;

  // construct container
  public function __construct($container) {
     $this->container = $container;
  }

  // route response
  public function __invoke(Request $request, Response $response) {
    // initiate basic data variables
    $uri = $request->getUri();
    $data = [];

    // error authenticating
    if ($request->getAttribute('has_errors')) {

      $errors = $request->getAttribute('errors');
      return $response->withJson($errors);

    } else {

      // decode JWT
      $payload = $this->container->get("jwt");

      // refresh JWT
      $jwtManager = new JWTManager($this->container->get('settings')['jwtSecret']);
      $jwt = $jwtManager->refresh($payload, time() + 60);

      // construct response
      $data = [
        'href' => $uri->getBaseUrl().$uri->getPath(),
        'timestamp' => time(),
        'status' => $response->getStatusCode(),
        'message' => 'Authentication token found',
        'developer' => 'Valid authentication token found in bearer',
        'token' => $jwt
      ];

      // respond
      return $response->withJson($data);
    };
  }
};
