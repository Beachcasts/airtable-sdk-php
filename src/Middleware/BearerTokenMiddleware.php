<?php

declare(strict_types=1);

namespace Beachcasts\Airtable\Middleware;

use Psr\Http\Message\RequestInterface;

class BearerTokenMiddleware
{
    /**
     * @var string
     */
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function __invoke(RequestInterface $request): RequestInterface
    {
        return $request->withHeader(
            'Authorization',
            sprintf(
                'Bearer %s',
                $this->apiKey
            )
        );
    }
}
