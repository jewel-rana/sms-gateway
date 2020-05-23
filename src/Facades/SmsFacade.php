<?php
namespace Rajtika\Sms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class SSLCommerzFacade
 * @package Rajtika\SSLCommerz
 */
class SmsFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sms';
    }
}