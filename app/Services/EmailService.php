<?php

namespace App\Services;

use App\Models\ResetPassword;
use App\Services\TokenService;
use App\Responses\JsonResponse;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{

  private $mail;
  private $token;
  private $resetPassword;

  public function __construct()
  {
    $this->mail = new PHPMailer(true);
    $this->token = new TokenService();
    $this->resetPassword = new ResetPassword();
    $this->configEmail();
  }

  function configEmail()
  {
    $this->mail->isSMTP();
    $this->mail->Host = 'smtp.gmail.com';
    $this->mail->SMTPAuth = true; 
    $this->mail->Username = 'zaric.nemanja.dev@gmail.com';
    $this->mail->Password = 'zfwx kpmh cxon ujso';
    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $this->mail->Port = 587;
  }


  function sendEmail($request) 
  {

    try {

      $toEmail = $request['email'];

      $resetLink = $this->generateResetLink($toEmail);

      $this->mail->setFrom("zaric.nemanja.dev@gmail.com");
      $this->mail->addAddress($toEmail);

      $this->mail->isHTML(true);
      $this->mail->Subject = 'Reset your password.';
      $this->mail->Body = $this->generateEmailBody($resetLink);


      if (!$this->mail->send()) {
        return JsonResponse::error('User not found.', 400);
      }

      return JsonResponse::success('Message has been sent', [], 200); 

    } catch (Exception $e) {
      return JsonResponse::error("Message could not be sent. Error: {$e->getMessage()}", 400);
    }

  }

  public function generateResetLink(string $email): string
  {
    $token = $this->token->generateToken();
    $this->resetPassword->addToken($email, $token);

    return "http://localhost:8080/reset-password?token={$token}&email={$email}";
  }


  private function generateEmailBody(string $resetLink): string
  {
    return "
        <html>
            <body>
                <p>Hello,</p>
                <p>We received a request to reset your password. Click the link below:</p>
                <p><a href='{$resetLink}' target='_blank'>{$resetLink}</a></p>
                <p>If you didn't request this, please ignore this email.</p>
            </body>
        </html>
      ";
  }


}


