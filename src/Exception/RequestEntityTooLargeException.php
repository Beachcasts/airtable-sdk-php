<?php
/**
 * Project airtable-sdk-php
 * File: BadRequestException.php
 * Created by: tpojka
 * On: 25/03/2020.
 */

namespace Beachcasts\Airtable\Exception;

class RequestEntityTooLargeException extends AirtableException
{
    /**
     * @var int
     */
    protected $code = 413;

    /**
     * @var string
     */
    protected $message = 'The request exceeded the maximum allowed payload size. You shouldn\'t encounter this under normal use.';
}
