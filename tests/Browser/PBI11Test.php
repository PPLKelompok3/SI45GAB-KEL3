<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI11Test extends DuskTestCase
{
    /**
     * @group PBI11
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
                    ->clickLink('Notifications')
                    ->assertPathIs('/recruiter/notifications')
                    ->assertSee('new_application')
                    ->pause(1500)
                    ->screenshot('PBI11Test');
        });
    }
}
