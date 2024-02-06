<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? '';
        $category = $request->category ?? '';
        $keyword = $request->keyword ?? '';

        $query = Testimonial::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')
            ->orWhere('designation', 'like', '%'.$keyword.'%')
            ->orWhere('comment', 'like', '%'.$keyword.'%');
        });
        $query->when($status, function($query) use ($status) {
            $query->where('status', $status);
        });

        $data = $query->orderBy('position')->paginate(applicationSettings()->pagination_items_per_page);

        return view('admin.testimonial.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('admin.testimonial.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required|string|min:2|max:25',
            'designation' => 'required|string|min:2|max:25',
            'comment' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
        ], [
            'image.max' => 'The image must not be greater than 1MB.',
        ]);

        $testimonial = new Testimonial();
        $testimonial->name = $request->name;
        $testimonial->designation = $request->designation;
        $testimonial->comment = $request->comment;

        // image upload
        if (isset($request->image)) {
            $fileUpload = fileUpload($request->image, 'testimonial');

            $testimonial->image_small = $fileUpload['file'][0];
            $testimonial->image_medium = $fileUpload['file'][1];
            $testimonial->image_large = $fileUpload['file'][2];
        }

        $testimonial->position = positionSet('testimonials');
        $testimonial->save();

        return redirect()->route('admin.management.testimonial.list.all')->with('success', 'New testimonial created');
    }

    public function detail(Request $request, $id)
    {
        $data = Testimonial::findOrFail($id);
        return view('admin.testimonial.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = Testimonial::findOrFail($id);
        return view('admin.testimonial.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:25',
            'designation' => 'required|string|min:2|max:25',
            'comment' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
        ], [
            'image.max' => 'The image must not be greater than 1MB.',
        ]);

        $testimonial = Testimonial::findOrFail($request->id);
        $testimonial->name = $request->name;
        $testimonial->designation = $request->designation;
        $testimonial->comment = $request->comment;

        // image upload
        if (isset($request->image)) {
            $fileUpload = fileUpload($request->image, 'testimonial');

            $testimonial->image_small = $fileUpload['file'][0];
            $testimonial->image_medium = $fileUpload['file'][1];
            $testimonial->image_large = $fileUpload['file'][2];
        }

        $testimonial->save();

        return redirect()->route('admin.management.testimonial.list.all')->with('success', 'Testimonial updated');
    }

    public function delete(Request $request, $id)
    {
        $data = Testimonial::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.management.testimonial.list.all')->with('success', 'Testimonial deleted');
    }

    public function status(Request $request, $id)
    {
        $data = Testimonial::findOrFail($id);
        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }
}
