<?php

namespace App\Services;


class TokenService
{
 
  public function generateToken()
  {
    $token = bin2hex(random_bytes(16));

    return $token;
  }


}
