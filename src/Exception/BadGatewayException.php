<?php
/**
 * Project airtable-sdk-php
 * File: BadGatewayException.php
 * Created by: tpojka
 * On: 25/03/2020.
 */

namespace Beachcasts\Airtable\Exception;

class BadGatewayException extends AirtableException
{
    /**
     * @var int
     */
    protected $code = 502;

    /**
     * @var string
     */
    protected $message = 'Airtable\'s servers are restarting, or an unexpected outage happened.';
}
