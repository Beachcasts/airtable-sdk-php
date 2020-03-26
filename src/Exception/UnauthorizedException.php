<?php
/**
 * Project airtable-sdk-php
 * File: BadRequestException.php
 * Created by: tpojka
 * On: 25/03/2020.
 */

namespace Beachcasts\Airtable\Exception;

class UnauthorizedException extends AirtableException
{
    /**
     * @var int
     */
    protected $code = 401;

    /**
     * @var string
     */
    protected $message = 'Accessing a protected resource without authorization or with invalid credentials.';
}
