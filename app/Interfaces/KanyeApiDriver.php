<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface KanyeApiDriver
{
    /**
     * Return list of quotes from service
     *
     * @return Collection
     */
    public function getQuotes(): Collection;
}
