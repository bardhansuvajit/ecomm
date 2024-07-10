<?php

namespace App\Repositories;

use App\Interfaces\ProductVariationInterface;
use App\Interfaces\VariationOptionInterface;
use Illuminate\Support\Facades\DB;

use App\Models\ProductVariation;

class ProductVariationRepository implements ProductVariationInterface
{
    private VariationOptionInterface $variationOptionRepository;

    public function __construct(VariationOptionInterface $variationOptionRepository)
    {
        $this->variationOptionRepository = $variationOptionRepository;
    }

    public function detail($id) : array
    {
        $data = ProductVariation::find($id);

        if (!empty($data)) {
            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data found',
                'data' => $data
            ];

            return $response;

            /*
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
            */
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'No data found'
            ];
        }

        return $response;
    }

    public function toggle(array $req) : array {
        // check first if exists or not
        $check = ProductVariation::where('product_id', $req['product_id'])
        ->where('variation_option_id', $req['variation_option_id'])
        ->first();

        if (!empty($check)) {
            $check->delete();

            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data removed'
            ];

            return $response;
        } else {
            // get parent variation of the selected option_id
            $optionDetail = $this->variationOptionRepository->detail($req['variation_option_id']);

            if ($optionDetail['status'] == 'success') {
                // $data = $optionDetail['data'];

                // check if another variation type/ parent is added
                $chkParent = ProductVariation::select('variation_options.variation_id')
                ->where('product_id', $req['product_id'])
                ->join('variation_options', 'variation_options.id', '=', 'product_variations.variation_option_id')
                ->groupBy('variation_options.variation_id')
                ->first();

                // dd($chkParent, $chkParent->variation_id, $optionDetail['data']->variation_id);

                // match 2 variation parents. which is sent by ajax & which already exists
                if (empty($chkParent) || ($optionDetail['data']->variation_id == $chkParent->variation_id)) {
                    $data = new ProductVariation();
                    $data->product_id = $req['product_id'];
                    $data->variation_option_id = $req['variation_option_id'];
                    $data->dependent_option_id = $req['dependent_option_id'] ?? NULL;
                    $data->status = $req['status'] ?? 0;
                    $data->save();

                    if ($data) {
                        $response = [
                            'code' => 200,
                            'status' => 'success',
                            'message' => 'Data added',
                            'data' => $data
                        ];
                    } else {
                        $response = [
                            'code' => 400,
                            'status' => 'failure',
                            'message' => 'Something happened',
                        ];
                    }

                    return $response;
                } else {
                    $response = [
                        'code' => 400,
                        'status' => 'failure',
                        'message' => 'You cannot add dependent variation from here',
                    ];
    
                    return $response;
                }

            } else {
                $response = [
                    'code' => 400,
                    'status' => 'failure',
                    'message' => 'Something happened',
                ];

                return $response;
            }

        }
    }

    public function update(array $req) : array {
        $data = ProductVariation::find($req['id']);

        if (!empty($data)) {
            if(!empty($req['product_id'])) {
                $data->product_id = $req['product_id'];
            }

            if(!empty($req['variation_option_id'])) {
                $data->variation_option_id = $req['variation_option_id'];
            }

            if(!empty($req['image_status'])) {
                $data->image_status = $req['image_status'];
            }

            // image upload
            if (!empty($req['image_path'])) {
                $fileUpload = fileUpload($req['image_path'], 'variation');
                // $banner->desktop_image_small = $fileUpload['file'][0];
                // $banner->desktop_image_medium = $fileUpload['file'][1];
                // $banner->desktop_image_large = $fileUpload['file'][2];
                // $banner->desktop_image_org = $fileUpload['file'][3];
                $data->image_Path = $fileUpload['file'][1];
            }

            $data->save();

            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data updated',
                'data' => $data
            ];
        } else {
            $response = [
                'code' => 400,
                'status' => 'failure',
                'message' => 'Something happened',
            ];
        }

        return $response;
    }
}
