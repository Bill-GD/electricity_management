<?php

class User {
  public int $id;
  public string $email;
  public string $username;
  public int $type;
  public int $user_id;

  public function __construct(string $email) {
    $this->email = $email;
  }
  public function signup(PDO &$db, string $username, string $password) {
    // Check if a user already exists with the given email or username
    $sql = "SELECT * FROM `User` WHERE email = '{$this->email}' OR username = '{$username}'";
    $user = $db->query($sql)->fetch();

    if ($user) {
      throw new Exception('User already exists with this email or username');
    }
    $this->username = $username;
    
    // Store the new user in the database
    $sql = "INSERT INTO `User` (email, username, `password`, `type`) VALUES ('{$this->email}', '{$this->username}', '{$password}', '{$this->type}')";
    $db->query($sql);
    $this->user_id = $db->lastInsertId();
    return true;
  }

  public function login(PDO &$db, string $password) {
    // Check if a user exists with the given email and password
    $sql = "SELECT * FROM `User` WHERE email = '{$this->email}' AND `password` = '{$password}'";
    $user = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
    
    $this->username = $user['username'];
    $this->user_id = $user['user_id'];
    $this->type = $user['type'];

    if (!$user) {
      return false;
    }
    return true;
  }
}