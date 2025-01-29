<?php

namespace App\Services;

use App\Models\ResetPassword;
use App\Models\User;
use App\Responses\JsonResponse;

class ResetPasswordService
{
    protected $user;
    protected $resetPassword;

    public function __construct()
    {
      $this->resetPassword = new ResetPassword();
      $this->user = new User();
    }


    
    public function resetPassword($request)
    {
      $token = $request['token'];
      $email = $request['email'];
      $password = $request['new_password'];
  
      $checkUser = $this->user->findByEmail($email);
  
      $checkToken = $this->resetPassword->findToken($token);
  
      if (!$checkUser) {
          return JsonResponse::error('User not found.', 404);
      }
  
      if (!$checkToken) {
          return JsonResponse::error('Invalid or expired token.', 400);
      }
  
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  
      $this->user->updatePassword([
        'user_id' => $checkUser->id,
        'password' => $hashedPassword
      ]);
  
      return JsonResponse::success('Password reset successfully.', [], 200);
    }

}
