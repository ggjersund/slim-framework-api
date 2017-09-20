<?php
$app->get('/account/ping', '\Api\Controller\Account\AccountPingController')
          ->add('\Api\Middleware\JWT');
$app->get('/account/sign-in', '\Api\Controller\Account\AccountSignInController')
          ->add(\Api\Controller\Account\AccountSignInController::validation());
