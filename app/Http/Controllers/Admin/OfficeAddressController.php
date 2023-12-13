<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\OfficeAddress;

class OfficeAddressController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? '';
        $category = $request->category ?? '';
        $keyword = $request->keyword ?? '';

        $query = OfficeAddress::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('type', 'like', '%'.$keyword.'%')
            ->orWhere('title', 'like', '%'.$keyword.'%')
            ->orWhere('pincode', 'like', '%'.$keyword.'%')
            ->orWhere('state', 'like', '%'.$keyword.'%')
            ->orWhere('country', 'like', '%'.$keyword.'%')
            ->orWhere('street_address', 'like', '%'.$keyword.'%');
        });
        $query->when($status, function($query) use ($status) {
            $query->where('status', $status);
        });

        $data = $query->orderBy('position')->paginate(25);

        return view('admin.officeaddress.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('admin.officeaddress.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'type' => 'required|string|min:2|max:100',
            'title' => 'required|string|min:2|max:200',
            'street_address' => 'required|string|min:2|max:1000',
            'pincode' => 'required|integer|min:2',
            'state' => 'required|string|min:2|max:200',
            'country' => 'required|string|min:2|max:200',
        ]);

        $officeaddress = new OfficeAddress();
        $officeaddress->type = $request->type;
        $officeaddress->title = $request->title;
        $officeaddress->street_address = $request->street_address;
        $officeaddress->pincode = $request->pincode;
        $officeaddress->state = $request->state;
        $officeaddress->country = $request->country;
        $officeaddress->position = positionSet('office_addresses');
        $officeaddress->save();

        return redirect()->route('admin.office.address.list.all')->with('success', 'New office address created');
    }

    public function detail(Request $request, $id)
    {
        $data = OfficeAddress::findOrFail($id);
        return view('admin.officeaddress.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = OfficeAddress::findOrFail($id);
        return view('admin.officeaddress.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'type' => 'required|string|min:2|max:100',
            'title' => 'required|string|min:2|max:200',
            'street_address' => 'required|string|min:2|max:1000',
            'pincode' => 'required|integer|min:2',
            'state' => 'required|string|min:2|max:200',
            'country' => 'required|string|min:2|max:200',
        ]);

        $officeaddress = OfficeAddress::findOrFail($request->id);
        $officeaddress->type = $request->type;
        $officeaddress->title = $request->title;
        $officeaddress->street_address = $request->street_address;
        $officeaddress->pincode = $request->pincode;
        $officeaddress->state = $request->state;
        $officeaddress->country = $request->country;

        $officeaddress->save();

        return redirect()->route('admin.office.address.list.all')->with('success', 'Office address updated');
    }

    public function delete(Request $request, $id)
    {
        $data = OfficeAddress::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.office.address.list.all')->with('success', 'Office address deleted');
    }

    public function status(Request $request, $id)
    {
        $data = OfficeAddress::findOrFail($id);
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
            $data = OfficeAddress::findOrFail($position);
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
