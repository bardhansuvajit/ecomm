<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Interfaces\VariationInterface;

class VariationController extends Controller
{
    private VariationInterface $variationRepository;

    public function __construct(VariationInterface $variationRepository)
    {
        $this->variationRepository = $variationRepository;
    }

    public function index(Request $request)
    {
        $resp = $this->variationRepository->listPaginated($request->all(), ['position', 'asc']);
        // $resp = $this->variationRepository->listPaginated($request, []);
        $data = $resp['data'] ?? [];
        return view('admin.variation.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('admin.variation.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'title' => 'required|string|min:1|max:255|unique:variations,title',
            'short_description' => 'nullable|string|min:2|max:1000',
            'long_description' => 'nullable|string|min:2',
        ]);

        $resp = $this->variationRepository->store($request->all());

        if ($resp['status'] == 'success') {
            return redirect()->route('admin.product.variation.list')->with($resp['status'], $resp['message']);
        } else {
            return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
        }
    }

    public function detail(Request $request, $id)
    {
        $resp = $this->variationRepository->detail($id);

        if ($resp['status'] == 'success') {
            $data = $resp['data'];
            return view('admin.variation.detail', compact('data'));
        } else {
            return redirect()->route('admin.error.404')->with($resp['status'], $resp['message']);
        }
    }

    public function edit(Request $request, $id)
    {
        $resp = $this->variationRepository->detail($id);

        if ($resp['status'] == 'success') {
            $data = $resp['data'];
            return view('admin.variation.edit', compact('data'));
        } else {
            return redirect()->route('admin.error.404')->with($resp['status'], $resp['message']);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1',
            'title' => 'required|string|min:1|max:255|unique:variations,title',
            'short_description' => 'nullable|string|min:2|max:1000',
            'long_description' => 'nullable|string|min:2',
        ]);

        $resp = $this->variationRepository->update($request->all());

        if ($resp['status'] == 'success') {
            return redirect()->route('admin.product.variation.list')->with($resp['status'], $resp['message']);
        } else {
            return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
        }
    }

    public function delete(Request $request, $id)
    {
        $resp = $this->variationRepository->delete($id);
        return redirect()->back()->with($resp['status'], $resp['message']);
    }

    public function status(Request $request, $id)
    {
        $resp = $this->variationRepository->status($id);
        return response()->json([
            'status' => $resp['code'],
            'message' => $resp['message'],
        ]);
    }

    public function position(Request $request)
    {
        $resp = $this->variationRepository->listPaginated($request->all(), ['position', 'asc']);
        $data = $resp['data'] ?? [];
        return view('admin.variation.position', compact('data'));
    }

    public function positionUpdate(Request $request)
    {
        $resp = $this->variationRepository->position($request->position);
        return response()->json([
            'status' => $resp['code'],
            'message' => $resp['message'],
        ]);
    }
}
