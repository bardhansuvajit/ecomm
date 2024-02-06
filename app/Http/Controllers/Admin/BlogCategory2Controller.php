<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory1;
use App\Models\BlogCategory2;

class BlogCategory2Controller extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ?? '';

        $query = BlogCategory2::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%');
        });

        $data = $query->orderBy('position')->paginate(applicationSettings()->pagination_items_per_page);

        return view('admin.blog.category2.index', compact('data'));
    }

    public function create(Request $request)
    {
        $cat1s = BlogCategory1::where('status', 1)->orderBy('position')->get();
        return view('admin.blog.category2.create', compact('cat1s'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'cat1_id' => 'required|integer|min:1',
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

        $blog = new BlogCategory2();
        $blog->cat1_id = $request->cat1_id;
        $blog->title = $request->title;
        $blog->slug = slugGenerate($request->title, 'blog_category2s');
        $blog->short_desc = $request->short_desc ?? '';
        $blog->detailed_desc = $request->detailed_desc ?? '';

        $blog->page_title = $request->page_title ?? '';
        $blog->meta_title = $request->meta_title ?? '';
        $blog->meta_desc = $request->meta_desc ?? '';
        $blog->meta_keyword = $request->meta_keyword ?? '';
        $blog->position = positionSet('blog_category2s');

        // image upload
        if (isset($request->icon)) {
            $fileUpload1 = fileUpload($request->icon, 'blog-category-2');

            $blog->icon_small = $fileUpload1['file'][0];
            $blog->icon_medium = $fileUpload1['file'][1];
            $blog->icon_large = $fileUpload1['file'][2];
            $blog->icon_org = $fileUpload1['file'][3];
        }

        // image upload
        if (isset($request->banner)) {
            $fileUpload2 = fileUpload($request->banner, 'blog-category-2');

            $blog->banner_small = $fileUpload2['file'][0];
            $blog->banner_medium = $fileUpload2['file'][1];
            $blog->banner_large = $fileUpload2['file'][2];
            $blog->banner_org = $fileUpload2['file'][3];
        }

        $blog->save();

        return redirect()->route('admin.blog.category2.list.all')->with('success', 'New blog created');
    }

    public function detail(Request $request, $id)
    {
        $data = BlogCategory2::findOrFail($id);
        return view('admin.blog.category2.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = BlogCategory2::findOrFail($id);
        $cat1s = BlogCategory1::where('status', 1)->orderBy('position')->get();
        return view('admin.blog.category2.edit', compact('data', 'cat1s'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1',
            'cat1_id' => 'required|integer|min:1',
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

        $blog = BlogCategory2::findOrFail($request->id);
        $blog->cat1_id = $request->cat1_id;
        $blog->title = $request->title;
        $blog->slug = slugGenerate($request->title, 'blog_category2s');
        $blog->short_desc = $request->short_desc ?? '';
        $blog->detailed_desc = $request->detailed_desc;

        $blog->page_title = $request->page_title ?? '';
        $blog->meta_title = $request->meta_title ?? '';
        $blog->meta_desc = $request->meta_desc ?? '';
        $blog->meta_keyword = $request->meta_keyword ?? '';

        // image upload
        if (isset($request->icon)) {
            $fileUpload1 = fileUpload($request->icon, 'blog-category-2');

            $blog->icon_small = $fileUpload1['file'][0];
            $blog->icon_medium = $fileUpload1['file'][1];
            $blog->icon_large = $fileUpload1['file'][2];
            $blog->icon_org = $fileUpload1['file'][3];
        }

        // image upload
        if (isset($request->banner)) {
            $fileUpload2 = fileUpload($request->banner, 'blog-category-2');

            $blog->banner_small = $fileUpload2['file'][0];
            $blog->banner_medium = $fileUpload2['file'][1];
            $blog->banner_large = $fileUpload2['file'][2];
            $blog->banner_org = $fileUpload2['file'][3];
        }

        $blog->save();

        return redirect()->route('admin.blog.category2.list.all')->with('success', 'Blog updated');
    }

    public function delete(Request $request, $id)
    {
        $data = BlogCategory2::findOrFail($id);
        if(!empty($data->icon_small) && file_exists(public_path($data->icon_small))) unlink($data->icon_small);
        if(!empty($data->icon_medium) && file_exists(public_path($data->icon_medium))) unlink($data->icon_medium);
        if(!empty($data->icon_large) && file_exists(public_path($data->icon_large))) unlink($data->icon_large);
        if(!empty($data->icon_org) && file_exists(public_path($data->icon_org))) unlink($data->icon_org);

        if(!empty($data->banner_small) && file_exists(public_path($data->banner_small))) unlink($data->banner_small);
        if(!empty($data->banner_medium) && file_exists(public_path($data->banner_medium))) unlink($data->banner_medium);
        if(!empty($data->banner_large) && file_exists(public_path($data->banner_large))) unlink($data->banner_large);
        if(!empty($data->banner_org) && file_exists(public_path($data->banner_org))) unlink($data->banner_org);
        $data->delete();

        return redirect()->route('admin.blog.category2.list.all')->with('success', 'Blog deleted');
    }

    public function status(Request $request, $id)
    {
        $data = BlogCategory2::findOrFail($id);
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
            $data = BlogCategory2::findOrFail($position);
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
