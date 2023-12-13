<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeoPage;

class SeoController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ?? '';

        $query = SeoPage::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('page', 'like', '%'.$keyword.'%');
        });

        $data = $query->paginate(25);

        return view('admin.seo.index', compact('data'));
    }

    public function detail(Request $request, $id)
    {
        $data = SeoPage::findOrFail($id);

        return view('admin.seo.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = SeoPage::findOrFail($id);

        return view('admin.seo.edit', compact('data'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'id' => 'required|integer',
            'page_title' => 'nullable|string|min:1',
            'meta_title' => 'nullable|string|min:1',
            'meta_desc' => 'nullable|string|min:1',
            'meta_keyword' => 'nullable|string|min:1'
        ]);

        $seo = SeoPage::findOrFail($request->id);

        $seo->page_title = $request->page_title ?? '';
        $seo->meta_title = $request->meta_title ?? '';
        $seo->meta_desc = $request->meta_desc ?? '';
        $seo->meta_keyword = $request->meta_keyword ?? '';

        $seo->save();

        return redirect()->route('admin.content.seo.list.all')->with('success', 'SEO page details updated');
    }
}
