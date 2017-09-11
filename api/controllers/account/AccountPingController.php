<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;
use \Firebase\JWT\JWT as JWT;

class AccountPingController {
  protected $container;

  // constructor receives container instance
  public function __construct(ContainerInterface $container) {
     $this->container = $container;
  }

  public function __invoke(Request $request, Response $response) {

    // decode JWT
    $payload = $this->container->get("jwt");

    // refresh JWT
    $uri = $request->getUri();
    $jwtManager = new JWTManager($this->container->get('settings')['jwtSecret']);
    $jwt = $jwtManager->refresh ($payload, time() + 60);

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

};
?>
