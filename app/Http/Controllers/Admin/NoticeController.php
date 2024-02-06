<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CountryInterface;

use App\Models\Notice;

class NoticeController extends Controller
{
    private CountryInterface $countryRepository;

    public function __construct(CountryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function index(Request $request)
    {
        $status = $request->status ?? '';
        $category = $request->category ?? '';
        $keyword = $request->keyword ?? '';

        $query = Notice::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('text', 'like', '%'.$keyword.'%')
            ->orWhere('link', 'like', '%'.$keyword.'%');
        });
        $query->when($status, function($query) use ($status) {
            $query->where('status', $status);
        });

        $data = $query->orderBy('position')->paginate(25);

        return view('admin.notice.index', compact('data'));
    }

    public function create(Request $request)
    {
        $shippingAvailableCountries = $this->countryRepository->listShippingOnly();
        return view('admin.notice.create', compact('shippingAvailableCountries'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'text' => 'required|string|min:2',
            'link' => 'nullable|url|min:2',
        ], [
            'image.max' => 'The image must not be greater than 1MB.',
        ]);

        $notice = new Notice();
        $notice->text = $request->text;
        $notice->link = $request->link ?? '';

        // image upload
        if (isset($request->image)) {
            $fileUpload = fileUpload($request->image, 'notice');

            $notice->image_small = $fileUpload['file'][0];
            $notice->image_medium = $fileUpload['file'][1];
            $notice->image_large = $fileUpload['file'][2];
            $notice->image_org = $fileUpload['file'][3];
        }

        $notice->position = positionSet('notices');
        $notice->save();

        return redirect()->route('admin.management.notice.list.all')->with('success', 'New notice created');
    }

    public function detail(Request $request, $id)
    {
        $data = Notice::findOrFail($id);
        return view('admin.notice.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = Notice::findOrFail($id);
        return view('admin.notice.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'text' => 'required|string|min:2',
            'link' => 'nullable|url|min:2',
        ], [
            'image.max' => 'The image must not be greater than 1MB.',
        ]);

        $notice = Notice::findOrFail($request->id);
        $notice->text = $request->text;
        $notice->link = $request->link ?? '';

        // image upload
        if (isset($request->image)) {
            $fileUpload = fileUpload($request->image, 'notice');

            $notice->image_small = $fileUpload['file'][0];
            $notice->image_medium = $fileUpload['file'][1];
            $notice->image_large = $fileUpload['file'][2];
            $notice->image_org = $fileUpload['file'][3];
        }

        $notice->save();

        return redirect()->route('admin.management.notice.list.all')->with('success', 'Notice updated');
    }

    public function delete(Request $request, $id)
    {
        $data = Notice::findOrFail($id);
        if(file_exists(public_path($data->image_small))) unlink($data->image_small);
        if(file_exists(public_path($data->image_medium))) unlink($data->image_medium);
        if(file_exists(public_path($data->image_large))) unlink($data->image_large);
        if(file_exists(public_path($data->image_org))) unlink($data->image_org);
        $data->delete();

        return redirect()->route('admin.management.notice.list.all')->with('success', 'Notice deleted');
    }

    public function status(Request $request, $id)
    {
        $data = Notice::findOrFail($id);
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
            $data = Notice::findOrFail($position);
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
