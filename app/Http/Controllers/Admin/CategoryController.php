<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductCategory1;
use App\Models\ProductCategory2;
use App\Models\ProductCategory3;
use App\Models\ProductCategory4;

class CategoryController extends Controller
{
    public function index(Request $request, $level)
    {
        $keyword = $request->keyword ?? '';

        if($level == 1) $query = ProductCategory1::query();
        elseif($level == 2) $query = ProductCategory2::query();
        elseif($level == 3) $query = ProductCategory3::query();
        else $query = ProductCategory4::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%')
            ->orWhere('short_desc', 'like', '%'.$keyword.'%')
            ->orWhere('detailed_desc', 'like', '%'.$keyword.'%');
        });

        $data = $query->orderBy('position')->paginate(25);
        $parentCategories = ProductCategory1::orderBy('title')->get();

        return view('admin.category.index', compact('level', 'data', 'parentCategories'));
    }

    public function create(Request $request, $level)
    {
        if($level == 2) {
            $data = ProductCategory1::where('status', 1)->orderBy('position')->get();
        } elseif($level == 3) {
            $data = ProductCategory2::where('status', 1)->orderBy('position')->get();
        } else {
            $data = ProductCategory3::where('status', 1)->orderBy('position')->get();
        }

        return view('admin.category.create', compact('data', 'level'));
    }

    public function store(Request $request, $level)
    {
        // dd($request->all(), $level);

        $request->validate([
            'title' => 'required|string|min:2|max:255',
            'short_desc' => 'nullable|string|min:2|max:1000',
            'detailed_desc' => 'nullable|string|min:2',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',

            'page_title' => 'nullable|string|min:1',
            'meta_title' => 'nullable|string|min:1',
            'meta_desc' => 'nullable|string|min:1',
            'meta_keyword' => 'nullable|string|min:1'
        ], [
            'icon.max' => 'The icon must not be greater than 1MB.',
            'banner.max' => 'The icon must not be greater than 1MB.',
        ]);

        if($level == 1) {
            $table_name = 'product_category1s';
            $data = new ProductCategory1();
        } elseif($level == 2) {
            $request->validate([
                'parent_id' => 'required|integer|min:1',
            ]);

            $table_name = 'product_category2s';
            $data = new ProductCategory2();
            $data->cat1_id = $request->parent_id;
        } elseif($level == 3) {
            $request->validate([
                'parent_id' => 'required|integer|min:1',
            ]);

            $table_name = 'product_category3s';
            $data = new ProductCategory3();
            $data->cat2_id = $request->parent_id;
        } else {
            $request->validate([
                'parent_id' => 'required|integer|min:1',
            ]);

            $table_name = 'product_category4s';
            $data = new ProductCategory4();
            $data->cat3_id = $request->parent_id;
        }

        $data->title = $request->title;
        $data->slug = slugGenerate($request->title, $table_name);
        $data->short_desc = $request->short_desc ?? '';
        $data->detailed_desc = $request->detailed_desc ?? '';

        $data->page_title = $request->page_title ?? '';
        $data->meta_title = $request->meta_title ?? '';
        $data->meta_desc = $request->meta_desc ?? '';
        $data->meta_keyword = $request->meta_keyword ?? '';
        $data->position = positionSet($table_name);

        // image upload
        if (isset($request->icon)) {
            $fileUpload1 = fileUpload($request->icon, 'category-'.$level);

            $data->icon_small = $fileUpload1['file'][0];
            $data->icon_medium = $fileUpload1['file'][1];
            $data->icon_large = $fileUpload1['file'][2];
            $data->icon_org = $fileUpload1['file'][3];
        }

        // image upload
        if (isset($request->banner)) {
            $fileUpload2 = fileUpload($request->banner, 'category-'.$level);

            $data->banner_small = $fileUpload2['file'][0];
            $data->banner_medium = $fileUpload2['file'][1];
            $data->banner_large = $fileUpload2['file'][2];
            $data->banner_org = $fileUpload2['file'][3];
        }

        $data->save();

        return redirect()->route('admin.product.category.list.all', $level)->with('success', 'New category created successfully');
    }

    public function detail(Request $request, $level, $id)
    {
        if($level == 1) $data = ProductCategory1::findOrFail($id);
        elseif($level == 2) $data = ProductCategory2::findOrFail($id);
        elseif($level == 3) $data = ProductCategory3::findOrFail($id);
        else $data = ProductCategory4::findOrFail($id);

        return view('admin.category.detail', compact('data', 'level'));
    }

    public function edit(Request $request, $level, $id)
    {
        if($level == 1) {
            $data = ProductCategory1::findOrFail($id);
            $parentCategory = [];
        } elseif($level == 2) {
            $data = ProductCategory2::findOrFail($id);
            $parentCategory = ProductCategory1::where('status', 1)->orderBy('position')->get();
        } elseif($level == 3) {
            $data = ProductCategory3::findOrFail($id);
            $parentCategory = ProductCategory2::where('status', 1)->orderBy('position')->get();
        } else {
            $data = ProductCategory4::findOrFail($id);
            $parentCategory = ProductCategory3::where('status', 1)->orderBy('position')->get();
        }

        return view('admin.category.edit', compact('data', 'level', 'parentCategory'));
    }

    public function update(Request $request, $level)
    {
        // dd($request->all());

        $request->validate([
            'id' => 'required|integer|min:1',
            'title' => 'required|string|min:2|max:255',
            'short_desc' => 'nullable|string|min:2|max:1000',
            'detailed_desc' => 'nullable|string|min:2',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',

            'page_title' => 'nullable|string|min:1',
            'meta_title' => 'nullable|string|min:1',
            'meta_desc' => 'nullable|string|min:1',
            'meta_keyword' => 'nullable|string|min:1'
        ], [
            'icon.max' => 'The icon must not be greater than 1MB.',
            'banner.max' => 'The icon must not be greater than 1MB.',
        ]);

        if($level == 1) {
            $table_name = 'product_category1s';
            $data = ProductCategory1::findOrFail($request->id);
        } elseif($level == 2) {
            $request->validate([
                'parent_id' => 'required|integer|min:1',
            ]);

            $table_name = 'product_category2s';
            $data = ProductCategory2::findOrFail($request->id);
            $data->cat1_id = $request->parent_id;
        } elseif($level == 3) {
            $request->validate([
                'parent_id' => 'required|integer|min:1',
            ]);

            $table_name = 'product_category3s';
            $data = ProductCategory3::findOrFail($request->id);
            $data->cat2_id = $request->parent_id;
        } else {
            $request->validate([
                'parent_id' => 'required|integer|min:1',
            ]);

            $table_name = 'product_category4s';
            $data = ProductCategory4::findOrFail($request->id);
            $data->cat3_id = $request->parent_id;
        }

        $data->title = $request->title;
        $data->slug = slugGenerate($request->title, $table_name);
        $data->short_desc = $request->short_desc ?? '';
        $data->detailed_desc = $request->detailed_desc ?? '';

        $data->page_title = $request->page_title ?? '';
        $data->meta_title = $request->meta_title ?? '';
        $data->meta_desc = $request->meta_desc ?? '';
        $data->meta_keyword = $request->meta_keyword ?? '';

        // image upload
        if (isset($request->icon)) {
            $fileUpload1 = fileUpload($request->icon, 'category-'.$level);

            $data->icon_small = $fileUpload1['file'][0];
            $data->icon_medium = $fileUpload1['file'][1];
            $data->icon_large = $fileUpload1['file'][2];
            $data->icon_org = $fileUpload1['file'][3];
        }

        // image upload
        if (isset($request->banner)) {
            $fileUpload2 = fileUpload($request->banner, 'category-'.$level);

            $data->banner_small = $fileUpload2['file'][0];
            $data->banner_medium = $fileUpload2['file'][1];
            $data->banner_large = $fileUpload2['file'][2];
            $data->banner_org = $fileUpload2['file'][3];
        }

        $data->save();

        return redirect()->route('admin.product.category.list.all', $level)->with('success', 'Category updated successfully');
    }

    public function delete(Request $request, $level, $id)
    {
        if($level == 1) {
            $data = ProductCategory1::findOrFail($id)->delete();
        } elseif($level == 2) {
            $data = ProductCategory2::findOrFail($id)->delete();
        } elseif($level == 3) {
            $data = ProductCategory3::findOrFail($id)->delete();
        } else {
            $data = ProductCategory4::findOrFail($id)->delete();
        }

        return redirect()->route('admin.product.category.list.all', $level)->with('success', 'Category deleted successfully');
    }

    public function status(Request $request, $level, $id)
    {
        if($level == 1) {
            $data = ProductCategory1::findOrFail($id);
        } elseif($level == 2) {
            $data = ProductCategory2::findOrFail($id);
        } elseif($level == 3) {
            $data = ProductCategory3::findOrFail($id);
        } else {
            $data = ProductCategory4::findOrFail($id);
        }

        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }

    public function position(Request $request, $level)
    {
        $request->validate([
            'position' => 'required|array',
            'position.*' => 'required|integer|min:1'
        ]);

        $count = 1;
        foreach($request->position as $position) {
            // $data = ProductCategory1::findOrFail($position);
            if($level == 1) {
                $data = ProductCategory1::findOrFail($position);
            } elseif($level == 2) {
                $data = ProductCategory2::findOrFail($position);
            } elseif($level == 3) {
                $data = ProductCategory3::findOrFail($position);
            } else {
                $data = ProductCategory4::findOrFail($position);
            }

            $data->position = $count;
            $data->save();

            $count++;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Position updated',
        ]);
    }

    public function fetchByParent(Request $request, $level)
    {
        $request->validate([
            'data' => 'required|array',
            'data.*' => 'required|integer|min:1',
        ]);

        $resp = [];
        foreach($request->data as $index => $cat_id) {
            if($level == 2) {
                $data = ProductCategory2::select('id', 'title', 'icon_small')->where('status', 1)->where('cat1_id', $cat_id)->orderBy('position')->get();
            } elseif($level == 3) {
                $data = ProductCategory3::select('id', 'title', 'icon_small')->where('status', 1)->where('cat2_id', $cat_id)->orderBy('position')->get();
            } else {
                $data = ProductCategory4::select('id', 'title', 'icon_small')->where('status', 1)->where('cat3_id', $cat_id)->orderBy('position')->get();
            }

            if(!empty($data) && count($data) > 0) {
                foreach($data as $singleData) {
                    $resp[] = [
                        'id' => $singleData->id,
                        'title' => $singleData->title,
                        'icon' => $singleData->icon_small ? asset($singleData->icon_small) : '',
                    ];
                }
            }
        }

        if(!empty($resp) && count($resp) > 0) {
            return response()->json([
                'status' => 200,
                'message' => 'Category data found',
                'data' => $resp,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Category data not found'
            ]);
        }
    }

    public function fetchByParentEdit(Request $request, $level)
    {
        $request->validate([
            'data' => 'required|array',
            'data.*' => 'required|integer|min:1',
            'id' => 'required|integer|min:1',
        ]);

        $resp = [];
        foreach($request->data as $index => $cat_id) {
            if($level == 2) {
                $data = ProductCategory2::select('id', 'title', 'icon_small')->where('status', 1)->where('cat1_id', $cat_id)->orderBy('position')->get();
            } elseif($level == 3) {
                $data = ProductCategory3::select('id', 'title', 'icon_small')->where('status', 1)->where('cat2_id', $cat_id)->orderBy('position')->get();
            } else {
                $data = ProductCategory4::select('id', 'title', 'icon_small')->where('status', 1)->where('cat3_id', $cat_id)->orderBy('position')->get();
            }

            $check = ProductCategory::where('product_id', $request->id)->where('level', $level)->pluck('category_id')->toArray();

            if(!empty($data) && count($data) > 0) {
                foreach($data as $singleData) {
                    $resp[] = [
                        'id' => $singleData->id,
                        'title' => $singleData->title,
                        'icon' => $singleData->icon_small ? asset($singleData->icon_small) : '',
                        'checked' => (collect($check)->contains($singleData->id)) ? 'checked' : ''
                    ];
                }
            }
        }

        if(!empty($resp) && count($resp) > 0) {
            return response()->json([
                'status' => 200,
                'message' => 'Category data found',
                'data' => $resp,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Category data not found'
            ]);
        }
    }
}
