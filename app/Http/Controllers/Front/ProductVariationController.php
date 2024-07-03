<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ProductVariationInterface;

class ProductVariationController extends Controller
{
    private ProductVariationInterface $productVariationRepository;

    public function __construct(ProductVariationInterface $productVariationRepository)
    {
        $this->productVariationRepository = $productVariationRepository;
    }

    public function detail(Request $request, $id)
    {
        $data = $this->productVariationRepository->detail($id);

        if (!empty($data['data'])) {
            return response()->json([
                'status' => 200,
                'message' => $data['message'],
                'data' => $data['data']
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => $data['message'],
            ]);
        }
    }

}
