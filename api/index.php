<?php
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

// boot database ORM
$container = $app->getContainer();
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
  return $capsule;
};


// application middleware
require 'middleware/autoload.php';

// routes
require 'appRoutes.php';

// run application
$app->run();
