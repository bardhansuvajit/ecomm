<?php

namespace App\Repositories;

use App\Interfaces\WishlistInterface;

use App\Models\ProductWishlist;

class WishlistRepository implements WishlistInterface
{
    public function toggle(int $productId, int $userId) : array
    {
        $wishlistCheck = ProductWishlist::where('user_id', $userId)->where('product_id', $productId)->first();

        if (!empty($wishlistCheck)) {
            $wishlistCheck->delete();

            $response = [
                'status' => 'success',
                'message' => 'Removed from wishlist',
                'type' => 'removed',
            ];
            return $response;
        } else {
            $pWishlist = new ProductWishlist();
            $pWishlist->user_id = $userId;
            $pWishlist->product_id = $productId;
            $pWishlist->save();

            $response = [
                'status' => 'success',
                'message' => 'Added to wishlist',
                'type' => 'added',
            ];
            return $response;
        }
    }

    public function findByUser(int $userId) : array
    {
        $data = ProductWishlist::where('user_id', $userId)->paginate(10);

        $response = [
            'status' => 'success',
            'message' => 'Product wishlist data',
            'data' => $data,
        ];
        return $response;

        /*
        if (!empty($wishlistCheck)) {
            $wishlistCheck->delete();

            $response = [
                'status' => 'success',
                'message' => 'Removed from wishlist',
                'type' => 'removed',
            ];
            return $response;
        } else {
            $pWishlist = new ProductWishlist();
            $pWishlist->user_id = $userId;
            $pWishlist->product_id = $productId;
            $pWishlist->save();

            $response = [
                'status' => 'success',
                'message' => 'Added to wishlist',
                'type' => 'added',
            ];
            return $response;
        }
        */
    }

}
