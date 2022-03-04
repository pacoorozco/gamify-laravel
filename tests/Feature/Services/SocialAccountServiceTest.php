<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Some rights reserved. See LICENSE and AUTHORS files.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Tests\Feature\Services;

use Gamify\Models\LinkedSocialAccount;
use Gamify\Models\User;
use Gamify\Services\SocialAccountService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class SocialAccountServiceTest extends TestCase
{
    use RefreshDatabase;

    const PROVIDER_NAME = 'testing-provider';
    const EXTERNAL_USER_ID = 'external-id';

    /** @test * */
    public function it_creates_social_account_when_the_user_does_not_exist(): void
    {
        /** @var User $want */
        $want = User::factory()->make();

        $mockExternalUser = Mockery::mock(\Laravel\Socialite\Contracts\User::class);
        $mockExternalUser
            ->shouldReceive('getId')
            ->andReturn(self::EXTERNAL_USER_ID)
            ->shouldReceive('getEmail')
            ->andReturn($want->email)
            ->shouldReceive('getNickname')
            ->andReturn($want->username)
            ->shouldReceive('getName')
            ->andReturn($want->name);

        $serv = new SocialAccountService();

        $user = $serv->findOrCreate($mockExternalUser, self::PROVIDER_NAME);

        $this->assertDatabaseHas(User::class, [
            'username' => $want->username,
            'email' => $want->email,
            'name' => $want->name,
        ]);

        $this->assertDatabaseHas(LinkedSocialAccount::class, [
            'user_id' => $user->id,
            'provider_name' => self::PROVIDER_NAME,
            'provider_id' => self::EXTERNAL_USER_ID,
        ]);
    }

    /** @test * */
    public function it_creates_social_account_when_the_user_exists(): void
    {
        /** @var User $want */
        $want = User::factory()->create();

        $mockExternalUser = Mockery::mock(\Laravel\Socialite\Contracts\User::class);
        $mockExternalUser
            ->shouldReceive('getId')
            ->andReturn(self::EXTERNAL_USER_ID)
            ->shouldReceive('getEmail')
            ->andReturn($want->email)
            ->shouldReceive('getNickname')
            ->andReturn($want->username)
            ->shouldReceive('getName')
            ->andReturn($want->name);

        $serv = new SocialAccountService();

        $user = $serv->findOrCreate($mockExternalUser, self::PROVIDER_NAME);

        $this->assertTrue($user->is($want));

        $this->assertDatabaseHas(LinkedSocialAccount::class, [
            'user_id' => $want->id,
            'provider_name' => self::PROVIDER_NAME,
            'provider_id' => self::EXTERNAL_USER_ID,
        ]);
    }

    /** @test * */
    public function it_creates_an_user_with_an_unique_username_when_the_username_is_already_in_use(): void
    {
        /** @var User $want */
        $want = User::factory()->create([
            'username' => 'original username',
        ]);

        $mockExternalUser = Mockery::mock(\Laravel\Socialite\Contracts\User::class);
        $mockExternalUser
            ->shouldReceive('getId')
            ->andReturn(self::EXTERNAL_USER_ID)
            ->shouldReceive('getEmail')
            ->andReturn('other.email@domain.local')
            ->shouldReceive('getNickname')
            ->andReturn($want->username)
            ->shouldReceive('getName')
            ->andReturn('other name');

        $serv = new SocialAccountService();

        $user = $serv->findOrCreate($mockExternalUser, self::PROVIDER_NAME);

        $this->assertNotEquals($want->username, $user->username);

        $this->assertDatabaseHas(User::class, [
            'username' => $user->username,
            'email' => 'other.email@domain.local',
            'name' => 'other name',
        ]);

        $this->assertDatabaseHas(LinkedSocialAccount::class, [
            'user_id' => $user->id,
            'provider_name' => self::PROVIDER_NAME,
            'provider_id' => self::EXTERNAL_USER_ID,
        ]);
    }

    /** @test * */
    public function it_returns_the_user_which_has_the_related_social_account(): void
    {
        /** @var User $want */
        $want = User::factory()->create();
        $want->accounts()->create([
            'provider_name' => self::PROVIDER_NAME,
            'provider_id' => self::EXTERNAL_USER_ID,
        ]);

        $mockExternalUser = Mockery::mock(\Laravel\Socialite\Contracts\User::class);
        $mockExternalUser
            ->shouldReceive('getId')
            ->andReturn(self::EXTERNAL_USER_ID)
            ->shouldReceive('getEmail')
            ->andReturn($want->email)
            ->shouldReceive('getNickname')
            ->andReturn($want->username)
            ->shouldReceive('getName')
            ->andReturn($want->name);

        $serv = new SocialAccountService();

        $user = $serv->findOrCreate($mockExternalUser, self::PROVIDER_NAME);

        $this->assertTrue($user->is($want));

        $this->assertDatabaseHas(LinkedSocialAccount::class, [
            'user_id' => $want->id,
            'provider_name' => self::PROVIDER_NAME,
            'provider_id' => self::EXTERNAL_USER_ID,
        ]);
    }
}
