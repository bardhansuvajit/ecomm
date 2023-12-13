<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\OfficeEmailId;

class OfficeEmailController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? '';
        $category = $request->category ?? '';
        $keyword = $request->keyword ?? '';

        $query = OfficeEmailId::query();

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

        return view('admin.officeemail.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('admin.officeemail.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'email' => 'required|email|min:2|max:100',
            'type' => 'required|string|min:2|max:100',
            'purpose' => 'nullable|string|min:2|max:200',
            'purpose_description' => 'nullable|string|min:2|max:1000',
        ]);

        $officeemail = new OfficeEmailId();
        $officeemail->email = $request->email;
        $officeemail->type = $request->type;
        $officeemail->purpose = $request->purpose ?? '';
        $officeemail->purpose_description = $request->purpose_description ?? '';
        $officeemail->position = positionSet('office_email_ids');
        $officeemail->save();

        return redirect()->route('admin.office.email.list.all')->with('success', 'New office email created');
    }

    public function detail(Request $request, $id)
    {
        $data = OfficeEmailId::findOrFail($id);
        return view('admin.officeemail.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = OfficeEmailId::findOrFail($id);
        return view('admin.officeemail.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1',
            'email' => 'required|email|min:2|max:100',
            'type' => 'required|string|min:2|max:100',
            'purpose' => 'nullable|string|min:2|max:200',
            'purpose_description' => 'nullable|string|min:2|max:1000',
        ]);

        $officeemail = OfficeEmailId::findOrFail($request->id);
        $officeemail->email = $request->email;
        $officeemail->type = $request->type;
        $officeemail->purpose = $request->purpose ?? '';
        $officeemail->purpose_description = $request->purpose_description ?? '';
        $officeemail->save();

        return redirect()->route('admin.office.email.list.all')->with('success', 'Office email updated');
    }

    public function delete(Request $request, $id)
    {
        $data = OfficeEmailId::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.office.email.list.all')->with('success', 'Office email deleted');
    }

    public function status(Request $request, $id)
    {
        $data = OfficeEmailId::findOrFail($id);
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
            $data = OfficeEmailId::findOrFail($position);
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
