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
class ModifyItemTest extends DuskTestCase
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
                   ->assertSee('Add New Items')
                   ->press('#addItemButton')
                   ->waitForText('Add New Item')
                   ->type('#itemName', 'duskFoodItem&Refrigeration')
                   ->type('#capacity', 10)
                   ->type('#threshold', 50)
                   ->check('#foodItem')
                   ->check('#refrigeration')
                   ->press('submitModal')
                   ->pause('2000') //pause/wait for 1000ms for the modal to disappear
                   ->press('submitItem')
                   ->waitForText('Confirmation')
                   ->press('saveChanges')
                   ->waitForText('successfully created');
       });
   }
   //Modify inventory for the first item
   public function testModifyInventory()
   {
       $this->browse(function ($browser) {
           $browser->visit('/modify_items')
                   ->assertSee('Modify Items')
                   ->press('#item-0')
                   ->type('#itemName', 'testRename')
                   ->type('#capacity', 10)
                   ->type('#threshold', 100)
                   ->check('#foodItem')
                   ->check('#refrigeration')
                   ->check('#delete')
                   ->press('submitItem')
                   //wait for confirmation modal
                   ->waitForText('Confirmation')
                   ->assertSee('testRename')
                   ->assertSee('10')
                   ->assertSee('100')
                   ->press('saveChanges')
                   ->waitForText('successfully modified.');
       });
   }
}
