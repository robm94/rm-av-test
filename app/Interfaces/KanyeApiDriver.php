<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface KanyeApiDriver
{
    /**
     * Return list of cached quotes
     *
     * @return Collection
     */
    public function getQuotes(): Collection;
    
    /**
     * Return list of quotes direct from service
     *
     * @return Collection
     */
    public function getLatestQuotes(): Collection;
}
