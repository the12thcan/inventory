<?php

namespace Tests\Unit;

use App\Http\Controllers\MemberPositionsController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class MemberPositionsControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Allows us to test whether or not the user will be able to modify the user position after it
     * has been created.
     */
    public function testUpdate()
    {
        $this->seed();

        // Test a good request
        $this->withoutMiddleware();
        $response = $this->json('PUT', 'member_position/7',
            [
                'position' => 'Biggest Boss',
                'privilege' => '3',
                'description' => 'Is the biggest boss that can ever exist ever.',
                'email' => 'biggest.boss@ever.com',
                'low_notify' => true
            ]);
        // evaluate
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'position modification succeeded',
                'position' => 'Biggest Boss',
                'position_privilege' => '3',
                'position_email' =>  'biggest.boss@ever.com'
            ]);

        $this->assertDatabaseHas('Member_Position', [
            'id' => 7,
            'position' => 'Biggest Boss',
            'privilege' => 3,
            'description' => 'Is the biggest boss that can ever exist ever.',
            'email' => 'biggest.boss@ever.com',
            'low_notify' => true
        ]);
    }

    public function testDestroy()
    {
        $this->seed();

        // Delete the Big Boss member position
        $this->withoutMiddleware();
        $response = $this->json('DELETE', 'member_position/7');

        $response
            ->assertStatus(200)
            ->assertJson([
            'status' => 'position deleted',
            'position_deleted' => '7'
        ]);

        // Check to make sure that the Big Boss position is gone.
        $this->assertDatabaseMissing('Member_Position',
            [
                'id' => 7,
            ]);
    }

    /**
     * Tests the store function so we can see if our function properly adds new member positions to
     * the Member_Position table in the database.
     */
    public function testGoodStore()
    {
        $this->seed();

        // Test a good request
        $this->withoutMiddleware();
        $response = $this->json('POST', 'member_position',
            [
                'position' => 'Biggest Boss',
                'privilege' => '3',
                'description' => 'Is the biggest boss that can ever exist ever.',
                'email' => 'biggest.boss@ever.com',
                'low_notify' => true
            ]);
        // evaluate
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'position creation succeeded',
                'position' => 'Biggest Boss',
                'position_privilege' => '3',
                'position_email' =>  'biggest.boss@ever.com'
            ]);

        $this->assertDatabaseHas('Member_Position', [
            'position' => 'Biggest Boss',
            'privilege' => 3,
            'description' => 'Is the biggest boss that can ever exist ever.',
            'email' => 'biggest.boss@ever.com',
            'low_notify' => true
        ]);
    }
}
