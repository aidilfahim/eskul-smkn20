<?php

test('email password reset routes are unavailable', function () {
    $this->get('/forgot-password')->assertNotFound();
    $this->post('/forgot-password')->assertNotFound();
    $this->get('/reset-password/test-token')->assertNotFound();
    $this->post('/reset-password')->assertNotFound();
});

test('login screen tells students to contact an admin for password resets', function () {
    $this->get('/login')
        ->assertOk()
        ->assertSee('Lupa password?')
        ->assertSee('Hubungi admin sekolah')
        ->assertSee('https://wa.me/6289509921469', false)
        ->assertDontSee('password.request');
});
