<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory1;
use App\Models\BlogCategory2;
use App\Models\BlogCategorySetup;

class BlogCategory1Controller extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ?? '';

        $query = BlogCategory1::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%');
        });

        $data = $query->orderBy('position')->paginate(applicationSettings()->pagination_items_per_page);

        return view('admin.blog.category1.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('admin.blog.category1.create');
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

        $blog = new BlogCategory1();
        $blog->title = $request->title;
        $blog->slug = slugGenerate($request->title, 'blog_category1s');
        $blog->short_desc = $request->short_desc ?? '';
        $blog->detailed_desc = $request->detailed_desc ?? '';

        $blog->page_title = $request->page_title ?? '';
        $blog->meta_title = $request->meta_title ?? '';
        $blog->meta_desc = $request->meta_desc ?? '';
        $blog->meta_keyword = $request->meta_keyword ?? '';
        $blog->position = positionSet('blog_category1s');

        // image upload
        if (isset($request->icon)) {
            $fileUpload1 = fileUpload($request->icon, 'blog-category-1');

            $blog->icon_small = $fileUpload1['file'][0];
            $blog->icon_medium = $fileUpload1['file'][1];
            $blog->icon_large = $fileUpload1['file'][2];
            $blog->icon_org = $fileUpload1['file'][3];
        }

        // image upload
        if (isset($request->banner)) {
            $fileUpload2 = fileUpload($request->banner, 'blog-category-1');

            $blog->banner_small = $fileUpload2['file'][0];
            $blog->banner_medium = $fileUpload2['file'][1];
            $blog->banner_large = $fileUpload2['file'][2];
            $blog->banner_org = $fileUpload2['file'][3];
        }

        $blog->save();

        return redirect()->route('admin.blog.category1.list.all')->with('success', 'New blog created');
    }

    public function detail(Request $request, $id)
    {
        $data = BlogCategory1::findOrFail($id);
        return view('admin.blog.category1.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = BlogCategory1::findOrFail($id);
        return view('admin.blog.category1.edit', compact('data'));
    }

    public function update(Request $request)
    {
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

        $blog = BlogCategory1::findOrFail($request->id);
        $blog->title = $request->title;
        $blog->slug = slugGenerate($request->title, 'blog_category1s');
        $blog->short_desc = $request->short_desc ?? '';
        $blog->detailed_desc = $request->detailed_desc;

        $blog->page_title = $request->page_title ?? '';
        $blog->meta_title = $request->meta_title ?? '';
        $blog->meta_desc = $request->meta_desc ?? '';
        $blog->meta_keyword = $request->meta_keyword ?? '';

        // image upload
        if (isset($request->icon)) {
            $fileUpload1 = fileUpload($request->icon, 'blog-category-1');

            $blog->icon_small = $fileUpload1['file'][0];
            $blog->icon_medium = $fileUpload1['file'][1];
            $blog->icon_large = $fileUpload1['file'][2];
            $blog->icon_org = $fileUpload1['file'][3];
        }

        // image upload
        if (isset($request->banner)) {
            $fileUpload2 = fileUpload($request->banner, 'blog-category-1');

            $blog->banner_small = $fileUpload2['file'][0];
            $blog->banner_medium = $fileUpload2['file'][1];
            $blog->banner_large = $fileUpload2['file'][2];
            $blog->banner_org = $fileUpload2['file'][3];
        }

        $blog->save();

        return redirect()->route('admin.blog.category1.list.all')->with('success', 'Blog updated');
    }

    public function delete(Request $request, $id)
    {
        $data = BlogCategory1::findOrFail($id);
        if(!empty($data->icon_small) && file_exists(public_path($data->icon_small))) unlink($data->icon_small);
        if(!empty($data->icon_medium) && file_exists(public_path($data->icon_medium))) unlink($data->icon_medium);
        if(!empty($data->icon_large) && file_exists(public_path($data->icon_large))) unlink($data->icon_large);
        if(!empty($data->icon_org) && file_exists(public_path($data->icon_org))) unlink($data->icon_org);

        if(!empty($data->banner_small) && file_exists(public_path($data->banner_small))) unlink($data->banner_small);
        if(!empty($data->banner_medium) && file_exists(public_path($data->banner_medium))) unlink($data->banner_medium);
        if(!empty($data->banner_large) && file_exists(public_path($data->banner_large))) unlink($data->banner_large);
        if(!empty($data->banner_org) && file_exists(public_path($data->banner_org))) unlink($data->banner_org);
        $data->delete();

        return redirect()->route('admin.blog.category1.list.all')->with('success', 'Blog deleted');
    }

    public function status(Request $request, $id)
    {
        $data = BlogCategory1::findOrFail($id);
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
            $data = BlogCategory1::findOrFail($position);
            $data->position = $count;
            $data->save();

            $count++;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Position updated',
        ]);
    }

    public function fetchCategory2s(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'data' => 'required|array',
            'data.*' => 'required|integer|min:1',
        ]);

        $resp = [];
        foreach($request->data as $cat1) {
            $cat2sFetch = BlogCategory2::select('id', 'title')->where('status', 1)->where('cat1_id', $cat1)->get();
        }

        if(!empty($cat2sFetch) && count($cat2sFetch) > 0) {
            foreach($cat2sFetch as $cat2) {
                $resp[] = [
                    'id' => $cat2->id,
                    'title' => $cat2->title,
                ];
            }

            return response()->json([
                'status' => 200,
                'message' => 'Category data found',
                'data' => $resp,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Category data not found'
            ]);
        }
    }

    public function fetchCategory2sSelected(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'data' => 'required|array',
            'data.*' => 'required|integer|min:1',
            'id' => 'required|integer|min:1',
        ]);

        $resp = [];
        foreach($request->data as $cat1) {
            $cat2sFetch = BlogCategory2::select('id', 'title')->where('status', 1)->where('cat1_id', $cat1)->get();
            $cats2 = BlogCategorySetup::where('blog_id', $request->id)->where('level', 2)->pluck('category_id')->toArray();

            if(!empty($cat2sFetch) && count($cat2sFetch) > 0) {
                foreach($cat2sFetch as $cat2) {
                    $resp[] = [
                        'id' => $cat2->id,
                        'title' => $cat2->title,
                        'selected' => (collect($cats2)->contains($cat2->id)) ? 'selected' : ''
                    ];
                }
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Category data found',
            'data' => $resp,
        ]);
    }
}
