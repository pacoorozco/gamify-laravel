<?php

namespace Tests\Feature\Http\Middleware;

use Gamify\Http\Middleware\OnlyAjax;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class OnlyAjaxTest extends TestCase
{
    const TEST_ENDPOINT = '/_test/ajax';

    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware(OnlyAjax::class)->any(self::TEST_ENDPOINT, function () {
            return 'Success';
        });
    }

    /** @test */
    public function it_forbids_non_ajax_requests()
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

    /** @test */
    public function it_passes_with_ajax_requests()
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
