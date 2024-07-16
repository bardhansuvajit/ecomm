<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Currency;
use App\Models\ProductPricing;
use App\Models\ProductHighlight;
use App\Models\ProductImage;
use App\Models\ProductUsageInstruction;
use App\Models\ProductBoxItem;
use App\Models\ProductIngredient;
use App\Models\ProductCategory1;
use App\Models\ProductCategory2;
use App\Models\ProductCategory3;
use App\Models\ProductCategory4;
use App\Models\Collection;
use App\Models\ProductCollection;

class ProductSetupController extends Controller
{
    public function category(Request $request)
    {
        $activeCategories1 = ProductCategory1::where('status', 1)->orderBy('position')->get();
        $activeCategories2 = ProductCategory2::where('status', 1)->orderBy('position')->get();
        $activeCategories3 = ProductCategory3::where('status', 1)->orderBy('position')->get();
        $activeCategories4 = ProductCategory4::where('status', 1)->orderBy('position')->get();
        $activeCollections = Collection::where('status', 1)->orderBy('position')->get();

        return view('admin.product.setup.category', compact('activeCategories1', 'activeCategories2','activeCategories3', 'activeCategories4', 'activeCollections'));
    }

    public function title(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.setup.title', compact('request', 'data'));
    }

    public function price(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        $currencies = Currency::where('status', 1)->orderBy('position')->get();
        $productCurrencies = ProductPricing::where('product_id', $id)->get();
        return view('admin.product.setup.price', compact('request', 'data', 'currencies', 'productCurrencies'));
    }

    public function images(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.setup.image', compact('request', 'data'));
    }

    public function highlights(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.setup.highlight', compact('request', 'data'));
    }

    public function ingredient(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.setup.ingredient', compact('request', 'data'));
    }

    public function description(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.setup.description', compact('request', 'data'));
    }

    public function usage(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.setup.usage-instruction', compact('request', 'data'));
    }

    public function boxitem(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.setup.box-item', compact('request', 'data'));
    }

    public function seo(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.setup.seo', compact('request', 'data'));
    }

    public function variation(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.setup.variation', compact('request', 'data'));
    }

    public function variationParentPosition(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.setup.variation-parent-position', compact('request', 'data'));
    }

    public function categoryEdit(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        $activeCategories1 = ProductCategory1::where('status', 1)->orderBy('position')->get();
        $activeCategories2 = ProductCategory2::where('status', 1)->orderBy('position')->get();
        $activeCategories3 = ProductCategory3::where('status', 1)->orderBy('position')->get();
        $activeCategories4 = ProductCategory4::where('status', 1)->orderBy('position')->get();
        $activeCollections = Collection::where('status', 1)->orderBy('position')->get();

        $category1s = ProductCategory::where('product_id', $id)->where('level', 1)->pluck('category_id')->toArray();
        $category2s = ProductCategory::where('product_id', $id)->where('level', 2)->pluck('category_id')->toArray();
        $category3s = ProductCategory::where('product_id', $id)->where('level', 3)->pluck('category_id')->toArray();
        $category4s = ProductCategory::where('product_id', $id)->where('level', 4)->pluck('category_id')->toArray();
        $collections = ProductCollection::where('product_id', $id)->pluck('collection_id')->toArray();

        return view('admin.product.setup.category-edit', compact('activeCategories1', 'activeCategories2', 'activeCategories3', 'activeCategories4', 'activeCollections', 'request', 'data', 'category1s', 'category2s', 'category3s', 'category4s', 'collections'));
    }

