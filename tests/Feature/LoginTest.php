<?php

namespace Descom\AuthSpa\Tests\Feature;

use Descom\AuthSpa\Tests\Models\User;
use Descom\AuthSpa\Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class LoginTest extends TestCase
{
    public function testFailLoginIfDontSendEmail()
    {
        $this->postJson(route('login'))->assertStatus(422);
    }

    public function testLogin()
    {
        $user = User::create([
            'name' => 'Test',
            'email' => 'sample@sample.es',
            'password' => bcrypt('sample'),
        ]);

        $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'sample',
        ])->assertStatus(200);

        $this->assertAuthenticated();
    }

    public function testLoginFailedIfBadPassword()
    {
        $user = User::create([
            'name' => 'Test',
            'email' => 'sample@sample.es',
            'password' => bcrypt('sample'),
        ]);

        $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'sample0',
        ])->assertStatus(401);

        $this->assertFalse(Auth::check());
    }
}
