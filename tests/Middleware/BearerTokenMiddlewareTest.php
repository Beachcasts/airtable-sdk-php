<?php

namespace Beachcasts\AirtableTests\Middleware;

use Beachcasts\Airtable\Middleware\BearerTokenMiddleware;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class BearerTokenMiddlewareTest extends TestCase
{
    private $middleware;
    private $apiKey;

    protected function setUp(): void
    {
        $this->apiKey = sha1(random_bytes(10));
        $this->middleware = new BearerTokenMiddleware($this->apiKey);
    }

    public function testThatConstructorStoresApiKey(): void
    {
        $apiKeyProperty = new \ReflectionProperty(BearerTokenMiddleware::class, 'apiKey');
        $apiKeyProperty->setAccessible(true);

        self::assertSame($this->apiKey, $apiKeyProperty->getValue($this->middleware));
    }

    public function testThatInvocationReturnsHeaderInRequest(): void
    {
        $request = new Request('blah', 'blah', []);
        $result = $this->middleware->__invoke($request);

        self::assertTrue($result->hasHeader('Authorization'));
        self::assertSame(
            [sprintf('Bearer %s', $this->apiKey)],
            $result->getHeader('Authorization')
        );
    }
}
