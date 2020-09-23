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
class LoginTest extends DuskTestCase
{
    //Create dummy accounts for testing
    public function testMakeAccounts()
    {
        $this->browse(function ($first, $second, $third, $fourth, $fifth, $sixth, $seventh, $eigth) {
            $first->visit('/register')
                    //ensure correct fields
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Phone')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password') 
                    //looks for the name tag in register.blade.php. ex: <... name='name' ...> 
                    ->type('name', 'John Smith')
                    ->type('email', 'johnsmith@aol.com')
                    ->type('phone', '3143563412')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Register')
                    ->assertSee('Login');
            $second->visit('/register')
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Phone')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password')
                    ->type('name', 'John Apple')
                    ->type('email', 'johnapple@aol.com')
                    ->type('phone', '3143563413')
                    ->type('password', 'password1')
                    ->type('password_confirmation', 'password1')
                    ->press('Register')
                    ->assertSee('Login');
            $third->visit('/register')
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Phone')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password')
                    ->type('name', 'John Bpple')
                    ->type('email', 'johnbpple@aol.com')
                    ->type('phone', '3143563414')
                    ->type('password', 'password2')
                    ->type('password_confirmation', 'password2')
                    ->press('Register')
                    ->assertSee('Login');
            $fourth->visit('/register')
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Phone')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password')
                    ->type('name', 'John Cpple')
                    ->type('email', 'johncpple@aol.com')
                    ->type('phone', '3143563415')
                    ->type('password', 'password3')
                    ->type('password_confirmation', 'password3')
                    ->press('Register')
                    ->assertSee('Login');
            $fifth->visit('/register')
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Phone')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password')
                    ->type('name', 'John Dpple')
                    ->type('email', 'johndpple@aol.com')
                    ->type('phone', '3143563416')
                    ->type('password', 'password4')
                    ->type('password_confirmation', 'password4')
                    ->press('Register')
                    ->assertSee('Login');
            $sixth->visit('/register')
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Phone')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password')
                    ->type('name', 'John Epple')
                    ->type('email', 'johnepple@aol.com')
                    ->type('phone', '3143563417')
                    ->type('password', 'password5')
                    ->type('password_confirmation', 'password5')
                    ->press('Register')
                    ->assertSee('Login');
            $seventh->visit('/register')
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Phone')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password')
                    ->type('name', 'John Fpple')
                    ->type('email', 'johnfpple@aol.com')
                    ->type('phone', '3143563418')
                    ->type('password', 'password6')
                    ->type('password_confirmation', 'password6')
                    ->press('Register')
                    ->assertSee('Login');
            $eigth->visit('/register')
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Phone')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password')
                    ->type('name', 'John Gpple')
                    ->type('email', 'johngpple@aol.com')
                    ->type('phone', '3143563419')
                    ->type('password', 'password7')
                    ->type('password_confirmation', 'password7')
                    ->press('Register')
                    ->assertSee('Login');
        });
    }
    //verify account access to registered accounts
    public function testVerifyAccounts0()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->type('email', 'johnsmith@aol.com')
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertSee('Login');
        });
    }
    public function testVerifyAccounts1()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Password')
                    ->type('email', 'johnapple@aol.com')
                    ->type('password', 'password1')
                    ->press('Login')
                    ->assertSee('Login');
        });
    }
    //verify incorrect credentials
    public function testVerifyAccounts2()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->type('email', 'johnsmith@aol.com')
                    ->type('password', 'wrongpassword')
                    ->press('Login')
                    ->assertSee('These credentials do not match our records.');
        });
    }
    public function testVerifyAccounts3()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->type('email', 'wrongjohnsmith@aol.com')
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertSee('These credentials do not match our records.');
        });
    }
    //verify access is not given without form inputs
    public function testVerifyAccounts4()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->press('Login')
                    ->AssertSee('Login');
        });
    }
    public function testVerifyAccounts5()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->type('password', 'password')
                    ->press('Login')
                    ->AssertSee('Login');
        });
    }
    
    public function testVerifyAccounts6()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->type('email', 'johnsmith@aol.com')
                    ->press('Login')
                    ->AssertSee('Login');
        });
    }
    //verify account access
    public function testVerifyAccounts7()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->type('email', 'johnbpple@aol.com')
                    ->type('password', 'password2')
                    ->press('Login')
                    ->assertSee('Login');
        });
    }       
}