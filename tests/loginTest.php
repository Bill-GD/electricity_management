<?php
include_once "../../database.php";
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase {
  private $db;

  protected function setUp(): void {
    global $db;
    $this->db = $db;
  }


  public function testLoginWithValidCredentials() {
    $email = "admin@gmail.com";
    $password = "adminpassword";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND password = '{$password}'";
    $query = $this->db->query($sql);

    if (!$query) {
      $errorInfo = $this->db->errorInfo();
      $this->fail("SQL Error: {$errorInfo[2]} (Code {$errorInfo[0]})");
    }

    $user = $query->fetchAll(PDO::FETCH_ASSOC);
    $this->assertNotEmpty($user, "No user found with email {$email} and the provided password");
  }


  public function testLoginWithInvalidEmail() {
    $email = "invalid@example.com";
    $password = "password123";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND password = '{$password}'";
    $user = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertEmpty($user);
  }

  public function testLoginWithInvalidPassword() {
    $email = "admin@gmail.com";
    $password = "invalidpassword";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND password = '{$password}'";
    $user = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertEmpty($user);
  }

  public function testLoginWithShortPassword() {
    $email = "test@example.com";
    $password = "short";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND password = '{$password}'";
    $user = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertEmpty($user, "Login should fail with short password");
  }

  public function testLoginWithLongPassword() {
    $email = "test@example.com";
    $password = "thisisaverylongpasswordthatshouldfail";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND password = '{$password}'";
    $user = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertEmpty($user, "Login should fail with long password");
  }

  public function testLoginWithEmailContainingWhitespace() {
    $email = "test @example.com";
    $password = "password123";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND password = '{$password}'";
    $user = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertEmpty($user, "Login should fail with email containing whitespace");
  }

  public function testLoginWithEmptyEmail() {
    $email = "";
    $password = "password123";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND password = '{$password}'";
    $user = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertEmpty($user, "Login should fail with empty email");
  }

  public function testLoginWithEmptyPassword() {
    $email = "test@example.com";
    $password = "";
    $sql = "SELECT * FROM User WHERE email = '{$email}' AND password = '{$password}'";
    $user = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $this->assertEmpty($user, "Login should fail with empty password");
  }

  public function testLoginWithEmailDomain() {
    $validDomains = ['gmail.com', 'st.phenikaa-uni.edu.vn'];
    $password = "adminpassword";

    foreach ($validDomains as $domain) {
      $email = "admin@{$domain}";
      $sql = "SELECT * FROM User WHERE email = '{$email}' AND password = '{$password}'";
      $user = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      $this->assertNotEmpty($user, "Login should succeed with @{$domain} email");
    }
  }

}