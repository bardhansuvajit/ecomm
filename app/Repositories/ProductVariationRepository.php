<?php

namespace App\Repositories;

use App\Interfaces\ProductVariationInterface;
use Illuminate\Support\Facades\DB;

use App\Models\ProductVariationChild;

class ProductVariationRepository implements ProductVariationInterface
{
    public function detail($id): array
    {
        $data = ProductVariationChild::find($id);

        if (!empty($data)) {
            $currencyData = ipToCurrency();

            if (!empty($data->pricingDetails) && count($data->pricingDetails) > 0) {
                foreach ($data->pricingDetails as $pricingKey => $pricingValue) {
                    if ($currencyData->currency_id == $pricingValue->currency_id) {
                        $response = [
                            'status' => 'success',
                            'message' => 'Product data found',
                            'data' => [
                                'child' => $data,
                                'pricing_mrp' => indianMoneyFormat($pricingValue->mrp),
                                'pricing_sel' => indianMoneyFormat($pricingValue->selling_price),
                                'discount' => discountCalculate($pricingValue->selling_price, $pricingValue->mrp)
                            ]
                        ];

                        return $response;
                    }
                }
            } else {
                $product = $data->parentDetail->productDetail;
                $pricing = productPricing($product);

                // dd($product);
                $response = [
                    'status' => 'success',
                    'message' => 'Product data found',
                    'data' => [
                        'child' => $data,
                        'pricing_mrp' => indianMoneyFormat($pricing['mrp']),
                        'pricing_sel' => indianMoneyFormat($pricing['selling_price']),
                        'discount' => discountCalculate($pricing['selling_price'], $pricing['mrp'])
                    ]
                ];

                return $response;
            }
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'No data found'
            ];
        }

        return $response;
    }
}
