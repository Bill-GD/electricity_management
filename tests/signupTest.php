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

  public function testSignupWithEmptyCredentials() {
    global $db;
    $email = "";
    $username = "";
    $password = "";

    try {
      $user = new User($email);
      $user->signup($db, $username, $password);
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
      $user = new User($email);
      $user->signup($db, $username, $password);
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
      $user = new User($email);
      $user->signup($db, $username, $password);
    } catch (Exception $e) {
      $this->assertEquals('Invalid email format', $e->getMessage());
    }

    // Cleanup after test
    $sql = "DELETE FROM `User` WHERE email = '{$email}'";
    $db->query($sql);
  }

  // public function testSignupWithEmailDomain() {
  //   global $db;
  //   $validEmails = ["testuser@gmail.com", "testuser@st.phenikaa-uni.edu.vn"];
  //   $username = "testuser";
  //   $password = "testpassword";


  //   foreach ($validEmails as $email) {
  //     $user = new User($email);
  //     try {
  //       $result = $user->signup($email, $username, $password);
  //       $this->assertTrue($result, "Signup should succeed with valid email domain");
  //     } catch (Exception $e) {
  //       $this->fail("Signup should not throw exception with valid email domain");
  //     }

  //     // Cleanup after test
  //     $sql = "DELETE FROM User WHERE email = '{$email}'";
  //     $db->query($sql);
  //   }
  // }

  public function testSignupWithEmailContainingSpecialCharacters() {
    global $db;
    $email = "testuser!#$%&\'*+-/=?^_`{|}~@gmail.com";
    $username = "testuser";
    $password = "testpassword";

    try {
      $user = new User($email);
      $user->signup($db, $username, $password);
    } catch (Exception $e) {
      $this->assertEquals('Invalid email format', $e->getMessage());
    }

    // Cleanup after test
    $sql = "DELETE FROM `User` WHERE email = '{$email}'";
    $db->query($sql);
  }
}