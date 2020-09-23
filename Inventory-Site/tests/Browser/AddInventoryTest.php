<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
* Put in group 'site'
*
* @group site
*/
class AddInventoryTest extends DuskTestCase
{
    //login to the website
    public function testLogin()
    {
        $this->browse(function ($browser) {
            //fill in the credentials and login to admin account
            $browser->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->type('email', '12thcanNoReply@gmail.com')
                    ->type('password', 'BigBoss12345')
                    ->press('Login')
                    ->assertSee('Low Inventory');
        });
    }
    //add an item to ensure one item exists
    public function testAddNewItem()
    {
        $this->browse(function ($browser) {
            $browser->visit('/new_items')
                    ->assertSee('Add Inventory')
                    ->press('#addItemButton')
                    ->waitForText('Add New Item')
                    ->type('#itemName', 'duskFoodItem&Refrigeration')
                    ->type('#capacity', 10)
                    ->type('#threshold', 50)
                    ->check('#foodItem')
                    ->check('#refrigeration')
                    ->press('submitModal')
                    ->pause('1000') //pause/wait for 1000ms for the modal to disappear
                    ->press('submitItem')
                    ->waitForText('Confirmation')
                    ->press('saveChanges')
                    ->waitForText('successfully created');
        });
    }
    //Add inventory for the first item
    public function testAddInventory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/add_inventory')
                    ->assertSee('Add Inventory')
                    ->press('#item-0')
                    ->type('quantity', 10)
                    ->type('comment', 'comment1')
                    ->press('submit')
                    ->waitForText('Confirmation')
                    ->press('saveChanges')
                    ->waitForText('Inventory was added');
        });
    }
}
