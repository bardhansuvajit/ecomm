<?php

namespace App\Repositories;

use App\Interfaces\CartInterface;

use App\Models\Cart;

class CartRepository implements CartInterface
{
    public function fetch() : array
    {
        $response = [];

        if (auth()->guard('web')->check()) {
            $userId = auth()->guard('web')->user()->id;
            $data = Cart::where('user_id', $userId)->where('save_for_later', 0)->get();

            if (!empty($data) && count($data) > 0) {
                $response = [
                    'status' => 'success',
                    'message' => 'Cart data fetch',
                    'type' => 'logged-in user',
                    'data' => $data,
                ];
                return $response;
            }

            $response = [
                'status' => 'failure',
                'message' => 'Something happened',
            ];
            return $response;
        } else {
            if (!empty($_COOKIE['_cart-token'])) {
                $token = $_COOKIE['_cart-token'];
                $data = Cart::where('guest_token', $token)->where('save_for_later', 0)->get();

                if (!empty($data) && count($data) > 0) {
                    $response = [
                        'status' => 'success',
                        'message' => 'Cart data fetch',
                        'type' => 'guest user',
                        'data' => $data,
                    ];
                    return $response;
                }
            }

            $response = [
                'status' => 'failure',
                'message' => 'Something happened',
            ];
            return $response;

        }
    }

    public function fetchAjax($userId) : array
    {
        $response = [];

        if ($userId != 0) {
            $data = Cart::where('user_id', $userId)->where('save_for_later', 0)->get();

            if (!empty($data) && count($data) > 0) {
                $response = [
                    'status' => 'success',
                    'message' => 'Cart data fetch',
                    'type' => 'logged-in user',
                    'data' => $data,
                ];
                return $response;
            }

            $response = [
                'status' => 'failure',
                'message' => 'Something happened',
            ];
            return $response;
        } else {
            if (!empty($_COOKIE['_cart-token'])) {
                $token = $_COOKIE['_cart-token'];
                $data = Cart::where('guest_token', $token)->where('save_for_later', 0)->get();

                if (!empty($data) && count($data) > 0) {
                    $response = [
                        'status' => 'success',
                        'message' => 'Cart data fetch',
                        'type' => 'guest user',
                        'data' => $data,
                    ];
                    return $response;
                }
            }

            $response = [
                'status' => 'failure',
                'message' => 'Something happened',
            ];
            return $response;

        }
    }

    public function remove(int $id) : array
    {
        $response = [];

        if (auth()->guard('web')->check()) {
            $data = Cart::where('id', $id)->where('user_id', auth()->guard('web')->user()->id)->delete();

            $response = [
                'status' => 'success',
                'message' => 'Product removed from cart',
                'type' => 'logged-in user'
            ];
            return $response;

        } else {
            if (!empty($_COOKIE['_cart-token'])) {
                $token = $_COOKIE['_cart-token'];
                $data = Cart::where('id', $id)->where('guest_token', $token)->delete();

                $response = [
                    'status' => 'success',
                    'message' => 'Product removed from cart',
                    'type' => 'guest user'
                ];
                return $response;
            }

            $response = [
                'status' => 'failure',
                'message' => 'Something happened',
            ];
            return $response;
        }
    }

    public function saveToggle(int $id) : array
    {
        $response = [];

        if (auth()->guard('web')->check()) {
            $cart = Cart::findOrFail($id);

            if ($cart->save_for_later == 0) {
                $updatedSaved = 1;
                $message = "Product saved for later";
            } else {
                $updatedSaved = 0;
                $message = "Product moved to cart";
            }

            $cart->save_for_later = $updatedSaved;
            $cart->save();

            $response = [
                'status' => 'success',
                'message' => $message
            ];
            return $response;
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Something happened',
            ];
            return $response;
        }
    }

    public function qtyUpdate(int $id, int $qty) : array
    {
        $response = [];

        if (auth()->guard('web')->check()) {
            $data = Cart::where('id', $id)->where('user_id', auth()->guard('web')->user()->id)->first();
            $data->qty = $qty;
            $data->save();

            $response = [
                'status' => 'success',
                'message' => 'Product quantity updated',
                'type' => 'logged-in user'
            ];
            return $response;

        } else {
            if (!empty($_COOKIE['_cart-token'])) {
                $token = $_COOKIE['_cart-token'];
                $data = Cart::where('id', $id)->where('guest_token', $token)->first();
                $data->qty = $qty;
                $data->save();

                $response = [
                    'status' => 'success',
                    'message' => 'Product quantity updated',
                    'type' => 'guest user'
                ];
                return $response;
            }

            $response = [
                'status' => 'failure',
                'message' => 'Something happened',
            ];
            return $response;
        }
    }

    public function update(string $token) : array
    {
        $response = [];

        if (auth()->guard('web')->check()) {
            Cart::where('guest_token', $token)->update([
                'user_id' => auth()->guard('web')->user()->id
            ]);

            // remove cookie - dont remove because, after logout multiple sessions are created
            // unset($_COOKIE['_cart-token']);
            // setcookie('_cart-token', null, -1, '/');

            $response = [
                'status' => 'success',
                'message' => 'cart user id updated'
            ];
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Something happened',
            ];
        }

        return $response;
    }

    public function countLoggedInUser(int $userId) : array {
        $cartCount = Cart::where('user_id', $userId)->where('save_for_later', 0)->count();

        if ($cartCount == 0) {
            $response = [
                'status' => 'failure',
                'message' => 'Data not found',
                'data' => 0,
            ];
        } else {
            $response = [
                'status' => 'success',
                'message' => 'Data found',
                'data' => $cartCount,
            ];
        }
        return $response;
    }

    public function countGuestUser() : array {
        if (!empty($_COOKIE['_cart-token'])) {
            $token = $_COOKIE['_cart-token'];
            $cartCount = Cart::where('guest_token', $token)->where('save_for_later', 0)->count();

            if ($cartCount == 0) {
                $response = [
                    'status' => 'failure',
                    'message' => 'Data not found',
                    'data' => 0,
                ];
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data found',
                    'data' => $cartCount,
                ];
            }
            return $response;
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Data not found',
                'data' => 0,
            ];
            return $response;
        }

    }
}
