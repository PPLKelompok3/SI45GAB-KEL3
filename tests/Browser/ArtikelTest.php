<?php

use Laravel\Dusk\Browser;

test('Artikel Rekomendasi', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->click('@login-button')
                ->screenshot("loginpage")
                ->type('email', 'applicant10@gmail.com')
                ->type('password','12345678')
                ->press('@LoginButton')
                ->assertSee('Workora')
                ->assertSee('Laravel') // memiliki skill tag laravel
                ->screenshot('after-login')
                ->assertSee('Articles')
                ->clickLink('Articles') 
                ->assertSee('Recommended')
                ->assertSee('laravel') // menampilkan artikel dengan skill tag laravel
                ->screenshot('article-recommendation-success')


                ;
    });
})->group('Artikel');


