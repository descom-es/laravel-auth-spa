<?php

namespace Descom\AuthSpa\Tests\Feature;

use Descom\AuthSpa\Tests\Models\User;
use Descom\AuthSpa\Tests\TestCase;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

class ResetPasswordTest extends TestCase
{
    public function testPasswordForgetFailedIfEmailDontExists()
    {
        $this->postJson(route('password.reset_link'), [
            'email' => 'example@example.com',
        ])->assertStatus(400);
    }

    public function testPasswordForgetSendLink()
    {
        Notification::fake();

        $user = User::create([
            'name' => 'Test',
            'email' => 'sample@sample.es',
            'password' => bcrypt('sample'),
        ]);

        $this->postJson(route('password.reset_link'), [
            'email' => $user->email,
        ])->assertStatus(200);

        Notification::assertSentTo(
            $user,
            ResetPassword::class
        );
    }

    public function testPasswordReset()
    {
        Event::fake();

        $user = User::create([
            'name' => 'Test',
            'email' => 'sample@sample.es',
            'password' => bcrypt('sample'),
        ]);

        $this->postJson(route('password.reset'), [
            'email' => 'sample@sample.es',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
            'token' => Password::createToken($user),
        ])->assertStatus(200);

        Event::assertDispatched(PasswordReset::class);

        $authetiticated = Auth::attempt([
            'email' => $user->email,
            'password' => 'newpassword',
        ]);

        $this->assertTrue($authetiticated);
    }
}
