<?php
include_once dirname(__DIR__) . "/database.php";
require_once dirname(__DIR__) . '\src\classes\user.php';
use PHPUnit\Framework\TestCase;

class SignupTest extends TestCase {
  public function testSignupWithValidCredentials() {
    global $db;
    $email = "testuser@gmail.com";
    $username = "testuser";
    $password = "testpassword";

    $user = new User($email);
    $result = $user->signup($db, $username, $password);

    $this->assertTrue($result, "Signup should succeed with valid credentials");

    // Cleanup after test
    $sql = "DELETE FROM `User` WHERE email = '{$email}'";
    $db->query($sql);
  }
  public function testSignupWithShortPassword() {
    global $db;
    $email = "testuser@gmail.com";
    $username = "testuser";
    $password = "pas";

    $user = new User($email);
    $result = $user->signup($db, $username, $password);

    $this->assertFalse($result, "Signup should fail with password of length less than 4");

    // Cleanup after test
    $sql = "DELETE FROM `User` WHERE email = '{$email}'";
    $db->query($sql);
  }

  public function testSignupWithEmptyCredentials() {
    global $db;
    $email = "";
    $username = "";
    $password = "";

    try {
      new User($email);
    } catch (Exception $e) {
      $this->assertEquals('Email is required', $e->getMessage());
    }

    // Cleanup after test
    $sql = "DELETE FROM `User` WHERE email = '{$email}'";
    $db->query($sql);
  }

  public function testSignupWithEmptyEmail() {
    global $db;
    $email = "";
    $username = "testuser";
    $password = "testpassword";

    try {
      new User($email);
    } catch (Exception $e) {
      $this->assertEquals('Email is required', $e->getMessage());
    }

    // Cleanup after test
    $sql = "DELETE FROM `User` WHERE email = '{$email}'";
    $db->query($sql);
  }

  public function testSignupWithEmptyUsername() {
    global $db;
    $email = "testuser@gmail.com";
    $username = "";
    $password = "testpassword";

    $user = new User($email);
    $result = $user->signup($db, $username, $password);
    $this->assertFalse($result, "Signup should fail with empty username");

    // Cleanup after test
    $sql = "DELETE FROM `User` WHERE email = '{$email}'";
    $db->query($sql);
  }

  public function testSignupWithEmptyPassword() {
    global $db;
    $email = "testuser@gmail.com";
    $username = "testuser";
    $password = "";

    $user = new User($email);
    $result = $user->signup($db, $username, $password);
    $this->assertFalse($result, "Signup should fail with empty password");

    // Cleanup after test
    $sql = "DELETE FROM `User` WHERE email = '{$email}'";
    $db->query($sql);
  }

  public function testSignupWithEmailContainingWhitespace() {
    global $db;
    $email = "testus er@gmail.com";
    $username = "testuser";
    $password = "testpassword";

    try {
      new User($email);
    } catch (Exception $e) {
      $this->assertEquals('Invalid email format', $e->getMessage());
    }

    // Cleanup after test
    $sql = "DELETE FROM `User` WHERE email = '{$email}'";
    $db->query($sql);
  }

  public function testSignupWithEmailContainingSpecialCharacters() {
    global $db;
    $email = "testuser!#$%&\'*+-/=?^_`{|}~@gmail.com";
    $username = "testuser";
    $password = "testpassword";

    try {
      new User($email);
    } catch (Exception $e) {
      $this->assertEquals('Invalid email format', $e->getMessage());
    }

    // Cleanup after test
    $sql = "DELETE FROM `User` WHERE email = '{$email}'";
    $db->query($sql);
  }

  function testSignupWithLongPassword() {
    global $db;
    $email = "testuser@gmail.com";
    $username = "testuser";
    $password = "thisisaverylongpasswordthatshouldfail";

    $user = new User($email);
    $result = $user->signup($db, $username, $password);
    $this->assertFalse($result, "Signup should fail with password too long");

    // Cleanup after test
    $sql = "DELETE FROM `User` WHERE email = '{$email}'";
    $db->query($sql);
  }
}