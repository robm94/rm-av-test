<?php

namespace App\Facades;

use App\Services\Kanye\KanyeManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string driver(string $driver = null)
 * @method static Collection getQuotes()
 *
 * @see KanyeManager
 */
class Kanye extends Facade
{
    protected static function getFacadeAccessor()
    {
        return KanyeManager::class;
    }
}
