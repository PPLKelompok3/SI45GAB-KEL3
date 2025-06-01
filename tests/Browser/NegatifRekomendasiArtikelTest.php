<?php

use Laravel\Dusk\Browser;

test('Artikel Tidak Sesuai Tag', function () {
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
                ->pause(3000)  
                ->assertSee('Recommended')
                ->assertDontSee('machine learning') // tidak menampilkan artikel yang tidak sesuai dengan skill tag laravel
                ->screenshot('article-tidak sesuai tag-success')
                ;
    });
})->group('Artikel');


