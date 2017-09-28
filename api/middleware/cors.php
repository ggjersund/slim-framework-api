<?php
namespace Api\Middleware;

class CORS {
  protected $container;
  public function __construct ($container) {
    $this->container = $container;
  }

  public function __invoke ($request, $response, $next) {
    $route = $request->getAttribute('route');
    $methods = [];
    if (!empty($route)) {
      $pattern = $route->getPattern();
      foreach ($this->container->router->getRoutes() as $route) {
        if ($pattern === $route->getPattern()) {
          $methods = array_merge_recursive($methods, $route->getMethods());
        }
      }
    } else {
      $methods[] = $request->getMethod();
    }
    $response = $next($request, $response);

    return $response
      ->withHeader('Date', gmdate('D, d M Y H:i:s T'))
      ->withHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains')
      ->withHeader('X-Frame-Options', 'SAMEORIGIN')
      ->withHeader('X-XSS-Protection', '1; mode=block')
      ->withHeader('X-Content-Type-Options', '"nosniff"')
      ->withHeader('Referrer-Policy', 'origin')
      ->withHeader('Access-Control-Allow-Origin', 'https://slimfrontend.devz')
      ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Accept, Origin, Authorization')
      ->withHeader('Access-Control-Allow-Credentials', 'true')
      ->withHeader('Access-Control-Allow-Methods', implode(',', $methods));
  }
}
