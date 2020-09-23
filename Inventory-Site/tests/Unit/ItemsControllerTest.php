<?php

namespace Tests\Unit;

use App\Http\Controllers\ItemsController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ItemsControllerTest extends TestCase
{
    // By using this, we will rollback the db transaction to avoid polluting the db with test cases
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * Testing the store function in the ItemsController. Need to validate that it does actually update the
     * database.
     */
    public function testStore()
    {
        // Test a good request
        $this->withoutMiddleware();
        $response = $this->json('POST', 'items',
            [
                [
                    'name' => 'Yeeterinos',
                    'capacity' => '420',
                    'low_threshold' => '42',
                    'is_food' => 'true',
                    'refrigerated' => 'false'
                ],
                [
                    'name' => 'Yeeteronis',
                    'capacity' => '420',
                    'low_threshold' => '42',
                    'is_food' => 'true',
                    'refrigerated' => 'true'
                ],
                [
                    'name' => 'Yeet Street',
                    'capacity' => '420',
                    'low_threshold' => '42',
                    'is_food' => 'false',
                    'refrigerated' => 'false'
                ]
            ]);
        // evaluate
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'item created',
                'item_count' => '3'
            ]);

        // test a bad request
        $this->withoutMiddleware();
        $response = $this->json('POST', 'items',
            [
                [
                    'name' => 'Hee Hees',
                    'capacity' => '420',
                    'low_threshold' => '42',
                    'is_food' => 'true',
                    'refrigerated' => 'false'
                ],
                [
                    'name' => 'Bad Guys',
                    'capacity' => '420',
                    'low_threshold' => '42',
                    'is_food' => 'true',
                ]
            ]);
        // evaluate
        $response
            ->assertStatus(500)
            ->assertJson([
                'message' => 'Undefined index: refrigerated'
            ]);
    }

    public function testUpdate()
    {
        $this->withoutMiddleware();

        // Create some items in the db
        $response = $this->json('POST', 'items',
            [
                [
                    'name' => 'Yeeterinos',
                    'capacity' => '420',
                    'low_threshold' => '42',
                    'is_food' => 'true',
                    'refrigerated' => 'false'
                ],
                [
                    'name' => 'Yeeteronis',
                    'capacity' => '420',
                    'low_threshold' => '42',
                    'is_food' => 'true',
                    'refrigerated' => 'true'
                ],
                [
                    'name' => 'Yeet Street',
                    'capacity' => '420',
                    'low_threshold' => '42',
                    'is_food' => 'false',
                    'refrigerated' => 'false'
                ]
            ]);

        // Test just modifying the item
        $response = $this->json('PUT', 'items/1',
            [
                [
                    'id' => '1',
                    'name' => 'Yeeterinos',
                    'capacity' => '100',
                    'low_threshold' => '10',
                    'is_food' => 'false',
                    'refrigerated' => 'false',
                    'removed' => 'false'
                ],
                [
                    'id' => '2',
                    'name' => 'Yeeteronis',
                    'capacity' => '420',
                    'low_threshold' => '42',
                    'is_food' => 'true',
                    'refrigerated' => 'true',
                    'removed' => 'false'
                ],
                [
                    'id' => '3',
                    'name' => 'Yeet Street',
                    'capacity' => '420',
                    'low_threshold' => '42',
                    'is_food' => 'false',
                    'refrigerated' => 'false',
                    'removed' => 'true'
                ]
            ]);
        // evaluate
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'item(s) modified',
                'items_modified' => '3',
                'items_deleted' => '1'
            ]);

//        // Test Removing an item by setting the removed field to True
//        $response = $this->json('PUT', 'items/1',
//            ['name' => 'Yeeterinos',
//                'capacity' => '420',
//                'low_threshold' => '42',
//                'is_food' => 'true',
//                'refrigerated' => 'true',
//                'removed' => 'true'
//            ]);
//        // evaluate
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'status' => 'item removed',
//                'item_id' => '1',
//                'item_name' => 'Yeeterinos',
//                'item_removed' => 'true'
//            ]);
//
//        // test a bad request
//        $this->withoutMiddleware();
//        $response = $this->json('PUT', 'items/1',
//            ['name' => 'Yeeterinos',
//                'capacity' => '420',
//                'is_food' => 'true',
//            ]);
//        // evaluate
//        $response
//            ->assertStatus(422)
//            ->assertJson([
//                'message' => 'The given data was invalid.',
//                'errors' => [
//                    'low_threshold' => ['The low_threshold field is required.']
//                ]
//            ]);
    }

//    public function testCreate()
//    {
//        //
//    }
//
//    public function testShow()
//    {
////        $response = $this->json('GET', 'items/1');
////
////        echo ($response.$this->toString());
//
//
//    }
//
//    public function testEdit()
//    {
//        //
//    }
//
//    public function testIndex()
//    {
//        //
//    }
//
//    public function testDestroy()
//    {
//        //
//    }
}
