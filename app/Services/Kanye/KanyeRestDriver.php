<?php

namespace App\Services\Kanye;

use App\Interfaces\KanyeApiDriver;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class KanyeRestDriver implements KanyeApiDriver
{
    /**
     * Returns quotes from cache else rest api
     *
     * @return Collection
     */
    public function getQuotes(): Collection
    {
        // Tries to retrieve quotes from cache else fallback to api
        $quotes = Cache::remember('kanye_rest_quotes', 3600, function () {
            $response = Http::get('https://api.kanye.rest/quotes');
            $quotes = $response->collect();
            return $quotes;
        });
        
        return $quotes;
    }
    
    /**
     * Returns quotes from rest api
     *
     * @return Collection
     */
    public function getLatestQuotes(): Collection
    {
        Cache::delete('kanye_rest_quotes');
        
        return $this->getQuotes();
    }
}
