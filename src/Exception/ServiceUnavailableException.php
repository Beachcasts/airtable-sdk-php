<?php
/**
 * Project airtable-sdk-php
 * File: BadGatewayException.php
 * Created by: tpojka
 * On: 25/03/2020.
 */

namespace Beachcasts\Airtable\Exception;

class ServiceUnavailableException extends AirtableException
{
    /**
     * @var int
     */
    protected $code = 503;

    /**
     * @var string
     */
    protected $message = 'The server could not process your request in time.';
}
