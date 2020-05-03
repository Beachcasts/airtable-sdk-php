<?php
/**
 * Project airtable-sdk-php
 * File: BadRequestException.php
 * Created by: tpojka
 * On: 25/03/2020.
 */

namespace Beachcasts\Airtable\Exception;

class NotFoundException extends AirtableException
{
    /**
     * @var int
     */
    protected $code = 404;

    /**
     * @var string
     */
    protected $message = 'Route or resource not found.';
}
