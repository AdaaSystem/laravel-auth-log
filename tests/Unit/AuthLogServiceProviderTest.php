<?php

namespace Adaa\AuthLog\Tests\Unit;

use Illuminate\Support\Facades\Auth;
use Mockery;
use Adaa\AuthLog\Listeners\LogSuccessfulLogin;
use Adaa\AuthLog\Listeners\LogSuccessfulLogout;
use Adaa\AuthLog\Tests\Models\User;
use Adaa\AuthLog\Tests\TestCase;

class AuthLogServiceProviderTest extends TestCase
{
    /** @test */
    public function it_registers_the_login_listener()
    {
        $listener = Mockery::spy(LogSuccessfulLogin::class);
        app()->instance(LogSuccessfulLogin::class, $listener);

        $user = User::create(['name' => 'JohnDoe', 'email' => 'john@example.com']);

        Auth::login($user);

        $listener->shouldHaveReceived('handle')->with(Mockery::on(function ($event) use ($user) {
            return $event->user === $user;
        }));
    }

    /** @test */
    public function it_registers_the_logout_listener()
    {
        Mockery::spy(LogSuccessfulLogin::class);
        $listener = Mockery::spy(LogSuccessfulLogout::class);
        app()->instance(LogSuccessfulLogout::class, $listener);

        $user = User::create(['name' => 'JohnDoe', 'email' => 'john@example.com']);

        Auth::login($user);
        Auth::logout($user);

        $listener->shouldHaveReceived('handle')->with(Mockery::on(function ($event) use ($user) {
            return $event->user === $user;
        }));
    }
}
