<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\OfficePhoneNumber;

class OfficePhoneController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? '';
        $category = $request->category ?? '';
        $keyword = $request->keyword ?? '';

        $query = OfficePhoneNumber::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('type', 'like', '%'.$keyword.'%')
            ->orWhere('title', 'like', '%'.$keyword.'%')
            ->orWhere('pincode', 'like', '%'.$keyword.'%')
            ->orWhere('state', 'like', '%'.$keyword.'%')
            ->orWhere('country', 'like', '%'.$keyword.'%');
        });
        $query->when($status, function($query) use ($status) {
            $query->where('status', $status);
        });

        $data = $query->orderBy('position')->paginate(25);

        return view('admin.officephone.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('admin.officephone.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'country_code' => 'required|string|min:1',
            'number' => 'required|string|min:5',
            'type' => 'required|string|min:2|max:100',
            'purpose' => 'nullable|string|min:2|max:200',
            'purpose_description' => 'nullable|string|min:2|max:1000',
        ]);

        $officephone = new OfficePhoneNumber();
        $officephone->country_code = $request->country_code;
        $officephone->number = $request->number;
        $officephone->type = $request->type;
        $officephone->purpose = $request->purpose ?? '';
        $officephone->purpose_description = $request->purpose_description ?? '';
        $officephone->position = positionSet('office_email_ids');
        $officephone->save();

        return redirect()->route('admin.office.phone.list.all')->with('success', 'New office email created');
    }

    public function detail(Request $request, $id)
    {
        $data = OfficePhoneNumber::findOrFail($id);
        return view('admin.officephone.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = OfficePhoneNumber::findOrFail($id);
        return view('admin.officephone.edit', compact('data'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'id' => 'required|integer|min:1',
            'country_code' => 'required|string|min:1',
            'number' => 'required|string|min:5',
            'type' => 'required|string|min:2|max:100',
            'purpose' => 'nullable|string|min:2|max:200',
            'purpose_description' => 'nullable|string|min:2|max:1000',
        ]);

        $officephone = OfficePhoneNumber::findOrFail($request->id);
        $officephone->country_code = $request->country_code;
        $officephone->number = $request->number;
        $officephone->type = $request->type;
        $officephone->purpose = $request->purpose ?? '';
        $officephone->purpose_description = $request->purpose_description ?? '';
        $officephone->save();

        return redirect()->route('admin.office.phone.list.all')->with('success', 'Office email updated');
    }

    public function delete(Request $request, $id)
    {
        $data = OfficePhoneNumber::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.office.phone.list.all')->with('success', 'Office email deleted');
    }

    public function status(Request $request, $id)
    {
        $data = OfficePhoneNumber::findOrFail($id);
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
            $data = OfficePhoneNumber::findOrFail($position);
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
