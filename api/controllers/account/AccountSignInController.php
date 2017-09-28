<?php
namespace Api\Controller\Account;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;
use \Respect\Validation\Validator as v;
use \Api\Classes\JWTManager as JWTManager;

class AccountSignInController {
  protected $container;

  // construct container
  public function __construct(ContainerInterface $container) {
     $this->container = $container;
  }

  // data input validation
  public function validation () {
    return new \DavidePastore\Slim\Validation\Validation([
    #    'username' => v::alnum()->noWhitespace()->length(1, 10),
    #    'age' => v::numeric()->positive()->between(1, 20)
    ]);
  }

  // route response
  public function __invoke(Request $request, Response $response) {

    // initiate basic data variables
    $uri = $request->getUri();
    $data = [];

    // input error handling
    if($request->getAttribute('has_errors')){
      $data['data'] = $request->getAttribute('errors');
      $data['status'] = 400;
      $data['message'] = 'Invalid input field(s)';
      $data['developer'] = 'Invalid input, see data for further information';
      $response = $response->withStatus(400);
    } else {

      # Check input
      # Check bruteforce
      # If ok -> Sign in
      # Else -> Return error

      $jwtManager = new JWTManager($this->container->get('settings')['jwtSecret']);
      $jwt = $jwtManager->create($uri->getBaseUrl(), 2124, 2, time() + (60*60*60), true);
      $data['token'] = $jwt;
      $data['message'] = 'Success';
      $data['developer'] = 'User is signed in';
      $data['status'] = 200;
      $response = $response->withStatus(200);
    }

    $data['href'] = $uri->getBaseUrl().$uri->getPath();
    $data['timestamp'] = time();
    return $response->withJson($data);
  }
};
?>
