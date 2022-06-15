<?php

namespace Descom\AuthSpa\Tests\Feature;

use Descom\AuthSpa\Tests\Models\User;
use Descom\AuthSpa\Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class LoginTest extends TestCase
{
    public function test_fail_login_if_dont_send_email()
    {
        $this->postJson(route('login'))->assertStatus(422);
    }

    public function test_login()
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

    public function test_login_failed_if_bad_password()
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
