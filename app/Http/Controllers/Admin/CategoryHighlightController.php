<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProductCategory1Highlight;
use App\Models\ProductCategory1;

class CategoryHighlightController extends Controller
{
    public function index(Request $request, $id)
    {
        $status = $request->status ?? '';
        $category = $request->category ?? '';
        $keyword = $request->keyword ?? '';

        $query = CategoryHighlight::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')
            ->orWhere('designation', 'like', '%'.$keyword.'%')
            ->orWhere('comment', 'like', '%'.$keyword.'%');
        });
        $query->when($status, function($query) use ($status) {
            $query->where('status', $status);
        });

        $data = $query->where('category_id', $id)->where('level', 1)->orderBy('position')->paginate(25);
        $catDetail = ProductCategory1::findOrFail($id);

        return view('admin.category-highlight.index', compact('data', 'catDetail', 'id'));
    }

    public function create(Request $request, $id)
    {
        $categories = ProductCategory1::where('status', 1)->orderBy('position')->get();
        return view('admin.category-highlight.create', compact('categories', 'id'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'category_id' => 'required|integer|min:1',
            'title' => 'required|string|min:2|max:1000',
            'link' => 'nullable|url|min:2|max:1000',
            'short_details' => 'required|string|min:2|max:1000',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
        ], [
            'image.max' => 'The image must not be greater than 1MB.',
        ]);

        $highlight = new CategoryHighlight();
        $highlight->category_id = $request->category_id;
        $highlight->level = 1;
        $highlight->title = $request->title;
        $highlight->short_details = $request->short_details;
        $highlight->link = $request->link;

        // image upload
        if (isset($request->image)) {
            $fileUpload = fileUpload($request->image, 'category-highlight');

            $highlight->image_small = $fileUpload['file'][0];
            $highlight->image_medium = $fileUpload['file'][1];
            $highlight->image_large = $fileUpload['file'][2];
        }

        $highlight->position = positionSet('category_highlights');
        $highlight->save();

        return redirect()->route('admin.category.highlight.list.all', $request->category_id)->with('success', 'New category highlight created');
    }

    public function detail(Request $request, $id)
    {
        $data = CategoryHighlight::findOrFail($id);
        return view('admin.category-highlight.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = CategoryHighlight::findOrFail($id);
        $categories = ProductCategory1::where('status', 1)->orderBy('position')->get();
        return view('admin.category-highlight.edit', compact('data', 'categories'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1',
            'category_id' => 'required|integer|min:1',
            'title' => 'required|string|min:2|max:1000',
            'link' => 'nullable|url|min:2|max:1000',
            'short_details' => 'required|string|min:2|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
        ], [
            'image.max' => 'The image must not be greater than 1MB.',
        ]);

        $highlight = CategoryHighlight::findOrFail($request->id);
        $highlight->category_id = $request->category_id;
        $highlight->level = 1;
        $highlight->title = $request->title;
        $highlight->short_details = $request->short_details;
        $highlight->link = $request->link;

        // image upload
        if (isset($request->image)) {
            $fileUpload = fileUpload($request->image, 'category-highlight');

            $highlight->image_small = $fileUpload['file'][0];
            $highlight->image_medium = $fileUpload['file'][1];
            $highlight->image_large = $fileUpload['file'][2];
        }

        $highlight->save();

        return redirect()->route('admin.category.highlight.list.all', $request->category_id)->with('success', 'Category highlight updated');
    }

    public function delete(Request $request, $id)
    {
        $data = CategoryHighlight::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.category.highlight.list.all', $data->category_id)->with('success', 'Category highlight deleted');
    }

    public function status(Request $request, $id)
    {
        $data = CategoryHighlight::findOrFail($id);
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
            $data = CategoryHighlight::findOrFail($position);
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
