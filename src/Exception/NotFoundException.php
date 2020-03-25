<?php
/**
 * Project airtable-sdk-php
 * File: BadRequestException.php
 * Created by: tpojka
 * On: 25/03/2020
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
    protected $message = 'Route or resource is not found. This error is returned when the request hits an undefined route, or if the resource doesn\'t exist (e.g. has been deleted).';
}
