<?php

namespace Tests\Unit;

use App\Http\Controllers\UsersController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Allows us to test whether we can change this like the user's email address, phone number, or whether
     * they are a past or current member.
     */
    public function testSettingCurrentUser()
    {
        $this->seed();

        $this->withoutMiddleware();
        $response = $this->json('PUT', 'users/1',
            [
                'email' => 'biggerboss@metallergear.com',
                'phone' => '0987654321',
                'current_member' => 'true',
                'position_id' => '7'
            ]);

        // evaluate
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'User Info Modification Succeeded',
                'user_email' => 'biggerboss@metallergear.com',
                'user_phone' => '0987654321',
                'user_current_member' =>  'true',
                'user_position_id' => '7'], 200)
            ->header('Content-Type', 'text/plain');

        $this->assertDatabaseHas('users', [
            'id' => 1,
            'email' => 'biggerboss@metallergear.com',
            'phone' => '0987654321',
            'current_member' => 'true',
            'position_id' => '7'
        ]);
    }

    /**
     * Allows us to test to make sure that we can specify if the user is no longer a member of this
     * organization.
     */
    public function testMakingUserNotCurrent()
    {
        $this->seed();

        $this->withoutMiddleware();
        $response = $this->json('PUT', 'users/1',
            [
                'email' => 'biggerboss@metallergear.com',
                'phone' => '0987654321',
                'current_member' => 'true',
                'position_id' => '7'
            ]);

        // evaluate
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'User Info Modification Succeeded',
                'user_email' => 'biggerboss@metallergear.com',
                'user_phone' => '0987654321',
                'user_current_member' =>  'true',
                'user_position_id' => '7'], 200)
            ->header('Content-Type', 'text/plain');

        $this->assertDatabaseHas('users', [
            'id' => 1,
            'email' => 'biggerboss@metallergear.com',
            'phone' => '0987654321',
            'current_member' => 'true',
            'position_id' => '7'
        ]);
    }

    /**
     * Tests if the destroy function actually deletes the user from the database. Should only be called
     * when a user gets rejected in the admin panel. Deletes the user ID 1.
     */
    public function testDestroy()
    {
        $this->seed();

        $this->withoutMiddleware();
        $response = $this->json('DELETE', 'users/1');

        $this->assertDatabaseMissing('users', [
            'id' => 1
        ]);
    }
}
