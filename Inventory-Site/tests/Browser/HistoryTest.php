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
class HistoryTest extends DuskTestCase
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
    //Test out the dropdown menus and ensure table exists
    public function testTable()
    {
        $this->browse(function ($browser) {
            $browser->visit('/history')
                    ->click('#inventoryDropdown')
                    ->click('#inventory-1')
                    ->select('#ascendingOrDescendingDropdown')
                    ->select('#addOrRemoveDropdown')
                    ->press('submit')
                    ->with('@transactionTable', function ($table) {
                        $table->assertSee('Item')
                              ->assertSee('Change')
                              ->assertSee('User')
                              ->assertSee('Comment');
                    });
        });
    }
}
