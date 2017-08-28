<?php
// Cross Origin Resource Sharing
$app->add(function($request, $response, $next) {
  $route = $request->getAttribute('route');
  $methods = [];
  if (!empty($route)) {
    $pattern = $route->getPattern();
    foreach ($this->router->getRoutes() as $route) {
      if ($pattern === $route->getPattern()) {
        $methods = array_merge_recursive($methods, $route->getMethods());
      }
    }
  } else {
    $methods[] = $request->getMethod();
  }
  $response = $next($request, $response);

  return $response
    ->withHeader('Access-Control-Allow-Origin', 'https://www.slimopplevelse.devz')
    ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Accept, Origin')
    ->withHeader('Access-Control-Allow-Credentials', 'true')
    ->withHeader('Access-Control-Allow-Methods', implode(',', $methods));
});
