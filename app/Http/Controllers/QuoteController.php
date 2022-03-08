<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuoteController extends Controller
{
    public function showQuote()
    {
        try {
            $quoteArray = array();
            for ($i = 0; $i < 5; $i++) {
                $response = Http::get('https://api.kanye.rest/');
                $jsonData = $response->json();

                $quoteArray[$i] = $jsonData['quote'];
            }

            return response()->json(array('success' => true, 'json_data' => $quoteArray), 200);
        } catch (\Exception $e) {
            return response()->json(array('success' => false), 401);
        }
    }

    public function singleQuote()
    {
        try {

            $response = Http::get('https://api.kanye.rest/');
            $jsonData = $response->json();

            return response()->json(array('success' => true, 'json_data' => $jsonData), 200);
        } catch (\Exception $e) {
            return response()->json(array('success' => false), 401);
        }
    }
}
