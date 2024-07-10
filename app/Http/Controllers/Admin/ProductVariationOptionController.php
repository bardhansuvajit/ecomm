<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Interfaces\VariationInterface;
use App\Interfaces\VariationOptionInterface;
use App\Interfaces\ProductVariationInterface;

use App\Models\Product;

class ProductVariationOptionController extends Controller
{
    private VariationInterface $variationRepository;
    private VariationOptionInterface $variationOptionRepository;
    private ProductVariationInterface $productVariationRepository;

    public function __construct(VariationInterface $variationRepository, VariationOptionInterface $variationOptionRepository, ProductVariationInterface $productVariationRepository)
    {
        $this->variationRepository = $variationRepository;
        $this->variationOptionRepository = $variationOptionRepository;
        $this->productVariationRepository = $productVariationRepository;
    }

    public function detail(Request $request, $id, $prodVarId)
    {
        $data = Product::findOrFail($id);
        $resp = $this->productVariationRepository->detail($prodVarId);

        if ($resp['status'] == 'success') {
            $item = $resp['data'];
            return view('admin.product.variation.index', compact('request', 'data', 'item'));
        } else {
            return redirect()->route('admin.error.404')->with($resp['status'], $resp['message']);
        }
    }

}
