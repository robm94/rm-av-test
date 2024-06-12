<?php

namespace App\Services\Kanye;

use App\Interfaces\KanyeApiDriver;
use Illuminate\Support\Manager;

class KanyeManager extends Manager
{
    public function createKanyeRestDriver(): KanyeApiDriver
    {
        return new KanyeRestDriver();
    }

    public function getDefaultDriver()
    {
        return $this->config->get('kanye.driver', 'kanye-rest');
    }
}
