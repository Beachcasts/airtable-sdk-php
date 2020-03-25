<?php
/**
 * Project airtable-sdk-php
 * File: BadRequestException.php
 * Created by: tpojka
 * On: 25/03/2020
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
    protected $message = 'The account associated with the API key making requests hits a quota that can be increased by upgrading the Airtable account plan.';
}
