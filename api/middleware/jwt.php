<?php
// Boot jwt middleware
$container["jwt"] = function ($container) {
    return new StdClass;
};

$jwtMiddleware = new \Slim\Middleware\JwtAuthentication([
    # HTTPS enabled
    "secure" => true,
    # HTTPS not required
    "relaxed" => ["localhost"],
    # JWT secret key
    "secret" => $container->get('settings')['jwtSecret'],
    # JWT as cookie
    #"cookie" => "AUTHTOK",
    # JWT as special header
    #"header" => "",
    # JWT algorithm
    "algorithm" => ["HS256", "HS512", "HS384"],
    # JWT content request attribute
    "attribute" => "jwt",
    # JWT success callback
    "callback" => function ($request, $response, $arguments) use ($container) {
        $container["jwt"] = $arguments["decoded"];
    },
    # JWT authentication error
    "error" => function ($request, $response, $arguments) {
        $uri = $request->getUri();
        $data = [
          'href' => $uri->getBaseUrl().$uri->getPath(),
          'timestamp' => time(),
          'status' => 401,
          'message' => $arguments["message"],
          'developer' => 'JWT token invalid and / or not supplied'
        ];
        return $response->withJson($data);
    }
]);
