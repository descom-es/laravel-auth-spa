<?php

namespace Descom\AuthSpa\Tests\Feature;

use Descom\AuthSpa\Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginTest extends TestCase
{
    public function testFailLoginIfDontSendEmail()
    {
        $this->postJson(route('login'))->assertStatus(422);
    }

    public function testLogin()
    {
        DB::table('users')->insert([
            'name' => 'Test',
            'email' => 'sample@sample.es',
            'password' => bcrypt('sample'),
        ]);

        $this->postJson(route('login'), [
            'email' => 'sample@sample.es',
            'password' => 'sample',
        ])->assertStatus(200);

        $this->assertAuthenticated();
    }

    public function testLoginFailedIfBadPassword()
    {
        DB::table('users')->insert([
            'name' => 'Test',
            'email' => 'sample@sample.es',
            'password' => bcrypt('sample'),
        ]);

        $this->postJson(route('login'), [
            'email' => 'sample@sample.es',
            'password' => 'sample0',
        ])->assertStatus(401);

        $this->assertFalse(Auth::check());
    }
}
