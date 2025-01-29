<?php

namespace App\Services;

use App\Models\User;
use App\Responses\JsonResponse;

class UserService
{
    protected $user;
    protected $token;

    public function __construct()
    {
      $this->user = new User();
      $this->token = new TokenService();
    }

    public function loginService($request)
    {

      $email = $request['email'];
      $password = $request['password'];

      $user = $this->user->findByEmail($email);

      if (!$user) {
        return JsonResponse::error('User not found.', 404);
      }

      $hashedPassword = $this->user->getHashPasswordById($user->id);
      if (!$hashedPassword) {
        return JsonResponse::error('User not found.', 404);
      }

      if (!password_verify($password, $hashedPassword->password)) {
        return JsonResponse::error('Invalid credentials.', 401);
      }

      $token = $this->token->generateToken();

      return JsonResponse::success('Login successful.', [
          'token' => $token,
          'user' => $user
      ], 200);

    }



    public function registerService($request)
    {

      $email = $request['email'];
      $password = $request['password'];

      $existingUser = $this->user->findByEmail($email);
      if ($existingUser) {
          return JsonResponse::error('Email is already taken.', 'email', 409);
      }

      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      $this->user->create([
          'email' => $email,
          'password' => $hashedPassword
      ]);

      return JsonResponse::success('Registration successful.', [], 201);
    }



    public function logoutService($request)
    {
      $token = $request['token'];

      if (!$token) {
          return JsonResponse::error('No token provided.', 400);
      }

      return JsonResponse::success('Logged out successfully.', [], 200);
    }


}
