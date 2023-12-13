<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;
use App\Models\BlogCategory1;
use App\Models\BlogTag;
use App\Models\BlogCategorySetup;
use App\Models\BlogTagSetup;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ?? '';

        $query = Blog::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%');
        });

        $data = $query->latest('id')->paginate(25);

        return view('admin.blog.index', compact('data'));
    }

    public function create(Request $request)
    {
        $cat1s = BlogCategory1::where('status', 1)->orderBy('position')->get();
        $tags = BlogTag::where('status', 1)->orderBy('position')->get();
        return view('admin.blog.create', compact('cat1s', 'tags'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'cat1_id' => 'required|array',
            'cat1_id.*' => 'required|integer|min:1',
            'cat2_id' => 'nullable|array',
            'cat2_id.*' => 'nullable|integer|min:1',
            'tags_id' => 'nullable|array',
            'tags_id.*' => 'nullable|integer|min:1',

            'title' => 'required|string|max:255',
            'short_desc' => 'nullable|string|min:1|max:1000',
            'detailed_desc' => 'required|string|min:1',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'page_title' => 'nullable|string|min:1',
            'meta_title' => 'nullable|string|min:1',
            'meta_desc' => 'nullable|string|min:1',
            'meta_keyword' => 'nullable|string|min:1'
        ], [
            'image.max' => 'The icon must not be greater than 1MB.',
        ]);

        DB::beginTransaction();

        try {
            $blog = new Blog();
            $blog->title = $request->title;
            $blog->slug = slugGenerate($request->title, 'blogs');
            $blog->short_desc = $request->short_desc ?? '';
            $blog->detailed_desc = $request->detailed_desc ?? '';

            $blog->page_title = $request->page_title ?? '';
            $blog->meta_title = $request->meta_title ?? '';
            $blog->meta_desc = $request->meta_desc ?? '';
            $blog->meta_keyword = $request->meta_keyword ?? '';

            // image upload
            if (isset($request->image)) {
                $fileUpload1 = fileUpload($request->image, 'blog');

                $blog->image_small = $fileUpload1['file'][0];
                $blog->image_medium = $fileUpload1['file'][1];
                $blog->image_large = $fileUpload1['file'][2];
                $blog->image_org = $fileUpload1['file'][3];
            }

            $blog->save();

            // blog category 1
            if (!empty($request->cat1_id) && count($request->cat1_id) > 0) {
                foreach($request->cat1_id as $cat1_id) {
                    $blogCat1 = new BlogCategorySetup();
                    $blogCat1->blog_id = $blog->id;
                    $blogCat1->category_id = $cat1_id;
                    $blogCat1->level = 1;
                    $blogCat1->position = positionSet('blog_category_setups');
                    $blogCat1->save();
                }
            }

            // blog category 2
            if (!empty($request->cat2_id) && count($request->cat2_id) > 0) {
                foreach($request->cat2_id as $cat2_id) {
                    $blogCat1 = new BlogCategorySetup();
                    $blogCat1->blog_id = $blog->id;
                    $blogCat1->category_id = $cat2_id;
                    $blogCat1->level = 2;
                    $blogCat1->position = positionSet('blog_category_setups');
                    $blogCat1->save();
                }
            }

            // blog tag
            if (!empty($request->tags_id) && count($request->tags_id) > 0) {
                foreach($request->tags_id as $tag_id) {
                    $blogCat1 = new BlogTagSetup();
                    $blogCat1->blog_id = $blog->id;
                    $blogCat1->tag_id = $tag_id;
                    $blogCat1->position = positionSet('blog_tag_setups');
                    $blogCat1->save();
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
        }

        return redirect()->route('admin.blog.list.all')->with('success', 'New blog created');
    }

    public function detail(Request $request, $id)
    {
        $data = Blog::findOrFail($id);
        return view('admin.blog.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = Blog::findOrFail($id);
        $cat1sList = BlogCategory1::where('status', 1)->orderBy('position')->get();
        $tagsList = BlogTag::where('status', 1)->orderBy('position')->get();
        $cats1 = BlogCategorySetup::where('blog_id', $id)->where('level', 1)->pluck('category_id')->toArray();
        $tags = BlogTagSetup::where('blog_id', $id)->pluck('tag_id')->toArray();

        return view('admin.blog.edit', compact('data', 'cat1sList', 'tagsList', 'cats1', 'tags'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'id' => 'required|integer|min:1',
            'cat1_id' => 'required|array',
            'cat1_id.*' => 'required|integer|min:1',
            'cat2_id' => 'nullable|array',
            'cat2_id.*' => 'nullable|integer|min:1',
            'tags_id' => 'nullable|array',
            'tags_id.*' => 'nullable|integer|min:1',

            'title' => 'required|string|max:255',
            'short_desc' => 'nullable|string|min:1|max:1000',
            'detailed_desc' => 'required|string|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'page_title' => 'nullable|string|min:1',
            'meta_title' => 'nullable|string|min:1',
            'meta_desc' => 'nullable|string|min:1',
            'meta_keyword' => 'nullable|string|min:1'
        ], [
            'image.max' => 'The icon must not be greater than 1MB.',
        ]);

        DB::beginTransaction();

        try {
            $blog = Blog::findOrFail($request->id);
            $blog->title = $request->title;
            $blog->slug = slugGenerate($request->title, 'blogs');
            $blog->short_desc = $request->short_desc ?? '';
            $blog->detailed_desc = $request->detailed_desc ?? '';

            $blog->page_title = $request->page_title ?? '';
            $blog->meta_title = $request->meta_title ?? '';
            $blog->meta_desc = $request->meta_desc ?? '';
            $blog->meta_keyword = $request->meta_keyword ?? '';

            // image upload
            if (isset($request->image)) {
                $fileUpload1 = fileUpload($request->image, 'blog');

                $blog->image_small = $fileUpload1['file'][0];
                $blog->image_medium = $fileUpload1['file'][1];
                $blog->image_large = $fileUpload1['file'][2];
                $blog->image_org = $fileUpload1['file'][3];
            }

            $blog->save();

            // remove old category setups
            BlogCategorySetup::where('blog_id', $request->id)->delete();
            // blog category 1
            if (!empty($request->cat1_id) && count($request->cat1_id) > 0) {
                foreach($request->cat1_id as $cat1_id) {
                    $blogCat1 = new BlogCategorySetup();
                    $blogCat1->blog_id = $blog->id;
                    $blogCat1->category_id = $cat1_id;
                    $blogCat1->level = 1;
                    $blogCat1->position = positionSet('blog_category_setups');
                    $blogCat1->save();
                }
            }

            // blog category 2
            if (!empty($request->cat2_id) && count($request->cat2_id) > 0) {
                foreach($request->cat2_id as $cat2_id) {
                    $blogCat1 = new BlogCategorySetup();
                    $blogCat1->blog_id = $blog->id;
                    $blogCat1->category_id = $cat2_id;
                    $blogCat1->level = 2;
                    $blogCat1->position = positionSet('blog_category_setups');
                    $blogCat1->save();
                }
            }

            // remove old category setups
            BlogTagSetup::where('blog_id', $request->id)->delete();
            // blog tag
            if (!empty($request->tags_id) && count($request->tags_id) > 0) {
                foreach($request->tags_id as $tag_id) {
                    $blogCat1 = new BlogTagSetup();
                    $blogCat1->blog_id = $blog->id;
                    $blogCat1->tag_id = $tag_id;
                    $blogCat1->position = positionSet('blog_tag_setups');
                    $blogCat1->save();
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
        }

        return redirect()->route('admin.blog.list.all')->with('success', 'Blog updated');
    }

    public function delete(Request $request, $id)
    {
        $data = Blog::findOrFail($id);

        if(!empty($data->image_small) && file_exists(public_path($data->image_small))) unlink($data->image_small);
        if(!empty($data->image_medium) && file_exists(public_path($data->image_medium))) unlink($data->image_medium);
        if(!empty($data->image_large) && file_exists(public_path($data->image_large))) unlink($data->image_large);
        if(!empty($data->image_org) && file_exists(public_path($data->image_org))) unlink($data->image_org);

        $data->delete();

        return redirect()->route('admin.blog.list.all')->with('success', 'Blog deleted');
    }

    public function status(Request $request, $id)
    {
        $data = Blog::findOrFail($id);
        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }
}
