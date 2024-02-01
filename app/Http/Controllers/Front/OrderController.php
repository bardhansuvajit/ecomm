<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Interfaces\OrderInterface;

class OrderController extends Controller
{
    public function __construct(OrderInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request)
    {
        if (auth()->guard('web')->check()) {
            $resp = $this->orderRepository->findByUserId(auth()->guard('web')->user()->id);
            return view('front.profile.order.index', compact('resp'));
        } else {
            return redirect()->route('front.error.401', ['login' => 'true', 'redirect' => route('front.user.order.index')]);
        }
    }

    public function detail(Request $request, $orderNo)
    {
        if (auth()->guard('web')->check()) {
            $resp = $this->orderRepository->findByorderNo($orderNo, auth()->guard('web')->user()->id);

            if ($resp['status'] == 'success') {
                $data = $resp['data'];
                return view('front.profile.order.detail', compact('data'));
            } else {
                return redirect()->route('front.error.404');
            }
        } else {
            return redirect()->route('front.error.401', ['login' => 'true', 'redirect' => route('front.user.order.detail', $orderNo)]);
        }

        /*
        if (Auth::guard('web')->check()) {
            $data = Order::where('id', $id)->where('user_id', auth()->guard('web')->user()->id)->first();

            if (!empty($data)) {
                return view('front.profile.order-detail', compact('data'));
            } else {
                return redirect()->route('front.user.order');
            }
        } else {
            return redirect()->route('front.user.login');
        }
        */
    }
}
