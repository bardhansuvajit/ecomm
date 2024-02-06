<?php

namespace App\Repositories;

use App\Interfaces\ProductReviewInterface;
use Illuminate\Support\Facades\DB;

use App\Models\ProductReview;

class ProductReviewRepository implements ProductReviewInterface
{
    public function paginatedActiveReviewsByProduct(int $productId): array
    {
        $data = ProductReview::where('product_id', $productId)
        ->where('status', 1)
        ->latest('id')
        ->paginate(applicationSettings()->pagination_items_per_page);

        if (count($data) > 0) {
            $response = [
                'status' => 'success',
                'message' => 'Product review fetched successfully',
                'data' => $data,
            ];
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'No reviews found'
            ];
        }

        return $response;
    }

    public function check(int $userId, int $productId): array
    {
        $data = ProductReview::where('product_id', $productId)
        ->where('user_id', $userId)
        ->first();

        if (!empty($data)) {
            $response = [
                'status' => 'success',
                'message' => 'Review exists for the user',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Review does not exist for the user'
            ];
        }

        return $response;
    }

    public function create(array $data): array
    {
        $review = new ProductReview();
        $review->product_id = $data['product_id'];
        $review->user_id = $data['user_id'];
        $review->guest_review = 0;
        $review->rating = $data['rating'];
        $review->heading = $data['heading'];
        $review->review = $data['review'];
        $review->status = 0;
        $review->save();

        $response = [
            'status' => 'success',
            'message' => 'Product review added successfully'
        ];

        return $response;
    }

}
