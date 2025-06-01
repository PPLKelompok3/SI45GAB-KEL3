<?php

use Laravel\Dusk\Browser;

test('Publish Artikel', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->click('@login-button')
                ->screenshot("loginpage")
                ->type('email', 'admin@workora.com')
                ->type('password','12345678')
                ->press('@LoginButton')
                ->assertSee('Workora')
                ->screenshot('after-login-admin')
                ->assertSee('Admin Dashboard')
                ->clickLink('Admin Dashboard')
                ->assertSee('Articles')
                ->click('.menu-link.menu-toggle')
                ->pause(500)    
                ->clickLink('Create New articles')
                ->assertSee('Create New articles')
                ->type('title', 'Improving Machine Lerning Model')
                ->type('skills', 'SQL')
                ->type('content', 'This article about machine learning.')
                ->press('Publish Article')
                ->assertSee('This article about machine learning')     
                ->screenshot('publish-article-success')

                ;
    });
})->group('Artikel');

