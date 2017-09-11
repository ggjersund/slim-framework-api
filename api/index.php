<?php
// set default timezone
date_default_timezone_set('Europe/Oslo');

// require composer
require '../vendor/autoload.php';

// enable developement environment
$devMode = true;

// Create config variable
$config = [];

// application configuration (no secret configs here)
require 'appConfig.php';

// secret configuration (dev or live)
require ($devMode) ? 'appDevConfig.php' : 'appLiveConfig.php';

// begin application
$app = new \Slim\App($config);

// application middleware
require 'middleware/autoload.php';

// routes
require 'appRoutes.php';

// run application
$app->run();
