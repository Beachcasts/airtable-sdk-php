<?php

declare(strict_types=1);

namespace Beachcasts\Airtable;

use Beachcasts\Airtable\Exception\MissingApiKeyException;
use GuzzleHttp\Psr7\Request as GuzzlePsr7Request;

abstract class Request extends GuzzlePsr7Request
{
//    public function __construct($method, $uri, array $headers = [], $body = null, $version = '1.1')
//    {
//        if (!array_key_exists('Authorization', $headers)) {
//            $apiKey = getenv('API_KEY');
//            if (empty($apiKey)) {
//                throw new MissingApiKeyException();
//            }
//            $headers['Authorization'] = sprintf('Bearer %s', $apiKey);
//        }
//        parent::__construct($method, $uri, $headers, $body, $version);
//    }
}
