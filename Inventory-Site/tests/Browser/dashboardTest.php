<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Facebook\WebDriver\WebDriverBy;

/**
* Put in group 'site'
*
* @group site
*/
class DashboardTest extends DuskTestCase
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
    public function testCharts()
    {
        $this->browse(function ($browser) {
            $browser->visit('/dashboard')
                    ->assertVisible('#lowInventory')
                    ->assertVisible('#inventoryChart')
                    ->assertVisible('#recentInventory')
                    ->assertVisible('#viewSelect')
                    ->assertVisible('#monthlyChart')
                    ->assertVisible('#capacityChart');
        });
    }
    public function testFormSubmit()
    {
      $this->browse(function ($browser) {
          $url = $browser->driver->getCurrentURL();
          $browser->visit('/dashboard')
                  ->check('totalInventory')
                  ->press('submitButton')
                  ->assertUrlIs($url);
      });
    }
}
