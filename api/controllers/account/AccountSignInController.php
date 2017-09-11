<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;

class AccountSignInController {
  protected $container;

  // constructor receives container instance
  public function __construct(ContainerInterface $container) {
     $this->container = $container;
  }

  public function __invoke(Request $request, Response $response) {

    $uri = $request->getUri();

    $jwtManager = new JWTManager($this->container->get('settings')['jwtSecret']);
    $jwt = $jwtManager->create($uri->getBaseUrl(), 123, time() + 60);
    $data = [
      'href' => $uri->getBaseUrl().$uri->getPath(),
      'timestamp' => time(),
      'status' => $response->getStatusCode(),
      'message' => '',
      'developer' => '',
      'token' => $jwt
    ];

    # 'decoded' => $this->get("jwt")

    return $response->withJson($data);
  }

};
?>
