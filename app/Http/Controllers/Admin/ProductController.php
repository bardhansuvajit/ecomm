<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\ProductCategory1;
use App\Models\Product;
use App\Models\ProductKeyFeature;
use App\Models\ProductBoxItem;
use App\Models\ProductManual;
use App\Models\ProductDatasheet;
use App\Models\ProductImage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $activeCategories = ProductCategory1::where('status', 1)->orderBy('title')->get();

        $status = $request->status ?? '';
        $category = $request->category ?? '';
        $keyword = $request->keyword ?? '';

        $query = Product::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%');
        });
        $query->when($category, function($query) use ($category) {
            $query->where('category_id', $category);
        });
        $query->when($status, function($query) use ($status) {
            $query->where('status', $status);
        });

        $data = $query->latest('id')->paginate(25);
        
        // active products only
        $activeProducts = Product::where('status', 1)->orderBy('title')->get();

        return view('admin.product.index', compact('data', 'activeCategories', 'activeProducts'));
    }

    /*
    public function create(Request $request)
    {
        $activeCategories = ProductCategory1::where('status', 1)->orderBy('position')->get();

        return view('admin.product.create-category', compact('activeCategories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'type' => 'required|integer|min:1',
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'category_id' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|min:10|max:1000',
            'key_feature' => 'nullable|array|min:1',
            'box_items' => 'nullable|array|min:1',
            'manual_title' => 'nullable|array|min:1',
            'manual_file' => 'nullable|array|min:1',
            'datasheet_title' => 'nullable|array|min:1',
            'datasheet_file' => 'nullable|array|min:1',
            'overview' => 'nullable',
            'specification' => 'nullable',
            'page_title' => 'nullable|string|min:1',
            'meta_title' => 'nullable|string|min:1',
            'meta_desc' => 'nullable|string|min:1',
            'meta_keyword' => 'nullable|string|min:1'
        ]);

        DB::beginTransaction();

        try {
            $product = new Product();
            $product->type = $request->type;
            $product->title = $request->title;
            $product->slug = slugGenerate($request->title, 'products');
            $product->category_id = $request->category_id;
            $product->short_description = $request->short_description ?? '';
            $product->overview = $request->overview ?? '';
            $product->specification = $request->specification ?? '';

            $product->page_title = $request->page_title ?? '';
            $product->meta_title = $request->meta_title ?? '';
            $product->meta_desc = $request->meta_desc ?? '';
            $product->meta_keyword = $request->meta_keyword ?? '';

            $product->save();

            // images
            if (!empty($request->images) && count($request->images) > 0) {
                foreach($request->images as $key => $image) {
                    $fileUpload = fileUpload($image, 'products');

                    // dd($fileUpload);

                    $productItem = new ProductImage();
                    $productItem->product_id = $product->id;
                    $productItem->img_small = $fileUpload['file'][0];
                    $productItem->img_medium = $fileUpload['file'][1];
                    $productItem->img_large = $fileUpload['file'][2];
                    $productItem->save();
                }
            }

            // key features
            if (count($request->key_feature) > 0 && !empty($request->key_feature[0])) {
                foreach($request->key_feature as $feature) {
                    if (!empty($feature)) {
                        $productFeature = new ProductKeyFeature();
                        $productFeature->product_id = $product->id;
                        $productFeature->title = $feature;
                        $productFeature->save();
                    }
                }
            }

            // box items
            // if (count($request->box_items) > 1) {
            if (count($request->box_items) > 0 && !empty($request->box_items[0])) {
                foreach($request->box_items as $item) {
                    if (!empty($item)) {
                        $productItem = new ProductBoxItem();
                        $productItem->product_id = $product->id;
                        $productItem->title = $item;
                        $productItem->save();
                    }
                }
            }

            // manuals
            // if (count($request->manual_title) > 1) {
            // if (count($request->manual_title) > 0 && !empty($request->manual_title[0])) {
            if (
                count($request->manual_title) > 0 &&
                !empty($request->manual_title[0]) &&
                !empty($request->manual_file) &&
                count($request->manual_file) > 0 &&
                !empty($request->manual_file[0])
            ) {
                foreach($request->manual_title as $key => $manual) {
                    if (!empty($manual)) {
                        $fileUpload = fileUpload($request->manual_file[$key], 'manuals');

                        $productItem = new ProductManual();
                        $productItem->product_id = $product->id;
                        $productItem->title = $manual;
                        $productItem->file_path = $fileUpload['file'][0];
                        $productItem->save();
                    }
                }
            }

            // datasheets
            // if (count($request->datasheet_title) > 1) {
            // if (count($request->datasheet_title) > 0 && !empty($request->datasheet_title[0])) {
            if (
                count($request->datasheet_title) > 0 &&
                !empty($request->datasheet_title[0]) &&
                !empty($request->datasheet_file) &&
                count($request->datasheet_file) > 0 &&
                !empty($request->datasheet_file[0])
            ) {
                foreach($request->datasheet_title as $key => $sheet) {
                    if (!empty($sheet)) {
                        $fileUpload = fileUpload($request->datasheet_file[$key], 'datasheets');

                        $productItem = new ProductDatasheet();
                        $productItem->product_id = $product->id;
                        $productItem->title = $sheet;
                        $productItem->file_path = $fileUpload['file'][0];
                        $productItem->save();
                    }
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        return redirect()->route('admin.product.list.all')->with('success', 'New product created');
    }
    */

    public function detail(Request $request, $id)
    {
        $data = Product::findOrFail($id);

        return view('admin.product.detail', compact('data'));
    }

    /*
    public function edit(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        $activeCategories = ProductCategory1::where('status', 1)->orderBy('title')->get();

        return view('admin.product.edit', compact('data', 'activeCategories'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'type' => 'required|integer|min:1',
            'images' => 'nullable|array|min:1',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'category_id' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|min:10|max:1000',
            'key_feature' => 'nullable|array|min:1',
            'box_items' => 'nullable|array|min:1',
            'manual_title' => 'nullable|array|min:1',
            'manual_file' => 'nullable|array|min:1|required_without:manual_title',
            'datasheet_title' => 'nullable|array|min:1',
            'datasheet_file' => 'nullable|array|min:1|required_without:datasheet_title',
            'overview' => 'nullable',
            'specification' => 'nullable',
            'page_title' => 'nullable|string|min:1',
            'meta_title' => 'nullable|string|min:1',
            'meta_desc' => 'nullable|string|min:1',
            'meta_keyword' => 'nullable|string|min:1'
        ]);

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($request->product_id);
            $product->type = $request->type;
            $product->title = $request->title;
            $product->slug = slugGenerate($request->title, 'products');
            $product->category_id = $request->category_id;
            $product->short_description = $request->short_description ?? '';
            $product->overview = $request->overview ?? '';
            $product->specification = $request->specification ?? '';

            $product->page_title = $request->page_title ?? '';
            $product->meta_title = $request->meta_title ?? '';
            $product->meta_desc = $request->meta_desc ?? '';
            $product->meta_keyword = $request->meta_keyword ?? '';

            $product->save();

            // images
            if (!empty($request->images) && count($request->images) > 0) {
                foreach($request->images as $key => $image) {
                    $fileUpload = fileUpload($image, 'products');

                    // dd($fileUpload);

                    $productItem = new ProductImage();
                    $productItem->product_id = $product->id;
                    $productItem->img_small = $fileUpload['file'][0];
                    $productItem->img_medium = $fileUpload['file'][1];
                    $productItem->img_large = $fileUpload['file'][2];
                    $productItem->save();
                }
            }

            // key features
            // dd($request->key_feature);
            // remove old items
            ProductKeyFeature::where('product_id', $request->product_id)->delete();
            if (count($request->key_feature) > 0 && !empty($request->key_feature[0])) {
                foreach($request->key_feature as $feature) {
                    if (!empty($feature)) {
                        $productFeature = new ProductKeyFeature();
                        $productFeature->product_id = $product->id;
                        $productFeature->title = $feature;
                        $productFeature->save();
                    }
                }
            }

            // box items
            // remove old items
            ProductBoxItem::where('product_id', $request->product_id)->delete();
            if (count($request->box_items) > 0 && !empty($request->box_items[0])) {
                foreach($request->box_items as $item) {
                    if (!empty($item)) {
                        $productItem = new ProductBoxItem();
                        $productItem->product_id = $product->id;
                        $productItem->title = $item;
                        $productItem->save();
                    }
                }
            }

            // manuals
            // remove old items
            // ProductManual::where('product_id', $request->product_id)->delete();
            if (
                count($request->manual_title) > 0 &&
                !empty($request->manual_title[0]) &&
                !empty($request->manual_file) &&
                count($request->manual_file) > 0 &&
                !empty($request->manual_file[0])
            ) {
                foreach($request->manual_title as $key => $manual) {
                    $fileUpload = fileUpload($request->manual_file[$key], 'manuals');

                    $productItem = new ProductManual();
                    $productItem->product_id = $product->id;
                    $productItem->title = $manual;
                    $productItem->file_path = $fileUpload['file'][0];
                    $productItem->save();
                }
            }

            // datasheets
            // remove old items
            // ProductDatasheet::where('product_id', $request->product_id)->delete();
            if (
                count($request->datasheet_title) > 0 &&
                !empty($request->datasheet_title[0]) &&
                !empty($request->datasheet_file) &&
                count($request->datasheet_file) > 0 &&
                !empty($request->datasheet_file[0])
            ) {
                foreach($request->datasheet_title as $key => $sheet) {
                    $fileUpload = fileUpload($request->datasheet_file[$key], 'datasheets');

                    $productItem = new ProductDatasheet();
                    $productItem->product_id = $product->id;
                    $productItem->title = $sheet;
                    $productItem->file_path = $fileUpload['file'][0];
                    $productItem->save();
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        // return redirect()->route('admin.product.list.all')->with('success', 'Product updated');
        return redirect()->back()->with('success', 'Product updated');
    }
    */

    public function delete(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.product.list.all')->with('success', 'Product deleted');
    }

    public function status(Request $request, $id)
    {
        // dd($request->all(), $request->prodId, $request['status'], $request['prodId']);

        $data = Product::findOrFail($id);
        $data->status = $request->status;

        // if($request->status == 3) {
        //     $data->replacement_product_id = $request->prodId;
        // } else {
        //     $data->replacement_product_id = 0;
        // }

        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }

    public function saveDraft(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        $data->status = 0;
        $data->update();

        return redirect()->route('admin.product.detail', $id)->with('success', 'Product saved as draft');

    }
}