    public function categoryStore(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'type' => 'required|integer|min:1',
            'category1_id' => 'required|array|min:1',
            'category1_id.*' => 'required|integer|min:1',
            'collection_id' => 'required|array|min:1',
            'collection_id.*' => 'required|integer|min:1',

            'category2_id' => 'nullable|array|min:1',
            'category2_id.*' => 'nullable|integer|min:1',
            'category3_id' => 'nullable|array|min:1',
            'category3_id.*' => 'nullable|integer|min:1',
            'category4_id' => 'nullable|array|min:1',
            'category4_id.*' => 'nullable|integer|min:1',
        ], [
            'category1_id.required' => 'Select at least one category',
            'collection_id.required' => 'Select at least one collection',
        ]);

        DB::beginTransaction();

        try {
            $product = new Product();
            $product->type = $request->type;
            $product->status = 0;
            $product->save();

            // level 1
            if(!empty($request->category1_id) && count($request->category1_id) > 0) {
                foreach ($request->category1_id as $key => $category1_id) {
                    $productCat = new ProductCategory();
                    $productCat->product_id = $product->id;
                    $productCat->category_id = $category1_id;
                    $productCat->level = 1;
                    $productCat->save();
                }
            }

            // level 2
            if(!empty($request->category2_id) && count($request->category2_id) > 0) {
                foreach ($request->category2_id as $key => $category2_id) {
                    $productCat = new ProductCategory();
                    $productCat->product_id = $product->id;
                    $productCat->category_id = $category2_id;
                    $productCat->level = 2;
                    $productCat->save();
                }
            }

            // level 3
            if(!empty($request->category3_id) && count($request->category3_id) > 0) {
                foreach ($request->category3_id as $key => $category3_id) {
                    $productCat = new ProductCategory();
                    $productCat->product_id = $product->id;
                    $productCat->category_id = $category3_id;
                    $productCat->level = 3;
                    $productCat->save();
                }
            }

            // level 4
            if(!empty($request->category4_id) && count($request->category4_id) > 0) {
                foreach ($request->category4_id as $key => $category4_id) {
                    $productCat = new ProductCategory();
                    $productCat->product_id = $product->id;
                    $productCat->category_id = $category4_id;
                    $productCat->level = 4;
                    $productCat->save();
                }
            }

            // collection
            if(!empty($request->collection_id) && count($request->collection_id) > 0) {
                foreach ($request->collection_id as $key => $collection_id) {
                    $productCat = new ProductCollection();
                    $productCat->product_id = $product->id;
                    $productCat->collection_id = $collection_id;
                    $productCat->save();
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        return redirect()->route('admin.product.setup.title', $product->id)->with('success', 'New product creation started');
    }

    public function titleUpdate(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|min:10|max:1000',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($request->product_id);
            $product->title = $request->title;
            $product->slug = slugGenerate($request->title, 'products');
            $product->short_description = $request->short_description;

            $product->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        return redirect()->route('admin.product.setup.price', $product->id)->with('success', 'Product title setup successfull');
    }

    public function priceUpdate(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'currency_id' => 'required|array|min:1',
            'currency_id.*' => 'required|integer|min:1',

            'cost' => 'nullable|array',
            'cost.*' => 'nullable|regex:/^\d{1,13}(\.\d{1,4})?$/|min:1',
            'mrp' => 'nullable|array|min:1',
            'mrp.*' => 'nullable|regex:/^\d{1,13}(\.\d{1,4})?$/|min:1|gt:selling_price.*',
            'selling_price' => 'required|array',
            'selling_price.*' => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/|min:1|gt:cost.*',
        ], [
            'currency_id.*.integer' => 'Currency must be an integer',
            'cost.*.integer' => 'Cost must be an integer',
            'mrp.*.integer' => 'MRP must be an integer',
            'mrp.*.gt' => 'The MRP must be greater than selling price',
            'selling_price.*.integer' => 'Selling price must be an integer',
            'selling_price.*.gt' => 'The selling price must be greater than cost',
        ]);

        // dd('here');

        DB::beginTransaction();

        try {
            // check if pricing already exists
            foreach($request->currency_id as $currencyIndex => $currency) {
                $checkPricing = ProductPricing::where('product_id', $request->product_id)->where('currency_id', $currency)->first();

                if (!empty($checkPricing)) {
                    $pricing = ProductPricing::findOrFail($checkPricing->id);
                } else {
                    $pricing = new ProductPricing();
                }

                $pricing->product_id = $request->product_id;
                $pricing->currency_id = $currency;
                $pricing->cost = $request->cost[$currencyIndex] ?? null;
                $pricing->mrp = $request->mrp[$currencyIndex] ?? null;
                $pricing->selling_price = $request->selling_price[$currencyIndex];
                $pricing->save();
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        return redirect()->route('admin.product.setup.images', $request->product_id)->with('success', 'Product price setup successfull');
    }

    public function imagesUpdate(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
        ], [
            'images.max' => 'The image must not be greater than 1MB.',
        ]);

        DB::beginTransaction();

        try {
            // $product = Product::findOrFail($request->product_id);
            // images
            if (!empty($request->images) && count($request->images) > 0) {
                foreach($request->images as $key => $image) {
                    $fileUpload = fileUpload($image, 'product-image');

                    // dd($fileUpload);

                    $productItem = new ProductImage();
                    $productItem->product_id = $request->product_id;
                    $productItem->img_small = $fileUpload['file'][0];
                    $productItem->img_medium = $fileUpload['file'][1];
                    $productItem->img_large = $fileUpload['file'][2];
                    $productItem->position = positionSet('product_images');
                    $productItem->save();
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        return redirect()->route('admin.product.setup.highlights', $request->product_id)->with('success', 'Product image setup successfull');
    }

    public function imageDelete(Request $request, $id)
    {
        $data = ProductImage::findOrFail($id);

        File::delete($data->img_small);
        File::delete($data->img_medium);
        File::delete($data->img_large);
        $data->delete();

        return redirect()->back()->with('success', 'Product image deleted');
    }

    public function imagesPositionUpdate(Request $request)
    {
        $request->validate([
            'position' => 'required|array',
            'position.*' => 'required|integer|min:1'
        ]);

        $count = 1;
        foreach($request->position as $position) {
            $data = ProductImage::findOrFail($position);
            $data->position = $count;
            $data->save();

            $count++;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Position updated',
        ]);
    }

    public function imagesStatus(Request $request, $id)
    {
        $data = ProductImage::findOrFail($id);
        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }

    public function highlightsUpdate(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'title' => 'required|string|min:2|max:255',
            'details' => 'nullable|string|min:2|max:1000',
        ], [
            'image.max' => 'The image must not be greater than 1MB.',
        ]);

        DB::beginTransaction();

        try {
            $usage = new ProductHighlight();
            $usage->product_id = $request->product_id;

            // image upload
            if (isset($request->image)) {
                $fileUpload = fileUpload($request->image, 'highlight');

                $usage->image_small = $fileUpload['file'][0];
                $usage->image_medium = $fileUpload['file'][1];
                $usage->image_large = $fileUpload['file'][2];
            }

            $usage->title = $request->title;
            $usage->details = $request->details ?? '';
            $usage->position = positionSet('product_highlights');

            $usage->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        return redirect()->route('admin.product.setup.highlights', $request->product_id)->with('success', 'Product highlight setup successfull');
    }

    public function highlightPosition(Request $request)
    {
        $request->validate([
            'position' => 'required|array',
            'position.*' => 'required|integer|min:1'
        ]);

        $count = 1;
        foreach($request->position as $position) {
            $data = ProductHighlight::findOrFail($position);
            $data->position = $count;
            $data->save();

            $count++;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Position updated',
        ]);
    }

    public function highlightStatus(Request $request, $id)
    {
        $data = ProductHighlight::findOrFail($id);
        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }

    public function highlightDelete(Request $request, $id)
    {
        $data = ProductHighlight::findOrFail($id);

        File::delete($data->image_small);
        File::delete($data->image_medium);
        File::delete($data->image_large);
        $data->delete();

        return redirect()->back()->with('success', 'Product highlight deleted');
    }

    public function ingredientUpdate(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'title' => 'required|string|min:2|max:255',
            'details' => 'nullable|string|min:2|max:1000',
        ], [
            'image.max' => 'The image must not be greater than 1MB.',
        ]);

        DB::beginTransaction();

        try {
            $usage = new ProductIngredient();
            $usage->product_id = $request->product_id;

            // image upload
            if (isset($request->image)) {
                $fileUpload = fileUpload($request->image, 'ingredient');

                $usage->image_small = $fileUpload['file'][0];
                $usage->image_medium = $fileUpload['file'][1];
                $usage->image_large = $fileUpload['file'][2];
            }

            $usage->title = $request->title;
            $usage->details = $request->details ?? '';
            $usage->position = positionSet('product_ingredients');

            $usage->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        return redirect()->route('admin.product.setup.ingredient', $request->product_id)->with('success', 'Product ingredient setup successfull');
    }

    public function ingredientPosition(Request $request)
    {
        $request->validate([
            'position' => 'required|array',
            'position.*' => 'required|integer|min:1'
        ]);

        $count = 1;
        foreach($request->position as $position) {
            $data = ProductIngredient::findOrFail($position);
            $data->position = $count;
            $data->save();

            $count++;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Position updated',
        ]);
    }

    public function ingredientStatus(Request $request, $id)
    {
        $data = ProductIngredient::findOrFail($id);
        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }

    public function ingredientDelete(Request $request, $id)
    {
        $data = ProductIngredient::findOrFail($id);

        File::delete($data->image_small);
        File::delete($data->image_medium);
        File::delete($data->image_large);
        $data->delete();

        return redirect()->back()->with('success', 'Product ingredient deleted');
    }

    public function descriptionUpdate(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'description' => 'required|string|min:10',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($request->product_id);
            $product->long_description = $request->description;

            $product->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        return redirect()->route('admin.product.setup.usage', $product->id)->with('success', 'Product description setup successfull');
    }

    public function seoUpdate(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'page_title' => 'nullable|string|min:1',
            'meta_title' => 'nullable|string|min:1',
            'meta_desc' => 'nullable|string|min:1',
            'meta_keyword' => 'nullable|string|min:1'
        ]);

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($request->product_id);

            $product->page_title = $request->page_title ?? '';
            $product->meta_title = $request->meta_title ?? '';
            $product->meta_desc = $request->meta_desc ?? '';
            $product->meta_keyword = $request->meta_keyword ?? '';

            $product->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        return redirect()->route('admin.product.detail', $product->id)->with('success', 'Product setup successfull');
    }

    public function categoryUpdate(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'type' => 'required|integer|min:1',
            'category1_id' => 'required|array|min:1',
            'category1_id.*' => 'required|integer|min:1',
            'collection_id' => 'required|array|min:1',
            'collection_id.*' => 'required|integer|min:1',

            'category2_id' => 'nullable|array|min:1',
            'category2_id.*' => 'nullable|integer|min:1',
            'category3_id' => 'nullable|array|min:1',
            'category3_id.*' => 'nullable|integer|min:1',
            'category4_id' => 'nullable|array|min:1',
            'category4_id.*' => 'nullable|integer|min:1',
        ], [
            'category1_id.required' => 'Select at least one category',
            'collection_id.required' => 'Select at least one collection',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($request->product_id);
            $product->type = $request->type;
            $product->save();

            // remove all previous category & collection
            ProductCategory::where('product_id', $product->id)->delete();
            ProductCollection::where('product_id', $product->id)->delete();

            // level 1
            if(!empty($request->category1_id) && count($request->category1_id) > 0) {
                foreach ($request->category1_id as $key => $category1_id) {
                    $productCat = new ProductCategory();
                    $productCat->product_id = $product->id;
                    $productCat->category_id = $category1_id;
                    $productCat->level = 1;
                    $productCat->save();
                }
            }

            // level 2
            if(!empty($request->category2_id) && count($request->category2_id) > 0) {
                foreach ($request->category2_id as $key => $category2_id) {
                    $productCat = new ProductCategory();
                    $productCat->product_id = $product->id;
                    $productCat->category_id = $category2_id;
                    $productCat->level = 2;
                    $productCat->save();
                }
            }

            // level 3
            if(!empty($request->category3_id) && count($request->category3_id) > 0) {
                foreach ($request->category3_id as $key => $category3_id) {
                    $productCat = new ProductCategory();
                    $productCat->product_id = $product->id;
                    $productCat->category_id = $category3_id;
                    $productCat->level = 3;
                    $productCat->save();
                }
            }

            // level 4
            if(!empty($request->category4_id) && count($request->category4_id) > 0) {
                foreach ($request->category4_id as $key => $category4_id) {
                    $productCat = new ProductCategory();
                    $productCat->product_id = $product->id;
                    $productCat->category_id = $category4_id;
                    $productCat->level = 4;
                    $productCat->save();
                }
            }

            // collection
            if(!empty($request->collection_id) && count($request->collection_id) > 0) {
                foreach ($request->collection_id as $key => $collection_id) {
                    $productCat = new ProductCollection();
                    $productCat->product_id = $product->id;
                    $productCat->collection_id = $collection_id;
                    $productCat->save();
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        /*
        $request->validate([
            'product_id' => 'required|integer|min:1',
            'type' => 'required|integer|min:1',
            'category_id' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($request->product_id);
            $product->type = $request->type;
            $product->category_id = $request->category_id;
            $product->status = 0;

            $product->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
        */

        return redirect()->route('admin.product.setup.title', $request->product_id)->with('success', 'Product category setup successfull');
    }
    
    public function usageUpdate(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'title' => 'required|string|min:2|max:255',
            'details' => 'nullable|string|min:2|max:1000',
        ], [
            'image.max' => 'The image must not be greater than 1MB.',
        ]);

        DB::beginTransaction();

        try {
            $usage = new ProductUsageInstruction();
            $usage->product_id = $request->product_id;

            // image upload
            if (isset($request->image)) {
                $fileUpload = fileUpload($request->image, 'usage-instruction');

                $usage->image_small = $fileUpload['file'][0];
                $usage->image_medium = $fileUpload['file'][1];
                $usage->image_large = $fileUpload['file'][2];
            }

            $usage->title = $request->title;
            $usage->details = $request->details ?? '';
            $usage->position = positionSet('product_usage_instructions');

            $usage->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        return redirect()->route('admin.product.setup.usage', $request->product_id)->with('success', 'Product usage instruction setup successfull');
    }

    public function usagePosition(Request $request)
    {
        $request->validate([
            'position' => 'required|array',
            'position.*' => 'required|integer|min:1'
        ]);

        $count = 1;
        foreach($request->position as $position) {
            $data = ProductUsageInstruction::findOrFail($position);
            $data->position = $count;
            $data->save();

            $count++;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Position updated',
        ]);
    }

    public function usageStatus(Request $request, $id)
    {
        $data = ProductUsageInstruction::findOrFail($id);
        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }

    public function usageDelete(Request $request, $id)
    {
        $data = ProductUsageInstruction::findOrFail($id);

        File::delete($data->image_small);
        File::delete($data->image_medium);
        File::delete($data->image_large);
        $data->delete();

        return redirect()->back()->with('success', 'Product instruction deleted');
    }
    
    public function boxitemUpdate(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
            'title' => 'required|string|min:2|max:255',
            'details' => 'nullable|string|min:2|max:1000',
        ], [
            'image.max' => 'The image must not be greater than 1MB.',
        ]);

        DB::beginTransaction();

        try {
            $item = new ProductBoxItem();
            $item->product_id = $request->product_id;

            // image upload
            if (isset($request->image)) {
                $fileUpload = fileUpload($request->image, 'box-item');

                $item->image_small = $fileUpload['file'][0];
                $item->image_medium = $fileUpload['file'][1];
                $item->image_large = $fileUpload['file'][2];
            }

            $item->title = $request->title;
            $item->details = $request->details ?? '';
            $item->position = positionSet('product_box_items');

            $item->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        return redirect()->route('admin.product.setup.boxitem', $request->product_id)->with('success', 'Product box item setup successfull');
    }

    public function boxitemPosition(Request $request)
    {
        $request->validate([
            'position' => 'required|array',
            'position.*' => 'required|integer|min:1'
        ]);

        $count = 1;
        foreach($request->position as $position) {
            $data = ProductBoxItem::findOrFail($position);
            $data->position = $count;
            $data->save();

            $count++;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Position updated',
        ]);
    }

    public function boxitemStatus(Request $request, $id)
    {
        $data = ProductBoxItem::findOrFail($id);
        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }

    public function boxitemDelete(Request $request, $id)
    {
        $data = ProductBoxItem::findOrFail($id);

        File::delete($data->image_small);
        File::delete($data->image_medium);
        File::delete($data->image_large);
        $data->delete();

        return redirect()->back()->with('success', 'Product box item deleted');
    }

}
