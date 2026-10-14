<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('shows the forgot password form', function () {
    $this->get(route('password.forgot'))->assertOk();
});

it('rejects an unknown email', function () {
    $this->post(route('password.send-code'), ['email' => 'nao@existe.com'])
        ->assertSessionHasErrors('email');
});

it('blocks the later steps when the previous ones were skipped', function () {
    $this->get(route('password.verify'))->assertRedirect(route('password.forgot'));
    $this->get(route('password.reset'))->assertRedirect(route('password.forgot'));
    $this->post(route('password.change'), [
        'password' => 'novasenha123',
        'password_confirmation' => 'novasenha123',
    ])->assertRedirect(route('password.forgot'));
});

it('requires a code to be filled in', function () {
    $user = User::factory()->create();

    $this->post(route('password.send-code'), ['email' => $user->email]);

    $this->post(route('password.verify-code'), ['code' => ''])
        ->assertSessionHasErrors('code');
});

it('resets the password after the full flow', function () {
    $user = User::factory()->create();

    $this->post(route('password.send-code'), ['email' => $user->email])
        ->assertRedirect(route('password.verify'));

    $this->post(route('password.verify-code'), ['code' => 'x'])
        ->assertRedirect(route('password.reset'));

    $this->post(route('password.change'), [
        'password' => 'novasenha123',
        'password_confirmation' => 'novasenha123',
    ])->assertRedirect(route('login'));

    expect(Hash::check('novasenha123', $user->fresh()->password))->toBeTrue();

    $this->post(route('login.attempt'), [
        'email' => $user->email,
        'password' => 'novasenha123',
    ])->assertRedirect(route('admin.users.index'));

    $this->assertAuthenticatedAs($user);
});

it('rejects login with a wrong password', function () {
    $user = User::factory()->create();

    $this->post(route('login.attempt'), [
        'email' => $user->email,
        'password' => 'senha-errada',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();
});
