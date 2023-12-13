<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OrderProduct;

class OrderProductController extends Controller
{
    public function status(Request $request, $id)
    {
        $data = OrderProduct::findOrFail($id);
        $data->status = $request->status;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }
}
