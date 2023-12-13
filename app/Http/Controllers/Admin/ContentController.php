<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\ContentPage;

class ContentController extends Controller
{
    public function cancellation(Request $request)
    {
        $data = ContentPage::where('page', 'cancellation')->first();
        return view('admin.content.edit', compact('data'));
    }

    public function usage(Request $request)
    {
        $data = ContentPage::where('page', 'usage')->first();
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

    public function contentPageUpdate(Request $request)
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

}
