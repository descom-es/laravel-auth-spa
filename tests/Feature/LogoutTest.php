<?php

namespace Descom\AuthSpa\Tests\Feature;

use Descom\AuthSpa\Tests\Models\User;
use Descom\AuthSpa\Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class LogoutTest extends TestCase
{
    public function testLogout()
    {
        $user = User::create([
            'name' => 'Test',
            'email' => 'sample@sample.es',
            'password' => bcrypt('sample'),
        ]);

        $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'sample',
        ]);

        $this->assertAuthenticated();

        $this->postJson(route('logout'))->assertStatus(200);

        $this->assertFalse(Auth::check());
    }
}
