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

namespace Tests\Feature\Http\Middleware;

use PHPUnit\Framework\Attributes\Test;
use Gamify\Http\Middleware\OnlyAjax;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\Feature\TestCase;

final class OnlyAjaxTest extends TestCase
{
    const TEST_ENDPOINT = '/_test/ajax';

    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware(OnlyAjax::class)->any(self::TEST_ENDPOINT, function () {
            return 'Success';
        });
    }

    #[Test]
    public function it_forbids_non_ajax_requests(): void
    {
        $this->withoutExceptionHandling();
        $exceptionCount = 0;
        $httpVerbs = ['get', 'put', 'post', 'patch', 'delete'];

        foreach ($httpVerbs as $httpVerb) {
            try {
                $this->$httpVerb(self::TEST_ENDPOINT);
            } catch (HttpException $e) {
                $exceptionCount++;
                $this->assertEquals(ResponseCode::HTTP_FORBIDDEN, $e->getStatusCode());
                $this->assertEquals('Only ajax call are allowed', $e->getMessage());
            }
        }

        $this->assertEquals(count($httpVerbs), $exceptionCount, 'Expected a 403 forbidden');
    }

    #[Test]
    public function it_passes_with_ajax_requests(): void
    {
        $httpVerbs = ['get', 'put', 'post', 'patch', 'delete'];

        foreach ($httpVerbs as $httpVerb) {
            $response = $this->withHeaders([
                'X-Requested-With' => 'XMLHttpRequest',
            ])->$httpVerb(self::TEST_ENDPOINT);

            $response->assertOk();
        }
    }
}
