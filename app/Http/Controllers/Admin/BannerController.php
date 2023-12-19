<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Banner;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? '';
        $category = $request->category ?? '';
        $keyword = $request->keyword ?? '';

        $query = Banner::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('title1', 'like', '%'.$keyword.'%')
            ->orWhere('title2', 'like', '%'.$keyword.'%')
            ->orWhere('description', 'like', '%'.$keyword.'%');
        });
        $query->when($status, function($query) use ($status) {
            $query->where('status', $status);
        });

        $data = $query->orderBy('position')->paginate(25);

        return view('admin.banner.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'desktop_image' => 'required|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'mobile_image' => 'required|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'web_link' => 'required|url',
            'app_link' => 'nullable|string',
            'title1' => 'nullable|string|min:1|max:25',
            'title2' => 'nullable|string|min:1|max:25',
            'short_description' => 'nullable|string|min:1|max:200',
            'detailed_description' => 'nullable|string|min:1|max:1000',
            'btn_text' => 'nullable|string|max:25',
        ], [
            'desktop_image.max' => 'The image must not be greater than 1MB.',
            'mobile_image.max' => 'The image must not be greater than 1MB.',
        ]);

        $banner = new Banner();
        $banner->web_link = $request->web_link ? $request->web_link : '';
        $banner->app_link = $request->app_link ? $request->app_link : '';
        $banner->title1 = $request->title1 ? $request->title1 : '';
        $banner->title2 = $request->title2 ? $request->title2 : '';
        $banner->short_description = $request->short_description ? $request->short_description : '';
        $banner->detailed_description = $request->detailed_description ? $request->detailed_description : '';
        $banner->btn_text = $request->btn_text ? $request->btn_text : '';

        // image upload
        if (isset($request->desktop_image)) {
            $fileUpload = fileUpload($request->desktop_image, 'banner');

            $banner->desktop_image_small = $fileUpload['file'][0];
            $banner->desktop_image_medium = $fileUpload['file'][1];
            $banner->desktop_image_large = $fileUpload['file'][2];
            $banner->desktop_image_org = $fileUpload['file'][3];
        }

        // image upload
        if (isset($request->mobile_image)) {
            $fileUpload = fileUpload($request->mobile_image, 'banner');

            $banner->mobile_image_small = $fileUpload['file'][0];
            $banner->mobile_image_medium = $fileUpload['file'][1];
            $banner->mobile_image_large = $fileUpload['file'][2];
            $banner->mobile_image_org = $fileUpload['file'][3];
        }

        $banner->position = positionSet('banners');
        $banner->save();

        return redirect()->route('admin.content.banner.list.all')->with('success', 'New banner created');
    }

    public function detail(Request $request, $id)
    {
        $data = Banner::findOrFail($id);
        return view('admin.banner.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'desktop_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'web_link' => 'required|url',
            'app_link' => 'nullable|string',
            'title1' => 'nullable|string|min:1|max:25',
            'title2' => 'nullable|string|min:1|max:25',
            'short_description' => 'nullable|string|min:1|max:200',
            'detailed_description' => 'nullable|string|min:1|max:1000',
            'btn_text' => 'nullable|string|max:25',
        ], [
            'desktop_image.max' => 'The image must not be greater than 1MB.',
            'mobile_image.max' => 'The image must not be greater than 1MB.',
        ]);

        $banner = Banner::findOrFail($request->id);
        $banner->web_link = $request->web_link ? $request->web_link : '';
        $banner->app_link = $request->app_link ? $request->app_link : '';
        $banner->title1 = $request->title1 ? $request->title1 : '';
        $banner->title2 = $request->title2 ? $request->title2 : '';
        $banner->short_description = $request->short_description ? $request->short_description : '';
        $banner->detailed_description = $request->detailed_description ? $request->detailed_description : '';
        $banner->btn_text = $request->btn_text ? $request->btn_text : '';

        // image upload
        if (isset($request->desktop_image)) {
            $fileUpload = fileUpload($request->desktop_image, 'banner');

            $banner->desktop_image_small = $fileUpload['file'][0];
            $banner->desktop_image_medium = $fileUpload['file'][1];
            $banner->desktop_image_large = $fileUpload['file'][2];
            $banner->desktop_image_org = $fileUpload['file'][3];
        }

        // image upload
        if (isset($request->mobile_image)) {
            $fileUpload = fileUpload($request->mobile_image, 'banner');

            $banner->mobile_image_small = $fileUpload['file'][0];
            $banner->mobile_image_medium = $fileUpload['file'][1];
            $banner->mobile_image_large = $fileUpload['file'][2];
            $banner->mobile_image_org = $fileUpload['file'][3];
        }

        $banner->save();

        return redirect()->route('admin.content.banner.list.all')->with('success', 'Banner updated');
    }

    public function delete(Request $request, $id)
    {
        $data = Banner::findOrFail($id);
        if(file_exists(public_path($data->image_small))) unlink($data->image_small);
        if(file_exists(public_path($data->image_medium))) unlink($data->image_medium);
        if(file_exists(public_path($data->image_large))) unlink($data->image_large);
        if(file_exists(public_path($data->image_org))) unlink($data->image_org);
        $data->delete();

        return redirect()->route('admin.content.banner.list.all')->with('success', 'Banner deleted');
    }

    public function status(Request $request, $id)
    {
        $data = Banner::findOrFail($id);
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
            $data = Banner::findOrFail($position);
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
