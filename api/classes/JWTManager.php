<?php
// Required dependency
use \Firebase\JWT\JWT as JWT;

// JWT manager for creating and refreshing JWT tokens
class JWTManager {
  private $jwtSecret;

  public function __construct ($jwtSecret) {
    $this->jwtSecret = $jwtSecret;
  }
  public function create ($issuer, $user, $expire) {
    // create JWT
    $payload = [
    "iss" => $issuer,
    "iat" => time(),
    "identifier" => $user,
    "exp" => $expire
    ];
    $jwt = JWT::encode($payload, $this->jwtSecret);

    return $jwt;
  }
  public function refresh ($payload, $expire) {
    // refresh JWT
    $payload["iat"] = time();
    $payload["exp"] = $expire;
    $jwt = JWT::encode($payload, $this->jwtSecret);

    return $jwt;
  }
}
?>
