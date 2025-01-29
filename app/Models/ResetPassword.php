<?php

namespace App\Models;

use App\Repositories\ResetPasswordsRepository;

class ResetPassword
{
  
  private $resetPasswordsRepository;

  public function __construct()
  {

    $this->resetPasswordsRepository = new ResetPasswordsRepository();

  }

  public function findTokenByUserId(string $email): ?object
  {

    return $this->resetPasswordsRepository->getTokenByEmail($email);
    
  }

  public function findToken(string $token): ?object
  {

    return $this->resetPasswordsRepository->getToken($token);
    
  }

  public function addToken(string $email, string $token): void
  {

    $this->resetPasswordsRepository->addResetPasswordToken($email, $token);
    
  }


}
