<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI10Test extends DuskTestCase
{
    /**
     * @group PBI10
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000/')
                    ->assertSee('Find the perfect job that matches your skills and passion. Choose the position you desire and get the best opportunities!')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->assertSee('Please sign-in to your account to continue')
                    ->type('email', 'nuel@example.com')
                    ->type('password', '12345678')
                    ->press('Login')
                    ->assertSee('Post a Job')
                    ->clickLink('Dashboard')
                    ->assertPathIs('/dashboard')
                    ->assertSee('Total Applicants')
                    ->pause(1000)
                    ->screenshot('PBI10Test');
        });
    }
}
