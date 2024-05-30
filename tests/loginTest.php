<?php
include_once dirname(__DIR__) . "/database.php";

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase {
  public function testLoginWithValidCredentials() {
    global $db;
    $email = "admin@gmail.com";
    $password = "adminpassword";
    $sql = "SELECT * FROM `User` WHERE email = '{$email}' AND `password` = '{$password}'";
    $result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertNotEmpty($result, "No user found with email {$email} and the provided password");
  }


  public function testLoginWithInvalidEmail() {
    global $db;
    $email = "invalid@example";
    $password = "password123";
    try {
      (new User($email))->login($db, $password);
    } catch (Exception $e) {
      $this->assertEquals('Invalid email format', $e->getMessage(), "Login should fail with invalid email");
    }
  }

  public function testLoginWithInvalidPassword() {
    global $db;
    $email = "admin@gmail.com";
    $password = "invalidpassword";
    $result = (new User($email))->login($db, $password);
    $this->assertFalse($result, "Login should fail with wrong password");
  }

  public function testLoginWithShortPassword() {
    global $db;
    $email = "test@example.com";
    $password = "pas";
    $result = (new User($email))->login($db, $password);
    $this->assertFalse($result, "Login should fail with short password");
  }

  public function testLoginWithLongPassword() {
    global $db;
    $email = "test@example.com";
    $password = "thisisaverylongpasswordthatshouldfail";
    $result = (new User($email))->login($db, $password);
    $this->assertFalse($result, "Login should fail with too long password");
  }

  public function testLoginWithEmailContainingWhitespace() {
    global $db;
    $email = "test @example.com";
    $password = "password123";
    try {
      (new User($email))->login($db, $password);
    } catch (Exception $e) {
      $this->assertEquals('Invalid email format', $e->getMessage(), "Login should fail with email containing whitespace");
    }
  }

  public function testLoginWithEmptyEmail() {
    global $db;
    $email = "";
    $password = "password123";
    try {
      (new User($email))->login($db, $password);
    } catch (Exception $e) {
      $this->assertEquals('Email is required', $e->getMessage(), "Login should fail with empty email");
    }
  }

  public function testLoginWithEmptyPassword() {
    global $db;
    $email = "test@example.com";
    $password = "";
    $result = (new User($email))->login($db, $password);
    $this->assertEmpty($result, "Login should fail with empty password");
  }
}