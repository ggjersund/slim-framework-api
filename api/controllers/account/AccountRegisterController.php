<?php
namespace Api\Controller\Account;

// required interfaces
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;
use \Respect\Validation\Validator as v;

// required models
use \Api\Model\User as User;

class AccountRegisterController {
  protected $container;

  // construct container
  public function __construct(ContainerInterface $container) {
     $this->container = $container;
  }

  // data input validation

  public function validation () {
    return new \DavidePastore\Slim\Validation\Validation([
      /*
      'firstname' => v::stringType()->length(1, 100, true),
      'lastname' => v::stringType()->length(1, 100, true),
      'age' => v::age(5, 120),
      'email' => v::email(),
      'password' => v::stringType()->length(8, 30, true),
      'agreement' => v::boolType()->trueVal()*/
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

      // register and send mail
      $user['email'] = 'test@example.com';

      $this->container->mailer->send('email/register.twig', ['title' => User::where('Id', 1)->first()] , function($message) use ($user){
        $message->to($user['email']);
        $message->subject('Email Subject');
        $message->from('sender@email.com'); // if you want different sender email in mailer call function
        $message->fromName('Sender Name'); // if you want different sender name in mailer call function
      });
      # Check input
      # Check bruteforce
      # If ok -> Sign in
      # Else -> Return error


      $data['message'] = 'Success';
      $data['developer'] = 'User has been registered';
      $data['status'] = 200;
      $response = $response->withStatus(200);
    }

    $data['href'] = $uri->getBaseUrl().$uri->getPath();
    $data['timestamp'] = time();
    return $response->withJson($data);
  }
};
?>
