<?php
 
namespace App\Http\Controllers\Api;

use App\Facades\Kanye;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
 
class QuotesApiController extends Controller
{
    /**
     * Returns 5 random quotes
     *
     * @return JsonResponse
     */
    public function retrieve(): JsonResponse
    {
        $quotes = Kanye::getQuotes();

        return response()->json($quotes->random(5));
    }

    /**
     * Returns 5 random from refreshed list
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $quotes = Kanye::getLatestQuotes();

        return response()->json($quotes->random(5));
    }
}