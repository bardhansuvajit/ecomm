<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ?? '';

        $query = Collection::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%')
            ->orWhere('short_desc', 'like', '%'.$keyword.'%')
            ->orWhere('detailed_desc', 'like', '%'.$keyword.'%');
        });

        $data = $query->orderBy('position')->paginate(25);

        return view('admin.collection.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('admin.collection.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'title' => 'required|string|min:2|max:255',
            'short_desc' => 'nullable|string|min:2|max:1000',
            'detailed_desc' => 'nullable|string|min:2',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',

            'page_title' => 'nullable|string|min:1',
            'meta_title' => 'nullable|string|min:1',
            'meta_desc' => 'nullable|string|min:1',
            'meta_keyword' => 'nullable|string|min:1'
        ], [
            'icon.max' => 'The icon must not be greater than 1MB.',
            'banner.max' => 'The icon must not be greater than 1MB.',
        ]);

        $table_name = 'collections';
        $data = new Collection();
        $data->title = $request->title;
        $data->slug = slugGenerate($request->title, 'collections');
        $data->short_desc = $request->short_desc ?? '';
        $data->detailed_desc = $request->detailed_desc ?? '';

        $data->page_title = $request->page_title ?? '';
        $data->meta_title = $request->meta_title ?? '';
        $data->meta_desc = $request->meta_desc ?? '';
        $data->meta_keyword = $request->meta_keyword ?? '';
        $data->position = positionSet('collections');

        // image upload
        if (isset($request->icon)) {
            $fileUpload1 = fileUpload($request->icon, 'collection');

            $data->icon_small = $fileUpload1['file'][0];
            $data->icon_medium = $fileUpload1['file'][1];
            $data->icon_large = $fileUpload1['file'][2];
            $data->icon_org = $fileUpload1['file'][3];
        }

        // image upload
        if (isset($request->banner)) {
            $fileUpload2 = fileUpload($request->banner, 'collection');

            $data->banner_small = $fileUpload2['file'][0];
            $data->banner_medium = $fileUpload2['file'][1];
            $data->banner_large = $fileUpload2['file'][2];
            $data->banner_org = $fileUpload2['file'][3];
        }

        $data->save();

        return redirect()->route('admin.product.collection.list.all')->with('success', 'New collection created successfully');
    }

    public function detail(Request $request, $id)
    {
        $data = Collection::findOrFail($id);
        return view('admin.collection.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = Collection::findOrFail($id);
        return view('admin.collection.edit', compact('data'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'id' => 'required|integer|min:1',
            'title' => 'required|string|min:2|max:255',
            'short_desc' => 'nullable|string|min:2|max:1000',
            'detailed_desc' => 'nullable|string|min:2',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',

            'page_title' => 'nullable|string|min:1',
            'meta_title' => 'nullable|string|min:1',
            'meta_desc' => 'nullable|string|min:1',
            'meta_keyword' => 'nullable|string|min:1'
        ], [
            'icon.max' => 'The icon must not be greater than 1MB.',
            'banner.max' => 'The icon must not be greater than 1MB.',
        ]);

        $data = Collection::findOrFail($request->id);
        $data->title = $request->title;
        $data->slug = slugGenerate($request->title, 'collections');
        $data->short_desc = $request->short_desc ?? '';
        $data->detailed_desc = $request->detailed_desc ?? '';

        $data->page_title = $request->page_title ?? '';
        $data->meta_title = $request->meta_title ?? '';
        $data->meta_desc = $request->meta_desc ?? '';
        $data->meta_keyword = $request->meta_keyword ?? '';

        // image upload
        if (isset($request->icon)) {
            $fileUpload1 = fileUpload($request->icon, 'collection');

            $data->icon_small = $fileUpload1['file'][0];
            $data->icon_medium = $fileUpload1['file'][1];
            $data->icon_large = $fileUpload1['file'][2];
            $data->icon_org = $fileUpload1['file'][3];
        }

        // image upload
        if (isset($request->banner)) {
            $fileUpload2 = fileUpload($request->banner, 'collection');

            $data->banner_small = $fileUpload2['file'][0];
            $data->banner_medium = $fileUpload2['file'][1];
            $data->banner_large = $fileUpload2['file'][2];
            $data->banner_org = $fileUpload2['file'][3];
        }

        $data->save();

        return redirect()->route('admin.product.collection.list.all')->with('success', 'Collection updated successfully');
    }

    public function delete(Request $request, $id)
    {
        $data = Collection::findOrFail($id)->delete();

        return redirect()->route('admin.product.collection.list.all')->with('success', 'Collection deleted successfully');
    }

    public function status(Request $request, $id)
    {
        $data = Collection::findOrFail($id);
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
            $data = Collection::findOrFail($position);
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
