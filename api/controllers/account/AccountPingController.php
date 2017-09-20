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
  public function __construct(ContainerInterface $container) {
     $this->container = $container;
  }

  // data input validation
  public function validation () {
    return new \DavidePastore\Slim\Validation\Validation([
        'username' => v::alnum()->noWhitespace()->length(1, 10),
        'age' => v::numeric()->positive()->between(1, 20)
    ]);
  }

  // route response
  public function __invoke(Request $request, Response $response) {
    if($request->getAttribute('has_errors')){
      $errors = $request->getAttribute('errors');
      return $response->withJson($errors);
    } else {
      // decode JWT
      $payload = $this->container->get("jwt");

      // refresh JWT
      $uri = $request->getUri();
      $jwtManager = new JWTManager($this->container->get('settings')['jwtSecret']);
      $jwt = $jwtManager->refresh($payload, time() + 60);

      // construct response
      $data = [
        'href' => $uri->getBaseUrl().$uri->getPath(),
        'timestamp' => time(),
        'status' => $response->getStatusCode(),
        'message' => '',
        'developer' => '',
        'token' => $jwt,
        'data' => []
      ];

      return $response->withJson($data);
    }
  }

};
?>
