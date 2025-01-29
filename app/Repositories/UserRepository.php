<?php

namespace App\Repositories;

use DB\Database;
use mysqli_sql_exception;

class UserRepository
{

  private $mysqli;

  public function __construct()
  {
    $this->mysqli = (new Database())->connection();
  }


  public function getUserByEmail(string $email): ?object
  {

      try {
        
        $stmt = $this->mysqli->prepare("SELECT id, email FROM users WHERE email = ?");
        if (!$stmt) {
            throw new mysqli_sql_exception("Prepare failed: " . $this->mysqli->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_object();
        $stmt->close();

        return $user ?: null;

      } catch (mysqli_sql_exception $e) {
        error_log("Error fetching user by email: " . $e->getMessage());
        return null;
      }
  }


  public function getPassword(int $user_id): ?object
  {

    try {

      $stmt = $this->mysqli->prepare("SELECT password FROM users WHERE id = ?");
      if (!$stmt) {
          throw new mysqli_sql_exception("Prepare failed: " . $this->mysqli->error);
      }

      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_object();
      $stmt->close();

      return $row ?? null;

    } catch (mysqli_sql_exception $e) {
        error_log("Error fetching password: " . $e->getMessage());
        return null;
    }

  }


  public function createUser(array $data): bool
  {

    try {

      $stmt = $this->mysqli->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
      if (!$stmt) {
          throw new mysqli_sql_exception("Prepare failed: " . $this->mysqli->error);
      }

      $stmt->bind_param("ss", $data['email'], $data['password']);
      $success = $stmt->execute();
      $stmt->close();

      return $success;

    } catch (mysqli_sql_exception $e) {
      error_log("Error creating user: " . $e->getMessage());
      return false;
    }

  }


  public function updatePassword(array $data): bool
  {
    try {

      $stmt = $this->mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");
      if (!$stmt) {
          throw new mysqli_sql_exception("Prepare failed: " . $this->mysqli->error);
      }

      $stmt->bind_param("si", $data['password'], $data['user_id']);
      $success = $stmt->execute();
      $stmt->close();

      return $success;

    } catch (mysqli_sql_exception $e) {
      error_log("Error updating password: " . $e->getMessage());
      return false;
    }
  }
}
