<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\OfficeInformation;

class OfficeInformationController extends Controller
{
    public function detail(Request $request)
    {
        $data = OfficeInformation::first();
        return view('admin.office-information.detail', compact('data'));
    }

    public function edit(Request $request)
    {
        $data = OfficeInformation::first();
        return view('admin.office-information.edit', compact('data'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'full_name' => 'required|string|min:2|max:255',
            'pretty_name' => 'required|string|min:2|max:150',
            'short_desc' => 'nullable|string|min:2|max:1000',
            'detailed_desc' => 'nullable|string|min:2',

            'primary_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'hq_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'watermark_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'rectangle_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'square_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'favicon' => 'nullable|mimes:ico|max:100',
        ], [
            'primary_logo.max' => 'The image must not be greater than 1MB.',
            'hq_logo.max' => 'The image must not be greater than 1MB.',
            'watermark_logo.max' => 'The image must not be greater than 1MB.',
            'rectangle_logo.max' => 'The image must not be greater than 1MB.',
            'square_logo.max' => 'The image must not be greater than 1MB.',
            'favicon.max' => 'The image must not be greater than 10KB.',
        ]);

        $data = OfficeInformation::findOrFail(1);
        $data->full_name = $request->full_name;
        $data->pretty_name = $request->pretty_name;
        $data->short_desc = $request->short_desc ?? '';
        $data->detailed_desc = $request->detailed_desc ?? '';

        if (isset($request->primary_logo)) {
            $fileUpload = fileUpload($request->primary_logo, 'office-information');
            $data->primary_logo = $fileUpload['file'][2];
        }
        if (isset($request->hq_logo)) {
            $fileUpload = fileUpload($request->hq_logo, 'office-information');
            $data->hq_logo = $fileUpload['file'][2];
        }
        if (isset($request->watermark_logo)) {
            $fileUpload = fileUpload($request->watermark_logo, 'office-information');
            $data->watermark_logo = $fileUpload['file'][2];
        }
        if (isset($request->rectangle_logo)) {
            $fileUpload = fileUpload($request->rectangle_logo, 'office-information');
            $data->rectangle_logo = $fileUpload['file'][2];
        }
        if (isset($request->square_logo)) {
            $fileUpload = fileUpload($request->square_logo, 'office-information');
            $data->square_logo = $fileUpload['file'][2];
        }
        if (isset($request->favicon)) {
            $fileUpload = fileUpload($request->favicon, 'office-information');
            $data->favicon = $fileUpload['file'][2];
        }

        $data->save();

        return redirect()->route('admin.office.information.detail')->with('success', 'Office information updated');
    }
}
