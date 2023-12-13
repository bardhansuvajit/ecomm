<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\SocialMedia;

class SocialMediaController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? '';
        $category = $request->category ?? '';
        $keyword = $request->keyword ?? '';

        $query = SocialMedia::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('type', 'like', '%'.$keyword.'%')
            ->orWhere('icon_type', 'like', '%'.$keyword.'%')
            ->orWhere('icon_class', 'like', '%'.$keyword.'%')
            ->orWhere('link', 'like', '%'.$keyword.'%');
        });
        $query->when($status, function($query) use ($status) {
            $query->where('status', $status);
        });

        $data = $query->orderBy('position')->paginate(25);

        return view('admin.socialMedia.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('admin.socialMedia.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'type' => 'required|string|min:2|max:255',
            'icon_type' => 'required|string|min:2|max:255',
            'icon_class' => 'required|string|min:2|max:255',
            'link' => 'required|url|min:2',
        ]);

        $socialMedia = new SocialMedia();
        $socialMedia->type = $request->type;
        $socialMedia->icon_type = $request->icon_type;
        $socialMedia->icon_class = $request->icon_class;
        $socialMedia->link = $request->link;
        $socialMedia->position = positionSet('social_media');
        $socialMedia->save();

        return redirect()->route('admin.management.socialmedia.list.all')->with('success', 'New Social media created');
    }

    public function detail(Request $request, $id)
    {
        $data = SocialMedia::findOrFail($id);
        return view('admin.socialMedia.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = SocialMedia::findOrFail($id);
        return view('admin.socialMedia.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'type' => 'required|string|min:2|max:255',
            'icon_type' => 'required|string|min:2|max:255',
            'icon_class' => 'required|string|min:2|max:255',
            'link' => 'required|url|min:2',
        ]);

        $socialMedia = SocialMedia::findOrFail($request->id);
        $socialMedia->type = $request->type;
        $socialMedia->icon_type = $request->icon_type;
        $socialMedia->icon_class = $request->icon_class;
        $socialMedia->link = $request->link;
        $socialMedia->save();

        return redirect()->route('admin.management.socialmedia.list.all')->with('success', 'Social media updated');
    }

    public function delete(Request $request, $id)
    {
        $data = SocialMedia::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.management.socialmedia.list.all')->with('success', 'SocialMedia deleted');
    }

    public function status(Request $request, $id)
    {
        $data = SocialMedia::findOrFail($id);
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
            $data = SocialMedia::findOrFail($position);
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
