<?php
// set default timezone
date_default_timezone_set('Europe/Oslo');

// require composer
require '../vendor/autoload.php';

// enable developement environment
$devMode = true;

// application configuration (no secret configs here)
require 'appBaseConfig.php';

// secret configuration (dev or live)
require ($devMode) ? 'appDevConfig.php' : 'appLiveConfig.php';

// begin application
$app = new \Slim\App($config);

// boot Eloquent
$container = $app->getContainer();
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// set container values
$container['db'] = function ($container) use ($capsule) { return $capsule; };
$container["jwt"] = function ($container) { return new StdClass; };

// middleware
$app->add('\Api\Middleware\CORS');

// routes
require 'appRoutes.php';

// run application
$app->run();
