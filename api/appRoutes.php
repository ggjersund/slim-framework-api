<?php
require_once "classes/JWTManager.php";
require_once "controllers/account/AccountPingController.php";
require_once "controllers/account/AccountSignInController.php";

$app->get('/account/ping', 'AccountPingController')->add($jwtMiddleware);
$app->get('/account/sign-in', 'AccountSignInController');
