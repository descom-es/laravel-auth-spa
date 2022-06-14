<?php

namespace Descom\AuthSpa\Tests\Feature;

use Descom\AuthSpa\Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogoutTest extends TestCase
{
    public function testLogout()
    {
        DB::table('users')->insert([
            'name' => 'Test',
            'email' => 'sample@sample.es',
            'password' => bcrypt('sample'),
        ]);

        $this->postJson(route('login'), [
            'email' => 'sample@sample.es',
            'password' => 'sample',
        ]);

        $this->assertAuthenticated();

        $this->postJson(route('logout'))->assertStatus(200);

        $this->assertFalse(Auth::check());
    }
}
