<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IpCountry;

class CurrencyController extends Controller
{
    public function update(Request $request, $currencyId)
    {
        $ipFetch = IpCountry::where('ip_address', ipfetch())->update(['currency_id' => $currencyId]);

        if (!empty($ipFetch)) {
            return response()->json([
                'status' => 200,
                'message' => 'Currency updated'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Something happened'
            ]);
        }
    }

}
