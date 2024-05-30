<?php

class User
{
  private $db;

  public int $id;
  public string $email;
  public string $username;
  public bool $isAdmin;
  public function __construct($db)
  {
    $this->db = $db;
  }
  public function signup($email, $username, $password)
  {
    // Validate input data
    if (empty($email) || empty($username) || empty($password)) {
      throw new Exception('Email, username, and password are required');
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new Exception('Invalid email format');
    }

    // Check if a user already exists with the given email or username
    $sql = "SELECT * FROM User WHERE email = ? OR username = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$email, $username]);
    $user = $stmt->fetch();

    if ($user) {
      throw new Exception('User already exists with this email or username');
    }
    // Store the new user in the database
    $sql = "INSERT INTO User (email, username, password, type) VALUES (?, ?, ?, 0)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$email, $username, $password]);

    return true;
  }
}