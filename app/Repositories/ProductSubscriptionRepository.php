<?php

namespace App\Repositories;

use App\Interfaces\ProductSubscriptionInterface;

use App\Models\ProductSubscription;

class ProductSubscriptionRepository implements ProductSubscriptionInterface
{
    public function create($data): array
    {
        $content = new ProductSubscription();
        $content->product_id = $data['product_id'];
        $content->user_id = $data['user_id'];
        $content->email_id = $data['email_id'];
        $content->current_product_status = $data['current_product_status'];
        $content->save();

        if (!empty($content)) {
            $response = [
                'status' => 'success',
                'message' => 'You have subscribed to this product. We will contact you once it becomes available'
            ];
            return $response;
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Something happened. Try again later'
            ];
            return $response;
        }
    }

}
