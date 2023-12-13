<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Interfaces\OrderInterface;
use App\Models\OrderProduct;
use App\Models\OrderProductStatus;

class OrderController extends Controller
{
    private OrderInterface $orderRepository;

    public function __construct(OrderInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->keyword ?? '';
        $resp = $this->orderRepository->listAll($keyword);
        $data = $resp['data'];
        return view('admin.order.index', compact('data'));
    }

    public function detail(Request $request, $id)
    {
        $resp = $this->orderRepository->findById($id);
        $data = $resp['data'];
        $productStatus = OrderProductStatus::orderBy('position')->get();
        return view('admin.order.detail', compact('data', 'productStatus'));
    }

    public function status(Request $request, $id)
    {
        $orderProducts = OrderProduct::where('order_id', $id)->get();

        foreach($orderProducts as $product) {
            $data = OrderProduct::findOrFail($product->id);
            $data->status = $request->status;
            $data->update();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Status updated. Refresh the page',
        ]);
    }
}
