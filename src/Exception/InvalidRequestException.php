<?php
/**
 * Project airtable-sdk-php
 * File: BadRequestException.php
 * Created by: tpojka
 * On: 25/03/2020.
 */

namespace Beachcasts\Airtable\Exception;

class InvalidRequestException extends AirtableException
{
    /**
     * @var int
     */
    protected $code = 422;

    /**
     * @var string
     */
    protected $message = 'The request data is invalid.';
}
