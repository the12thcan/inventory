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
class SidebarTest extends DuskTestCase
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
    public function testSidebarAddInventory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/add_inventory')
                    ->press('hamburgerButton')
                    ->assertSee('Add Inventory')
                    ->assertSee('Remove Inventory')
                    ->assertSee('Add New Items')
                    ->assertSee('Modify Items')
                    ->assertSee('Dashboard')
                    ->assertSee('History')
                    ->clickLink('Add Inventory')
                    ->assertSee('Add Inventory')
                    ->clickLink('Remove Inventory')
                    ->assertSee('Remove Inventory')
                    ->clickLink('Add New Items')
                    ->assertSee('Add New Items')
                    ->clickLink('Modify Items')
                    ->assertSee('Modify Items')
                    ->clickLink('Dashboard')
                    ->AssertSee('Low Inventory')
                    ->AssertSee('Recent Inventory')
                    ->clickLink('History');
        });
    }
    public function testSidebarRemoveInventory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/remove_inventory')
                    ->press('hamburgerButton')
                    ->assertSee('Add Inventory')
                    ->assertSee('Remove Inventory')
                    ->assertSee('Add New Items')
                    ->assertSee('Modify Items')
                    ->assertSee('Dashboard')
                    ->assertSee('History')
                    ->clickLink('Add Inventory')
                    ->assertSee('Add Inventory')
                    ->clickLink('Remove Inventory')
                    ->assertSee('Remove Inventory')
                    ->clickLink('Add New Items')
                    ->assertSee('Add New Items')
                    ->clickLink('Modify Items')
                    ->assertSee('Modify Items')
                    ->clickLink('Dashboard')
                    ->AssertSee('Low Inventory')
                    ->AssertSee('Recent Inventory')
                    ->clickLink('History');
        });
    }
    public function testSidebarAddNewInventory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/new_items')
                    ->press('hamburgerButton')
                    ->assertSee('Add Inventory')
                    ->assertSee('Remove Inventory')
                    ->assertSee('Add New Items')
                    ->assertSee('Modify Items')
                    ->assertSee('Dashboard')
                    ->assertSee('History')
                    ->clickLink('Add Inventory')
                    ->assertSee('Add Inventory')
                    ->clickLink('Remove Inventory')
                    ->assertSee('Remove Inventory')
                    ->clickLink('Add New Items')
                    ->assertSee('Add New Items')
                    ->clickLink('Modify Items')
                    ->assertSee('Modify Items')
                    ->clickLink('Dashboard')
                    ->AssertSee('Low Inventory')
                    ->AssertSee('Recent Inventory')
                    ->clickLink('History');
        });
    }
    public function testSidebarModifyItems()
    {
        $this->browse(function ($browser) {
            $browser->visit('/modify_items')
                    ->press('hamburgerButton')
                    ->assertSee('Add Inventory')
                    ->assertSee('Remove Inventory')
                    ->assertSee('Add New Items')
                    ->assertSee('Modify Items')
                    ->assertSee('Dashboard')
                    ->assertSee('History')
                    ->clickLink('Add Inventory')
                    ->assertSee('Add Inventory')
                    ->clickLink('Remove Inventory')
                    ->assertSee('Remove Inventory')
                    ->clickLink('Add New Items')
                    ->assertSee('Add New Items')
                    ->clickLink('Modify Items')
                    ->assertSee('Modify Items')
                    ->clickLink('Dashboard')
                    ->AssertSee('Low Inventory')
                    ->AssertSee('Recent Inventory')
                    ->clickLink('History');
        });
    }
    public function testSidebarDashboard()
    {
        $this->browse(function ($browser) {
            $browser->visit('/dashboard')
                    ->press('hamburgerButton')
                    ->assertSee('Add Inventory')
                    ->assertSee('Remove Inventory')
                    ->assertSee('Add New Items')
                    ->assertSee('Modify Items')
                    ->assertSee('Dashboard')
                    ->assertSee('History')
                    ->clickLink('Add Inventory')
                    ->assertSee('Add Inventory')
                    ->clickLink('Remove Inventory')
                    ->assertSee('Remove Inventory')
                    ->clickLink('Add New Items')
                    ->assertSee('Add New Items')
                    ->clickLink('Modify Items')
                    ->assertSee('Modify Items')
                    ->clickLink('Dashboard')
                    ->AssertSee('Low Inventory')
                    ->AssertSee('Recent Inventory')
                    ->clickLink('History');
        });
    }
    public function testSidebarHistory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/history')
                    ->press('hamburgerButton')
                    ->assertSee('Add Inventory')
                    ->assertSee('Remove Inventory')
                    ->assertSee('Add New Items')
                    ->assertSee('Modify Items')
                    ->assertSee('Dashboard')
                    ->assertSee('History')
                    ->clickLink('Add Inventory')
                    ->assertSee('Add Inventory')
                    ->clickLink('Remove Inventory')
                    ->assertSee('Remove Inventory')
                    ->clickLink('Add New Items')
                    ->assertSee('Add New Items')
                    ->clickLink('Modify Items')
                    ->assertSee('Modify Items')
                    ->clickLink('Dashboard')
                    ->AssertSee('Low Inventory')
                    ->AssertSee('Recent Inventory')
                    ->clickLink('History');
        });
    }
}
