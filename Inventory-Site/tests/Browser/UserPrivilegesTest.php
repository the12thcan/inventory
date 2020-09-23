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
class UserPrivilegesTest extends DuskTestCase
{
    //create account p0
    public function testCreateAccount0()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                    //ensure correct fields
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Phone')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password') 
                    //looks for the name tag in register.blade.php. ex: <... name='name' ...> 
                    ->type('name', 'p0')
                    ->type('email', 'p0@dusk.com')
                    ->type('phone', '3143563272')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Register')
                    ->assertSee('Login');
            
            });
    }
    //create account p1
    public function testCreateAccount1()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                    //ensure correct fields
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Phone')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password') 
                    //looks for the name tag in register.blade.php. ex: <... name='name' ...> 
                    ->type('name', 'p1')
                    ->type('email', 'p1@dusk.com')
                    ->type('phone', '3153563412')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Register')
                    ->assertSee('Login');
            
            });
    }
    //create account p2
    public function testCreateAccount2()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                    //ensure correct fields
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Phone')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password') 
                    //looks for the name tag in register.blade.php. ex: <... name='name' ...> 
                    ->type('name', 'p2')
                    ->type('email', 'p2@dusk.com')
                    ->type('phone', '3143561412')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Register')
                    ->assertSee('Login');
            
            });
    }
    //create account p3
    public function testCreateAccount3()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                    //ensure correct fields
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Phone')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password') 
                    //looks for the name tag in register.blade.php. ex: <... name='name' ...> 
                    ->type('name', 'p3')
                    ->type('email', 'p3@dusk.com')
                    ->type('phone', '3143763412')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Register')
                    ->assertSee('Login');
            
            });
    }
    //Login with admin account to accept the previous created accounts
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
    //Check admin panel content
    public function testCheckAdminPanel()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin_panel')
                    ->assertSee('Admin Panel');   
        });
    }
    //Accept account p0
    public function testAcceptAccount0()
    {
        $this->browse(function ($browser) {
            $browser->press('@pendingAccountsAccept-p0')
                    ->waitForText('Accept Account')
                    ->press('acceptAccountSubmit')
                    ->waitForText('was successfully accepted')
                    ->with('@currentAccountsTable', function ($table) {
                        $table->assertSee('p0')
                              ->assertSee('p0@dusk.com');
            });
        });
    }
    //Accept account p1
    public function testAcceptAccount1()
    {
        $this->browse(function ($browser) {
            $browser->press('@pendingAccountsAccept-p1')
                    ->waitForText('Accept Account')
                    ->press('acceptAccountSubmit')
                    ->waitForText('was successfully accepted')
                    ->with('@currentAccountsTable', function ($table) {
                        $table->assertSee('p1')
                              ->assertSee('p1@dusk.com');
            });
        });
    }
    //Accept account p2
    public function testAcceptAccount2()
    {
        $this->browse(function ($browser) {
            $browser->press('@pendingAccountsAccept-p2')
                    ->waitForText('Accept Account')
                    ->press('acceptAccountSubmit')
                    ->waitForText('was successfully accepted')
                    ->with('@currentAccountsTable', function ($table) {
                        $table->assertSee('p2')
                              ->assertSee('p2@dusk.com');
            });
        });
    }
    //Accept account p3
    public function testAcceptAccount3()
    {
        $this->browse(function ($browser) {
            $browser->press('@pendingAccountsAccept-p3')
                    ->waitForText('Accept Account')
                    ->press('acceptAccountSubmit')
                    ->waitForText('was successfully accepted')
                    ->with('@currentAccountsTable', function ($table) {
                        $table->assertSee('p3')
                              ->assertSee('p3@dusk.com');
            });
        });
    }
    //Add position p0 with privilege 'Only Dashboard'
    public function testAddPosition0()
    {
        $this->browse(function ($browser) {
            $browser->press('addPosition')
                    ->waitForText('Modify Position')
                    ->type('position', 'p0')
                    ->type('positionEmail', 'p0@dusk.com')
                    ->type('description', 'duskduskduskdusk')
                    ->click('@positionPrivilegeDropdown')
                    ->click('#positionPrivilege-0')
                    ->press('modifyPositionSubmit')
                    ->waitForText('was successfully added.')
                    ->assertSee('Admin Panel');
        });
    }
    //Add position p1 with privilege 'Make changes to inventory'
    public function testAddPosition1()
    {
        $this->browse(function ($browser) {
            $browser->press('addPosition')
                    ->waitForText('Modify Position')
                    ->type('position', 'p1')
                    ->type('positionEmail', 'p1@dusk.com')
                    ->type('description', 'duskduskduskdusk')
                    ->click('@positionPrivilegeDropdown')
                    ->click('#positionPrivilege-1')
                    ->press('modifyPositionSubmit')
                    ->waitForText('was successfully added.')
                    ->assertSee('Admin Panel');
        });
    }
    //Add position p2 with privilege 'Admin Privileges'
    public function testAddPosition2()
    {
        $this->browse(function ($browser) {
            $browser->press('addPosition')
                    ->waitForText('Modify Position')
                    ->type('position', 'p2')
                    ->type('positionEmail', 'p2@dusk.com')
                    ->type('description', 'duskduskduskdusk')
                    ->click('@positionPrivilegeDropdown')
                    ->click('#positionPrivilege-2')
                    ->press('modifyPositionSubmit')
                    ->waitForText('was successfully added.')
                    ->assertSee('Admin Panel');
        });
    }
    //Add position p3 with privilege 'Big boi'
    public function testAddPosition3()
    {
        $this->browse(function ($browser) {
            $browser->press('addPosition')
                    ->waitForText('Modify Position')
                    ->type('position', 'p3')
                    ->type('positionEmail', 'p3@dusk.com')
                    ->type('description', 'duskduskduskdusk')
                    ->click('@positionPrivilegeDropdown')
                    ->click('#positionPrivilege-3')
                    ->press('modifyPositionSubmit')
                    ->waitForText('was successfully added.')
                    ->assertSee('Admin Panel');
        });
    }
    //Modify account p0 to have position p0 which has 'Only Dashboard' privilege
    public function testModifyCurrentAccountPrivilege0()
    {
        $this->browse(function ($browser) {
            $browser->press('@currentAccountsModify-p0')
                    ->waitForText('Modify Account')
                    ->click('#positionDropdown')
                    ->click('@position-p0')
                    ->press('modifyAccountSubmit')
                    ->waitForText('was successfully modified')
                    ->with('@currentAccountsTable', function ($table) {
                        $table->assertSee('p0');
            });
        });
    }
    //Modify account p1 to have position p1 which has 'Make change to inventory' privilege
    public function testModifyCurrentAccountPrivilege1()
    {
        $this->browse(function ($browser) {
            $browser->press('@currentAccountsModify-p1')
                    ->waitForText('Modify Account')
                    ->click('#positionDropdown')
                    ->click('@position-p1')
                    ->press('modifyAccountSubmit')
                    ->waitForText('was successfully modified')
                    ->with('@currentAccountsTable', function ($table) {
                        $table->assertSee('p0');
            });
        });
    }
    //Modify account p2 to have position p2 which has 'Admin Privilege' privilege
    public function testModifyCurrentAccountPrivilege2()
    {
        $this->browse(function ($browser) {
            $browser->press('@currentAccountsModify-p2')
                    ->waitForText('Modify Account')
                    ->click('#positionDropdown')
                    ->click('@position-p2')
                    ->press('modifyAccountSubmit')
                    ->waitForText('was successfully modified')
                    ->with('@currentAccountsTable', function ($table) {
                        $table->assertSee('p0');
            });
        });
    }
    //Modify account p3 to have position p3 which has 'Big boi' privilege
    public function testModifyCurrentAccountPrivilege3()
    {
        $this->browse(function ($browser) {
            $browser->press('@currentAccountsModify-p3')
                    ->waitForText('Modify Account')
                    ->click('#positionDropdown')
                    ->click('@position-p3')
                    ->press('modifyAccountSubmit')
                    ->waitForText('was successfully modified')
                    ->with('@currentAccountsTable', function ($table) {
                        $table->assertSee('p0');
            });
        });
    }
    //Ensure p0 can only view the dashboard no matter what he tries to access
    public function testSiteAccess0()
    {
        $this->browse(function ($browser) {
            $browser->click('#navbarDropdown')
                    ->click('#logout')
                    ->assertSee('Login')
                    ->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->type('email', 'p0@dusk.com')
                    ->type('password', 'password')
                    ->press('Login')
                    ->AssertSee('Low Inventory')
                    ->AssertSee('Recent Inventory')
                    ->press('hamburgerButton')
                    ->clickLink('Add Inventory')
                    ->assertSee('Low Inventory')
                    ->clickLink('Remove Inventory')
                    ->assertSee('Low Inventory')
                    ->clickLink('Add New Items')
                    ->assertSee('Low Inventory')
                    ->clickLink('Modify Items')
                    ->assertSee('Low Inventory')
                    ->clickLink('Dashboard')
                    ->AssertSee('Low Inventory')
                    ->AssertSee('Recent Inventory')
                    ->clickLink('History')
                    ->assertSee('Low Inventory')
                    ->visit('/admin_panel')
                    ->assertSee('Low Inventory');
        });
    }
    //Ensure account p1 has full site access except for Admin page
