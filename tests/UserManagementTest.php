<?php

namespace App\Tests;

use App\UserManagement;
use App\Database;
use PHPUnit\Framework\TestCase;

class UserManagementTest extends TestCase
{
    private $user;
    private $pdo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pdo = Database::getConnection();
        $this->user = new UserManagement($this->pdo);
    }


    protected function tearDown(): void
    {
        // Clean up any test data after each test
        // This ensures that each test is isolated from others
        $this->pdo->exec('DELETE FROM tbl_users');
        parent::tearDown();
    }

    public function testCreate()
    {
        // Arrange
        $testData = [
            'email' => uniqid().'@example.com', // Unique email
            'password' => 'password123',
            'username' => 'TestUser'.uniqid() // Unique username
        ];

        // Act
        $result = $this->user->create($testData);

        // Assert
        $this->assertTrue($result, 'Failed to add user');
    }

    public function testRead()
    {
        // Arrange
        $this->testCreate(); // Create a user for testing

        // Act
        $result = $this->user->read(perPage: 1);

        // Assert
        $users = $result['users'];
        $this->assertNotEmpty($users, 'No users found');
        $user = end($users); // Get the last user
        $this->assertStringStartsWith('TestUser', $user['username'], 'User name does not match');
    }

    public function testUpdate()
    {
        // Arrange
        $this->testCreate(); // Create a user for testing
        $user = $this->user->read(perPage: 1)['users'][0];

        // Act
        $this->user->update($user['id'], ['email' => 'testup@example.com', 'username' => 'UpdatedTestUser'.uniqid()]);
        $updatedUser = $this->user->read(['email' => 'testup@example.com'])['users'][0];

        // Assert
        $this->assertStringStartsWith('UpdatedTestUser', $updatedUser['username']);
    }

    public function testDelete()
    {
        // Arrange
        $this->testCreate(); // Create a user for testing
        $user = $this->user->read(perPage: 1)['users'][0];

        // Act
        $result = $this->user->delete($user['id']);

        // Assert
        $this->assertTrue($result, 'Failed to delete user');
    }
}
