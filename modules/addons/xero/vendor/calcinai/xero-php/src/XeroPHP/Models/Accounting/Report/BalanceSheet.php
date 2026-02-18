<?php

namespace XeroPHP\Models\Accounting\Report;

class BalanceSheet extends \XeroPHP\Models\Accounting\Report\Report
{
    /**
     * Get the resource uri of the class (Contacts) etc.
     *
     * @return string
     */
    public static function getResourceURI()
    {
        return 'Reports/BalanceSheet';
    }
}
