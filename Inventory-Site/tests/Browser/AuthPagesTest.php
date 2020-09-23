<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Chrome;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
* Put in group 'site'
*
* @group site
*/
class ExampleTest extends DuskTestCase
{
    public function testLoginPage()
    {
        
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Password')
                    ->press('Login')
                    ->clickLink('Forgot Your Password?')
                    ->assertSee('Reset Password');
        });
    }
    
    public function testRegisterPage()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                    ->assertSee('Register')
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password')
                    ->press('Register')
                    ->assertSee('Register');
        });
    }

    public function testLoginAndRegister()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Password')
                    ->clickLink('Login')
                    ->assertSee('Login')
                    ->clickLink('Register')
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Phone')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password')
                    ->press('Register')
                    ->assertSee('Register')
                    ->clickLink('Login')
                    ->assertSee('Login')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Password');
        });
    }
    
}
