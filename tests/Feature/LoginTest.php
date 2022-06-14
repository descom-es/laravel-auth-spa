<?php

namespace Descom\AuthSpa\Tests\Feature;

use Descom\AuthSpa\Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginTest extends TestCase
{
    public function test__fail_login_if_dont_send_email()
    {
        $this->postJson(route('login'))->assertStatus(422);
    }

    public function test_login()
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

    public function test_login_failed_if_bad_password()
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
