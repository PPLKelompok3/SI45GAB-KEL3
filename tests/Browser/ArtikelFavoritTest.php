<?php

use Laravel\Dusk\Browser;

test('Artikel Favorit', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->click('@login-button')
                ->screenshot("loginpage")
                ->type('email', 'applicant10@gmail.com')
                ->type('password', '12345678')
                ->press('@LoginButton')
                ->assertSee('Workora') // Pastikan sudah login sukses
                ->visit('/articles/6')
                ->assertSee('Save to Favorites') // Tombol awalnya "Save to Favorites" (jika belum favorit)
                ->press('button.btn-outline-light') // Tekan tombol favorit (form submit)
                ->pause(1000) 
                ->assertSee('Remove from Favorites') // Tombol berubah menjadi "Remove from Favorites"
                ->press('button.btn-outline-light')
                ->pause(1000)
                ->assertSee('Save to Favorites');
                ;
    });
})->group('Artikel');

