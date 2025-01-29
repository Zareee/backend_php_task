<?php

namespace App\Models;

use App\Repositories\UserRepository;

class User
{
  private $userRepository;

  public function __construct()
  {
    $this->userRepository = new UserRepository();
  }

  public function findByEmail(string $email): ?object
  {

    return $this->userRepository->getUserByEmail($email);
    
  }

  public function getHashPasswordById(int $user_id): ?object
  {

    return $this->userRepository->getPassword($user_id);
    
  }

  public function create(array $data): void
  {

    $this->userRepository->createUser($data);
    
  }

  public function updatePassword(array $data): void
  {

    $this->userRepository->updatePassword($data);
    
  }


}
