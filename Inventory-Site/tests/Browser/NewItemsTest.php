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
class NewItemsTest extends DuskTestCase
{

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
                    ->pause('1000')
                    ->press('submitItem')
                    ->waitForText('Confirmation')
                    ->press('saveChanges')
                    ->waitForText('successfully created');
        });
    }
    public function testAddNewItem1()
    {
        $this->browse(function ($browser) {
            $browser->visit('/new_items')
                    ->assertSee('Add New Items')
                    ->press('#addItemButton')
                    ->waitForText('Add New Item')
                    ->type('#itemName', 'duskFoodItem')
                    ->type('#capacity', 10)
                    ->type('#threshold', 50)
                    ->check('#foodItem')
                    ->press('submitModal')
                    ->pause('1000')
                    ->press('submitItem')
                    ->waitForText('Confirmation')
                    ->press('saveChanges')
                    ->waitForText('successfully created');
        });
    }
    public function testAddNewItem2()
    {
        $this->browse(function ($browser) {
            $browser->visit('/new_items')
                    ->assertSee('Add New Items')
                    ->press('#addItemButton')
                    ->waitForText('Add New Item')
                    ->type('#itemName', 'duskRefrigeration')
                    ->type('#capacity', 10)
                    ->type('#threshold', 50)
                    ->check('#refrigeration')
                    ->press('submitModal')
                    ->pause('1000')
                    ->press('submitItem')
                    ->waitForText('Confirmation')
                    ->press('saveChanges')
                    ->waitForText('successfully created');

        });
    }
}
