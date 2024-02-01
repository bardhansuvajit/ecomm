<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Interfaces\WishlistInterface;

class WishlistController extends Controller
{
    public function __construct(WishlistInterface $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
    }

    public function index(Request $request)
    {
        if (auth()->guard('web')->check()) {
            $resp = $this->wishlistRepository->findByUser(auth()->guard('web')->user()->id);
            return view('front.profile.wishlist.index', compact('resp'));
        } else {
            return redirect()->route('front.error.401', ['login' => 'true', 'redirect' => route('front.user.wishlist.index')]);
        }
    }

    public function toggle(Request $request, $productId)
    {
        if (auth()->guard('web')->check()) {
            $resp = $this->wishlistRepository->toggle($productId, auth()->guard('web')->user()->id);

            if ($resp['status'] == 'success') {
                return response()->json([
                    'status' => 200,
                    'message' => $resp['message'],
                    'type' => $resp['type']
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => $resp['message'],
                    'type' => $resp['type']
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Login to wishlist',
                'type' => 'login'
            ]);
        }
    }

}
