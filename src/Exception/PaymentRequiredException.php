<?php
/**
 * Project airtable-sdk-php
 * File: BadRequestException.php
 * Created by: tpojka
 * On: 25/03/2020.
 */

namespace Beachcasts\Airtable\Exception;

class PaymentRequiredException extends AirtableException
{
    /**
     * @var int
     */
    protected $code = 402;

    /**
     * @var string
     */
    protected $message = 'Airtable quote hit for this account.';
}
