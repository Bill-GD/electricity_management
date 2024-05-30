<?php
include_once dirname(__DIR__) . "/database.php";

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase {
  // private $db;

  // protected function setUp(): void {
  //   global $db;
  //   $this->db = $db;
  // }

  public function testLoginWithValidCredentials() {
    global $db;
    $email = "admin@gmail.com";
    $password = "adminpassword";
    $sql = "SELECT * FROM `User` WHERE email = '{$email}' AND `password` = '{$password}'";
    $result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    // if (!$query) {
    //   $errorInfo = $db->errorInfo();
    //   $this->fail("SQL Error: {$errorInfo[2]} (Code {$errorInfo[0]})");
    // }
    $this->assertNotEmpty($result, "No user found with email {$email} and the provided password");
  }


  public function testLoginWithInvalidEmail() {
    global $db;
    $email = "invalid@example";
    $password = "password123";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND `password` = '{$password}'";
    $user = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertEmpty($user);
  }

  public function testLoginWithInvalidPassword() {
    global $db;
    $email = "admin@gmail.com";
    $password = "invalidpassword";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND `password` = '{$password}'";
    $user = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertEmpty($user);
  }

  public function testLoginWithShortPassword() {
    global $db;
    $email = "test@example.com";
    $password = "short";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND `password` = '{$password}'";
    $user = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertEmpty($user, "Login should fail with short password");
  }

  public function testLoginWithLongPassword() {
    global $db;
    $email = "test@example.com";
    $password = "thisisaverylongpasswordthatshouldfail";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND `password` = '{$password}'";
    $user = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertEmpty($user, "Login should fail with long password");
  }

  public function testLoginWithEmailContainingWhitespace() {
    global $db;
    $email = "test @example.com";
    $password = "password123";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND `password` = '{$password}'";
    $user = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertEmpty($user, "Login should fail with email containing whitespace");
  }

  public function testLoginWithEmptyEmail() {
    global $db;
    $email = "";
    $password = "password123";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND `password` = '{$password}'";
    $user = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertEmpty($user, "Login should fail with empty email");
  }

  public function testLoginWithEmptyPassword() {
    global $db;
    $email = "test@example.com";
    $password = "";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND `password` = '{$password}'";
    $user = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertEmpty($user, "Login should fail with empty password");
  }

  // public function testLoginWithEmailDomain() {
  //   $validDomains = ['gmail.com', 'st.phenikaa-uni.edu.vn'];
  //   $password = "adminpassword";

  //   foreach ($validDomains as $domain) {
  //     $email = "admin@{$domain}";
  //     $sql = "SELECT * FROM User WHERE email = '{$email}' AND `password` = '{$password}'";
  //     $user = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  //     $this->assertNotEmpty($user, "Login should succeed with @{$domain} email");
  //   }
  // }
}