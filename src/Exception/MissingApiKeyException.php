<?php

declare(strict_types=1);

namespace Beachcasts\Airtable\Exception;

class MissingApiKeyException extends AirtableException
{
    /**
     * @var int
     */
    protected $code = 404;

    /**
     * @var string
     */
    protected $message = 'The Api Key was expected to be found in env, but was not found';
}
