<?php

class User {
  public int $id;
  public string $email;
  public string $username;
  public int $type;
  public int $user_id;

  public function __construct(string $email, int $type = 0) {
    if (empty($email)) {
      throw new Exception('Email is required');
    }
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$/", $email)) {
      throw new Exception('Invalid email format');
    }

    $this->email = $email;
    $this->type = $type;
  }
  public function signup(PDO &$db, string $username, string $password): bool {
    if (empty($username) || empty($password)) {
      // throw new Exception('Email, username, and password are required');
      return false;
    }

    if (strlen($password) < 4) {
      return false;
    }

    // Check if a user already exists with the given email or username
    $sql = "SELECT * FROM `User` WHERE email = '{$this->email}' OR username = '{$username}'";
    $user = $db->query($sql)->fetch();

    if ($user) {
      throw new Exception('User already exists with this email or username');
    }
    $this->username = $username;

    // Store the new user in the database
    $sql = "INSERT INTO `User` (email, username, `password`, `type`) VALUES ('{$this->email}', '{$this->username}', '{$password}', {$this->type})";
    $db->query($sql);
    $this->user_id = $db->lastInsertId();
    return true;
  }

  public function login(PDO &$db, string $password): bool {
    if (empty($password)) {
      // throw new Exception('Email, username, and password are required');
      return false;
    }

    // Check if a user exists with the given email and password
    $sql = "SELECT * FROM `User` WHERE email = '{$this->email}' AND `password` = '{$password}'";
    $user = $db->query($sql)->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
      return false;
    }

    $this->username = $user['username'];
    $this->user_id = $user['user_id'];
    $this->type = $user['type'];
    return true;
  }
}