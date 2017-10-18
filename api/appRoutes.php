<?php
// account routes
$app->post('/account/sign-in', '\Api\Controller\Account\AccountSignInController')
  ->add(\Api\Controller\Account\AccountSignInController::validation());
$app->get('/account/register', '\Api\Controller\Account\AccountRegisterController')
  ->add(\Api\Controller\Account\AccountRegisterController::validation());
$app->get('/account/ping', '\Api\Controller\Account\AccountPingController')
  ->add('\Api\Middleware\JWT');
