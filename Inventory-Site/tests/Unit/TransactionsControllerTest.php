<?php

namespace Tests\Unit;

use App\Http\Controllers\TransactionsController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class TransactionsControllerTest extends TestCase
{
   use RefreshDatabase;

    /**
     * Shouldn't need a test for editing transactions
     */
//    public function testEdit()
//    {}

    /** Shouldn't need a test for destroy since transactions should be immutable. */
//    public function testDestroy()
//    {}

//    public function testIndex()
//    {}

//    public function testCreate()
//    {}

    /**
     * Test to show that we can store new transactions for items.
     */
    public function testStore()
    {
        $this->seed();
        // Test a good request
        $this->withoutMiddleware();
        $response = $this->json('POST', 'transactions',
            [
                [
                    'item_id' => '1',
                    'user_id' => '2',
                    'quantity_change' => '10',
                    'comment' => 'Yeety Meet'
                ],
                [
                    'item_id' => '1',
                    'user_id' => '2',
                    'quantity_change' => '100',
                    'comment' => 'Add me some of that.'
                ],
                [
                    'item_id' => '1',
                    'user_id' => '2',
                    'quantity_change' => '-20',
                    'comment' => 'Subtract me some'
                ]
            ]);
        // evaluate
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'transaction(s) stored',
                'transactions_count' => '3'
            ]);

        $this->assertDatabaseHas('Order_Transaction', [
            'item_id' => 1,
            'member_id' => 2,
            'item_quantity_change' => -20,
            'comment' => 'Subtract me some'
        ]);
    }

    /**
     * Tests if there is a 422 error thrown for bad store requests
     */
    public function testBadStore()
    {
        $this->seed();
        // test a bad request
        $this->withoutMiddleware();
        $response = $this->json('POST', 'transactions',
            [
                [
                    'item_id' => '1',
                    'quantity_change' => '10',
                    'comment' => 'Yeet'
                ]
            ]);
        // evaluate
        $response
            ->assertStatus(500)
            ->assertJson([
                'message' => 'Undefined index: user_id',
            ]);
    }

    /**
     * Test to show that we can store new transactions for items but that having comments for the
     * transaction is optional.
     */
    public function testStoreWithoutComment()
    {
        $this->seed();
        // Test a good request without the transaction comment
        $this->withoutMiddleware();
        $response = $this->json('POST', 'transactions',
            [
                [
                    'item_id' => '1',
                    'user_id' => '2',
                    'quantity_change' => '10',
                ]
            ]);
        // evaluate
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'transaction(s) stored',
                'transactions_count' => '1'
            ]);
    }

    public function testUpdateQuantity()
    {
        $this->seed();
        // Test a good request
        $this->withoutMiddleware();
        $response = $this->json('POST', 'transactions',
            [
                [
                    'item_id' => '1',
                    'user_id' => '2',
                    'quantity_change' => '10',
                    'comment' => 'Yeety Meet'
                ],
                [
                    'item_id' => '1',
                    'user_id' => '2',
                    'quantity_change' => '100',
                    'comment' => 'Add me some of that.'
                ],
                [
                    'item_id' => '1',
                    'user_id' => '2',
                    'quantity_change' => '-20',
                    'comment' => 'Subtract me some'
                ]
            ]);
        // evaluate
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'transaction(s) stored',
                'transactions_count' => '3'
            ]);

        $this->assertDatabaseHas('Item', [
            'id' => 1,
            'quantity' => 228
        ]);
    }
}
