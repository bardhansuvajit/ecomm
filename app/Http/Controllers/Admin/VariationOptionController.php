<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Interfaces\VariationInterface;
use App\Interfaces\VariationOptionInterface;

class VariationOptionController extends Controller
{
    private VariationInterface $variationRepository;
    private VariationOptionInterface $variationOptionRepository;

    public function __construct(VariationInterface $variationRepository, VariationOptionInterface $variationOptionRepository)
    {
        $this->variationRepository = $variationRepository;
        $this->variationOptionRepository = $variationOptionRepository;
    }

    public function index(Request $request)
    {
        $variations = $this->variationRepository->listActive(['title', 'asc']);
        $categories = $this->variationOptionRepository->categories();
        $responsess = $this->variationOptionRepository->listPaginated($request->all(), ['position', 'asc']);
        // $responses = $this->variationOptionRepository->listPaginated($request, []);
        $data = $responsess['data'] ?? [];

        return view('admin.variation-option.index', compact('data', 'variations', 'categories'));
    }

    public function create(Request $request)
    {
        $variations = $this->variationRepository->listActive(['title', 'asc']);
        return view('admin.variation-option.create', compact('variations'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'variation_id' => 'required|integer|min:1|exists:variations,id',
            'value' => 'required|string|min:1|max:255|unique:variation_options,value',
            'category' => 'nullable|string|min:2',
            'equivalent' => 'nullable|string|min:2',
            'information' => 'nullable|string|min:2',
            'short_description' => 'nullable|string|min:2|max:1000',
            'long_description' => 'nullable|string|min:2',
        ]);

        $resp = $this->variationOptionRepository->store($request->all());

        if ($resp['status'] == 'success') {
            return redirect()->route('admin.product.variation.option.list')->with($resp['status'], $resp['message']);
        } else {
            return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
        }
    }

    public function detail(Request $request, $id)
    {
        $resp = $this->variationOptionRepository->detail($id);

        if ($resp['status'] == 'success') {
            $data = $resp['data'];
            return view('admin.variation-option.detail', compact('data'));
        } else {
            return redirect()->route('admin.error.404')->with($resp['status'], $resp['message']);
        }
    }

    public function edit(Request $request, $id)
    {
        $resp = $this->variationOptionRepository->detail($id);

        if ($resp['status'] == 'success') {
            $variations = $this->variationRepository->listActive(['title', 'asc']);
            $data = $resp['data'];
            return view('admin.variation-option.edit', compact('data', 'variations'));
        } else {
            return redirect()->route('admin.error.404')->with($resp['status'], $resp['message']);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1',
            'variation_id' => 'required|integer|min:1|exists:variations,id',
            'value' => 'required|string|min:1|max:255',
            'category' => 'nullable|string|min:2',
            'equivalent' => 'nullable|string|min:2',
            'information' => 'nullable|string|min:2',
            'short_description' => 'nullable|string|min:2|max:1000',
            'long_description' => 'nullable|string|min:2',
        ]);

        $resp = $this->variationOptionRepository->update($request->all());

        if ($resp['status'] == 'success') {
            return redirect()->route('admin.product.variation.option.list')->with($resp['status'], $resp['message']);
        } else {
            return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
        }
    }

    public function delete(Request $request, $id)
    {
        $resp = $this->variationOptionRepository->delete($id);
        return redirect()->back()->with($resp['status'], $resp['message']);
    }

    public function status(Request $request, $id)
    {
        $resp = $this->variationOptionRepository->status($id);
        return response()->json([
            'status' => $resp['code'],
            'message' => $resp['message'],
        ]);
    }

    public function position(Request $request)
    {
        $variations = $this->variationRepository->listActive(['title', 'asc']);
        $categories = $this->variationOptionRepository->categories();
        $responsess = $this->variationOptionRepository->listPaginated($request->all(), ['position', 'asc']);
        $data = $responsess['data'] ?? [];

        return view('admin.variation-option.position', compact('data', 'variations', 'categories'));
    }

    public function positionUpdate(Request $request)
    {
        $resp = $this->variationOptionRepository->position($request->position);
        return response()->json([
            'status' => $resp['code'],
            'message' => $resp['message'],
        ]);
    }
}
