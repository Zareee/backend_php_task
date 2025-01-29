<?php
namespace App\Controllers;

use App\Services\UserService;
use App\Services\EmailService;
use App\Services\ResetPasswordService;

class AuthController
{


  public function login($request)
  {

    return (new UserService())->loginService($request);

  }

  public function logout($request)
  {

    return (new UserService())->logoutService($request);

  }

  public function register($request)
  {

    return (new UserService())->registerService($request);

  }

  public function sendLink($request)
  {

    return (new EmailService())->sendEmail($request);

  }

  public function resetPassword($request)
  {

    return (new ResetPasswordService())->resetPassword($request);

  }

}
