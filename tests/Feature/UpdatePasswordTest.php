<?php

namespace Descom\AuthSpa\Tests\Feature;

use Descom\AuthSpa\Tests\Models\User;
use Descom\AuthSpa\Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordTest extends TestCase
{
    public function test_password_change()
    {
        Event::fake();

        $user = User::create([
            'name' => 'Test',
            'email' => 'sample@sample.es',
            'password' => bcrypt('oldpassword'),
        ]);

        $this->actingAs($user)->putJson(route('api.user.password.update'), [
            'current_password' => 'oldpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ])->assertStatus(200);

        $this->assertTrue(Hash::check('newpassword', $user->getAuthPassword()));
    }

    public function test_password_change_fail_if_current_password_is_invalid()
    {
        Event::fake();

        $user = User::create([
            'name' => 'Test',
            'email' => 'sample@sample.es',
            'password' => bcrypt('oldpassword'),
        ]);

        $this->actingAs($user)->putJson(route('api.user.password.update'), [
            'current_password' => 'otherpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ])->assertStatus(422);

        $this->assertTrue(Hash::check('oldpassword', $user->getAuthPassword()));
    }

    public function test_password_change_fail_if_password_is_same_that_current()
    {
        Event::fake();

        $user = User::create([
            'name' => 'Test',
            'email' => 'sample@sample.es',
            'password' => bcrypt('oldpassword'),
        ]);

        $this->actingAs($user)->putJson(route('api.user.password.update'), [
            'current_password' => 'oldpassword',
            'password' => 'oldpassword',
            'password_confirmation' => 'oldpassword',
        ])->assertStatus(422);
    }

    public function test_password_change_fail_if_password_is_invalid_requerimets()
    {
        Event::fake();

        $user = User::create([
            'name' => 'Test',
            'email' => 'sample@sample.es',
            'password' => bcrypt('oldpassword'),
        ]);

        $this->actingAs($user)->putJson(route('api.user.password.update'), [
            'current_password' => 'oldpassword',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ])->assertStatus(422);
    }
}
