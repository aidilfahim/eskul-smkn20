<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertOk()
        ->assertSee('@smkn20.com');
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@smkn20.com',
        'password' => '12345',
        'password_confirmation' => '12345',
    ]);

    $response->assertRedirect(route('login'));
    $this->assertGuest();
    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
        'email' => 'test@smkn20.com',
        'role' => 'siswa',
    ]);
});

test('users cannot register with the previous school email domain', function () {
    $response = $this->from('/register')->post('/register', [
        'name' => 'Test User',
        'email' => 'test@smkn20jkt',
        'password' => '12345',
        'password_confirmation' => '12345',
    ]);

    $response->assertRedirect('/register')
        ->assertSessionHasErrors('email');
    $this->assertDatabaseMissing('users', ['email' => 'test@smkn20jkt']);
});

test('registration email domain is exact', function () {
    $response = $this->from('/register')->post('/register', [
        'name' => 'Test User',
        'email' => 'test@not-smkn20.com',
        'password' => '12345',
        'password_confirmation' => '12345',
    ]);

    $response->assertRedirect('/register')
        ->assertSessionHasErrors('email');
    $this->assertDatabaseMissing('users', ['email' => 'test@not-smkn20.com']);
});
