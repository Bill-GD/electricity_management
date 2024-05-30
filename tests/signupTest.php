<?php
include_once "../database.php";
require_once dirname(__DIR__) . '\classes\user.php';
use PHPUnit\Framework\TestCase;

class SignupTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        global $db;
        $this->db = $db;
    }

    public function testSignupWithValidCredentials()
    {
        $email = "testuser@gmail.com";
        $username = "testuser";
        $password = "testpassword";

        // Assuming you have a User class with a signup method
        $user = new User($this->db);
        $result = $user->signup($email, $username, $password);

        $this->assertTrue($result, "Signup should succeed with valid credentials");

        // Cleanup after test
        $sql = "DELETE FROM User WHERE email = '{$email}'";
        $this->db->query($sql);
    }

    public function testSignupWithEmptyCredentials()
    {
        $email = "";
        $username = "";
        $password = "";

        // Assuming you have a User class with a signup method
        $user = new User($this->db);

        try {
            $result = $user->signup($email, $username, $password);
        } catch (Exception $e) {
            $this->assertEquals('Email, username, and password are required', $e->getMessage());
        }

        // Cleanup after test
        $sql = "DELETE FROM User WHERE email = '{$email}'";
        $this->db->query($sql);
    }

    public function testSignupWithEmptyEmail()
    {
        $email = "";
        $username = "testuser";
        $password = "testpassword";

        $user = new User($this->db);
        try {
            $result = $user->signup($email, $username, $password);
        } catch (Exception $e) {
            $this->assertEquals('Email, username, and password are required', $e->getMessage());
        }


        // Cleanup after test
        $sql = "DELETE FROM User WHERE email = '{$email}'";
        $this->db->query($sql);
    }

    public function testSignupWithEmptyUsername()
    {
        $email = "testuser@gmail.com";
        $username = "";
        $password = "testpassword";


        $user = new User($this->db);
        try {
            $result = $user->signup($email, $username, $password);
        } catch (Exception $e) {
            $this->assertEquals('Email, username, and password are required', $e->getMessage());

        }


        // Cleanup after test
        $sql = "DELETE FROM User WHERE email = '{$email}'";
        $this->db->query($sql);
    }

    public function testSignupWithEmptyPassword()
    {
        $email = "testuser@gmail.com";
        $username = "testuser";
        $password = "";

        $user = new User($this->db);
        try {
            $result = $user->signup($email, $username, $password);
        } catch (Exception $e) {
            $this->assertEquals('Email, username, and password are required', $e->getMessage());
        }

        // Cleanup after test
        $sql = "DELETE FROM User WHERE email = '{$email}'";
        $this->db->query($sql);
    }

    public function testSignupWithEmailContainingWhitespace()
    {
        $email = "testus er@gmail.com";
        $username = "testuser";
        $password = "testpassword";

        $user = new User($this->db);
        try {
            $result = $user->signup($email, $username, $password);
        } catch (Exception $e) {
            $this->assertEquals('Invalid email format', $e->getMessage());
        }

        // Cleanup after test
        $sql = "DELETE FROM User WHERE email = '{$email}'";
        $this->db->query($sql);
    }

    public function testSignupWithEmailDomain()
    {
        $validEmails = ["testuser@gmail.com", "testuser@st.phenikaa-uni.edu.vn"];
        $username = "testuser";
        $password = "testpassword";

        $user = new User($this->db);

        foreach ($validEmails as $email) {
            try {
                $result = $user->signup($email, $username, $password);
                $this->assertTrue($result, "Signup should succeed with valid email domain");
            } catch (Exception $e) {
                $this->fail("Signup should not throw exception with valid email domain");
            }

            // Cleanup after test
            $sql = "DELETE FROM User WHERE email = '{$email}'";
            $this->db->query($sql);
        }
    }

    public function testSignupWithEmailContainingSpecialCharacters()
    {
        $email = "testuser!#$%&'*+-/=?^_`{|}~@gmail.com";
        $username = "testuser";
        $password = "testpassword";

        $user = new User($this->db);
        try {
            $result = $user->signup($email, $username, $password);
            $this->fail("Invalid email format");
        } catch (Exception $e) {
            $this->assertEquals('Invalid email format', $e->getMessage());
        }

        // Cleanup after test
        $sql = "DELETE FROM User WHERE email = " . $this->db->quote($email);
        $this->db->query($sql);
    }
 
}