<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CSV extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Http\Components\CSV';
    }
}