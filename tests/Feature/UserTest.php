<?php

namespace Descom\AuthSpa\Tests\Feature;

use Descom\AuthSpa\Tests\Models\User;
use Descom\AuthSpa\Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class UserTest extends TestCase
{
    public function test_fail_get_user_if_not_autenticated()
    {
        $this->getJson(route('api.user'))->assertStatus(401);
    }

    public function test_get_user()
    {
        $user = User::create([
            'name' => 'Test',
            'email' => 'sample@sample.es',
            'password' => bcrypt('sample'),
        ]);

        $this->actingAs($user)->getJson(route('api.user'))
            ->assertStatus(200);
    }
}
