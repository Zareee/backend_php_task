<?php

namespace App\Repositories;

use DB\Database;
use mysqli_sql_exception;

class ResetPasswordsRepository
{

  private $mysqli;

  public function __construct()
  {

    $this->mysqli = (new Database())->connection();

  }



  public function getTokenByEmail(string $email): ?object
  {
    try {

      $stmt = $this->mysqli->prepare("SELECT email, token FROM reset_passwords WHERE email = ?");
      if (!$stmt) {
          throw new mysqli_sql_exception("Prepare failed: " . $this->mysqli->error);
      }

      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      $tokenData = $result->fetch_object();
      $stmt->close();

      return $tokenData ?: null;

    } catch (mysqli_sql_exception $e) {
      error_log("Error fetching token by email: " . $e->getMessage());
      return null;
    }
  }



  public function getToken(string $token): ?object
  {
    try {

      $oneHourAgo = date('Y-m-d H:i:s', strtotime('-1 hour'));

      $stmt = $this->mysqli->prepare("SELECT email, token FROM reset_passwords WHERE token = ? AND created_at >= ?");
      if (!$stmt) {
          throw new mysqli_sql_exception("Prepare failed: " . $this->mysqli->error);
      }

      $stmt->bind_param("ss", $token, $oneHourAgo);
      $stmt->execute();
      $result = $stmt->get_result();
      $tokenData = $result->fetch_object();

      $stmt->close();

      return $tokenData ?: null;

    } catch (mysqli_sql_exception $e) {
      error_log("Error fetching token: " . $e->getMessage());
      return null;
    }
  }


  public function addResetPasswordToken(string $email, string $token): bool
  {
      try {

        $stmt = $this->mysqli->prepare("INSERT INTO reset_passwords (email, token) VALUES (?, ?)");
        if (!$stmt) {
          throw new mysqli_sql_exception("Prepare failed: " . $this->mysqli->error);
        }

        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();
        $stmt->close();

        return true;

      } catch (mysqli_sql_exception $e) {
        error_log("Error inserting reset password token: " . $e->getMessage());
        return false;
      }
  }
}
