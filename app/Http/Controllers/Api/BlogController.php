<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogFeature;

class BlogController extends Controller
{
    public function fetch(Request $request) {
        $keyword = $request->keyword ?? '';

        $query = BlogFeature::query()
        ->select('blog_features.id as feature_id', 'blogs.id', 'blogs.title', 'blogs.short_desc', 'blogs.image_medium')
        ->join('blogs', 'blogs.id', '=', 'blog_features.blog_id');

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('blogs.title', 'like', '%'.$keyword.'%')
            ->orWhere('blogs.short_desc', 'like', '%'.$keyword.'%');
        });

        $data = $query->orderBy('position')->get();

        if (!empty($data) && count($data) > 0) {
            $resp = [];
            foreach($data as $blog) {
                $resp[] = [
                    'feature_id' => $blog->feature_id,
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'short_desc' => $blog->short_desc,
                    'link' => route('admin.blog.list.detail', $blog->id),
                    'image' => asset($blog->image_medium),
                ];
            }

            return response()->json([
                'status' => 200,
                'message' => 'Featured blogs found',
                'data' => $resp,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Data not found'
            ]);
        }
    }

    public function add(Request $request) {
        $request->validate([
            'blog_id' => 'required|integer|min:1'
        ]);

        $checkFirst = BlogFeature::where('blog_id', $request->blog_id)->first();

        if (!empty($checkFirst)) {
            $checkFirst->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Blog removed from Feature list',
            ]);
        } else {
            $blogFeature = new BlogFeature();
            $blogFeature->blog_id = $request->blog_id;
            $blogFeature->position = positionSet('blog_features');
            $blogFeature->save();

            return response()->json([
                'status' => 200,
                'message' => 'Blog added to Feature list',
            ]);
        }
    }
}
