<?php
 
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;

/**
 * @codeCoverageIgnore
 */
class QuotesController extends Controller
{
    /**
     * Show page displaying quotes
     * 
     * @return View
     */
    public function show(): View
    {
        return view('quotes');
    }
}