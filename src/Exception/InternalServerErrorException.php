<?php
/**
 * Project airtable-sdk-php
 * File: BadRequestException.php
 * Created by: tpojka
 * On: 25/03/2020
 */

namespace Beachcasts\Airtable\Exception;

class InternalServerErrorException extends AirtableException
{
    /**
     * @var int
     */
    protected $code = 500;

    /**
     * @var string
     */
    protected $message = 'The server encountered an unexpected condition.';
}
