<?php
/**
 * Project airtable-sdk-php
 * File: Table.php
 * Created by: tpojka
 * On: 26/03/2020
 */

namespace Beachcasts\Airtable;

class Table
{
    /**
     * @var string|null
     */
    public $name = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
