<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstagramController extends Controller
{
    public function post(Request $request) {
        $items = [];

    	if($request->has('username')){
            $client = new \GuzzleHttp\Client;
            $url = sprintf('https://www.instagram.com/%s/media', $request->input('username'));
            $response = $client->get($url);
            $items = json_decode((string) $response->getBody(), true)['items'];
        }
    }

    public function setup(Request $request) {
        
    }
}
