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
    $data = [];
    
    # Check input

    # Check bruteforce

    # If ok -> Sign in
    $jwtManager = new JWTManager($this->container->get('settings')['jwtSecret']);
    $jwt = $jwtManager->create($uri->getBaseUrl(), 123, time() + 60);
    $data['token'] = $jwt;
    $data['message'] = 'Success';
    $data['developer'] = 'User is signed in';
    $data['status'] = 200;

    # Else -> Error

    $data['href'] = $uri->getBaseUrl().$uri->getPath();
    $data['timestamp'] = time();

    return $response->withJson($data);
  }

};
?>
