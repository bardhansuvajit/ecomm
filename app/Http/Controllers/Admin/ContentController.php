<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\ContentPage;

class ContentController extends Controller
{
    public function edit(Request $request, $page)
    {
        $data = ContentPage::where('page', $page)->first();
        return view('admin.content.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1',
            'content' => 'required|string|min:10',
        ]);

        DB::beginTransaction();

        try {
            $content = ContentPage::findOrFail($request->id);
            $content->content = $request->content;
            $content->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        return redirect()->back()->with('success', 'Content update successfull');
    }

    public function status(Request $request, $id)
    {
        $data = ContentPage::findOrFail($id);
        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }

    /*
    public function cancellation(Request $request)
    {
        $data = ContentPage::where('page', 'cancellation')->first();
        return view('admin.content.edit', compact('data'));
    }

    public function terms(Request $request)
    {
        $data = ContentPage::where('page', 'terms')->first();
        return view('admin.content.edit', compact('data'));
    }

    public function privacy(Request $request)
    {
        $data = ContentPage::where('page', 'privacy')->first();
        return view('admin.content.edit', compact('data'));
    }

    public function security(Request $request)
    {
        $data = ContentPage::where('page', 'security')->first();
        return view('admin.content.edit', compact('data'));
    }
    */

}
