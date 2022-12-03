<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\OrderInterface;

class OrderController extends Controller
{
    private OrderInterface $orderRepository;

    public function __construct(OrderInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request)
    {
        $data = $this->orderRepository->listAll();
        return view('admin.order.index', compact('data'));
    }

    public function detail(Request $request, $id)
    {
        $data = $this->orderRepository->findById($id);
        return view('admin.order.detail', compact('data'));
    }
}
