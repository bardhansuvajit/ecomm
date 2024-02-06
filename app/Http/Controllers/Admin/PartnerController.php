<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Partner;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? '';
        $category = $request->category ?? '';
        $keyword = $request->keyword ?? '';

        $query = Partner::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')
            ->orWhere('description', 'like', '%'.$keyword.'%');
        });
        $query->when($status, function($query) use ($status) {
            $query->where('status', $status);
        });

        $data = $query->orderBy('position')->paginate(applicationSettings()->pagination_items_per_page);

        return view('admin.partner.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('admin.partner.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'nullable|string|max:25',
            'description' => 'nullable|string|min:1|max:70',
            'img_large' => 'required|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
        ], [
            'img_large.max' => 'The image must not be greater than 1MB.',
        ]);

        $partner = new Partner();
        $partner->name = $request->name ?? null;
        $partner->description = $request->description ?? null;

        // image upload
        if (isset($request->img_large)) {
            $fileUpload = fileUpload($request->img_large, 'partner');

            $partner->img_large = $fileUpload['file'][2];
        }

        $partner->position = positionSet('partners');
        $partner->save();

        return redirect()->route('admin.management.partner.list.all')->with('success', 'New partner created');
    }

    public function detail(Request $request, $id)
    {
        $data = Partner::findOrFail($id);
        return view('admin.partner.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = Partner::findOrFail($id);
        return view('admin.partner.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:25',
            'description' => 'nullable|string|min:1|max:70',
            'img_large' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
        ], [
            'img_large.max' => 'The image must not be greater than 1MB.',
        ]);

        $partner = Partner::findOrFail($request->id);
        $partner->name = $request->name ?? null;
        $partner->description = $request->description ?? null;

        // image upload
        if (isset($request->img_large)) {
            $fileUpload = fileUpload($request->img_large, 'partner');

            $partner->img_large = $fileUpload['file'][2];
        }

        $partner->save();

        return redirect()->route('admin.management.partner.list.all')->with('success', 'Partner updated');
    }

    public function delete(Request $request, $id)
    {
        $data = Partner::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.management.partner.list.all')->with('success', 'Partner deleted');
    }

    public function status(Request $request, $id)
    {
        $data = Partner::findOrFail($id);
        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }

    public function position(Request $request)
    {
        $request->validate([
            'position' => 'required|array',
            'position.*' => 'required|integer|min:1'
        ]);

        $count = 1;
        foreach($request->position as $position) {
            $data = Partner::findOrFail($position);
            $data->position = $count;
            $data->save();

            $count++;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Position updated',
        ]);
    }
}