public function testSiteAccess1()
    {
        $this->browse(function ($browser) {
            $browser->click('#navbarDropdown')
                    ->click('#logout')
                    ->assertSee('Login')
                    ->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->type('email', 'p1@dusk.com')
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertSee('Low Inventory')
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
                    ->clickLink('History')
                    ->visit('/admin_panel')
                    ->assertSee('Low Inventory');
        });
    }
    //Ensure account p2 has full site access even with admin page
public function testSiteAccess2()
    {
        $this->browse(function ($browser) {
            $browser->click('#navbarDropdown')
                    ->click('#logout')
                    ->assertSee('Login')
                    ->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->type('email', 'p2@dusk.com')
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertSee('Low Inventory')
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
                    ->clickLink('History')
                    ->assertSee('History')
                    ->visit('/admin_panel')
                    ->assertSee('Admin Panel');
        });
    }
    //Ensure account p3 has full site access even with admin page.
    public function testSiteAccess3()
    {
        $this->browse(function ($browser) {
            $browser->click('#navbarDropdown')
                    ->click('#logout')
                    ->assertSee('Login')
                    ->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->type('email', 'p3@dusk.com')
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertSee('Low Inventory')
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
                    ->clickLink('History')
                    ->assertSee('History')
                    ->visit('/admin_panel')
                    ->assertSee('Admin Panel');
        });
    }
}
