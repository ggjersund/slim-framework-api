<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $uri = $request->getUri();
    $data = [
      'href' => $uri->getBaseUrl().$uri->getPath(),
      'user' => $this->db->table('users')->find(1)
    ];
    return $response->withJson($data);
});
