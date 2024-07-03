<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use App\Models\Order;
use App\Models\ProductCategory1;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Currency;
use App\Models\IpCountry;
use App\Models\CouponDiscount;
use App\Models\CouponProduct;
use App\Models\CouponMinimumCartAmount;
use App\Models\ApplicationSetting;
use App\Models\ImageSize;
use App\Models\BlogCategorySetup;
use App\Models\MailLog;
use App\Models\MailFileSetup;
use App\Models\ProductStatus;

// Fetch application settings
if(!function_exists('applicationSettings')) {
    function applicationSettings(): object {
        $settings = ApplicationSetting::first();
        return $settings;
    }
}

// IP fetch
if(!function_exists('ipfetch')) {
    function ipfetch(): string {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// IP to currency
if(!function_exists('ipToCurrency')) {
    function ipToCurrency(): object {
        $currencyData = IpCountry::where('ip_address', $_SERVER['REMOTE_ADDR'])->first();
        return $currencyData;
    }
}

// Match country while adding address
if(!function_exists('countryMatch')) {
    function countryMatch($country): bool {
        $ipCountry = ipToCurrency()->country;

        if ($country == $ipCountry) {
            return true;
        } else {
            return false;
        }
    }
}

// generate slug
if (!function_exists('slugGenerate')) {
    function slugGenerate($title, $tableName) {
        $slug = Str::slug($title, '-');

        $slugExistCount = DB::table($tableName)->select('id')
        ->where('title', $title)
        ->orWhere('slug', $slug)
        ->count();

        if ($slugExistCount > 0) {
            $slug = $slug.'-'. ($slugExistCount + 1);
        }
        return $slug;
    }
}

// generate unique alpha numeric digit
if (!function_exists('mt_rand_custom')) {
    function mt_rand_custom(int $length_of_string) {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}

// generate human readable date
if (!function_exists('h_date')) {
    function h_date(string $date) {
        return date('j F Y, g:i A', strtotime($date));
    }
}

// generate human readable date only
if (!function_exists('h_date_only')) {
    function h_date_only(string $date) {
        return date('j F Y', strtotime($date));
    }
}

// calculate discount
if (!function_exists('discountCalculate')) {
    function discountCalculate($sellingPrice, $price) {
        if ($sellingPrice < $price && $sellingPrice != $price) {
            $diff = $price - $sellingPrice;
            return ceil(($diff / $price) * 100).'%';
        } else {
            return false;
        }
    }
}

// generate sequencial order number
if (!function_exists('orderNumberGenerate')) {
    function orderNumberGenerate() {
        $textSec = "TZ";
        $midSec = "00";
        $sequenceStartsAt = 5250;

        $orderExistsCount = Order::count();
        if(empty($orderExistsCount)) {
            $orderSeq = $sequenceStartsAt;
        } else {
            $orderSeq = (int) $sequenceStartsAt + $orderExistsCount;
        }

        $ordNo = sprintf("%'.05d", $orderSeq);
        $order_no = $textSec.$midSec.$orderSeq;

        return $order_no;
    }
}

// file upload
if (!function_exists('fileUpload')) {
    function fileUpload($file, $folder = 'image') {
        $fileName = mt_rand_custom(20);
        $fileExtension = $file->getClientOriginalExtension();
        $uploadPath = 'uploads/'.$folder.'/';
        $filePath = $uploadPath.$fileName.'.'.$fileExtension;
        $tmpPath = $file->getRealPath();
        $mimeType = \File::mimeType($file);

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 666, true);
        }

        // images only
        if (in_array($fileExtension, ['jpeg', 'png', 'jpg', 'gif', 'webp'])) {
            if (
                $fileExtension == "jpeg" ||
                $fileExtension == "png" ||
                $fileExtension == "jpg" ||
                $fileExtension == "webp"
            ) {
                // THUMBNAIL CREATE HERE
                $smallImagePath = $uploadPath.$fileName.'_small-thumb_'.'.'.$fileExtension;
                $mediumImagePath = $uploadPath.$fileName.'_medium-thumb_'.'.'.$fileExtension;
                $largeImagePath = $uploadPath.$fileName.'_large-thumb_'.'.'.$fileExtension;

                createThumbnail($tmpPath, $smallImagePath, null, 100);
                createThumbnail($tmpPath, $mediumImagePath, null, 250);
                createThumbnail($tmpPath, $largeImagePath, null, 500);
                $largeOne = $largeImagePath;
            } else {
                // THUMBNAIL CREATE HERE
                $smallImagePath = $uploadPath.$fileName.'_small-thumb_'.'.jpg';
                $mediumImagePath = $uploadPath.$fileName.'_medium-thumb_'.'.jpg';

                createThumbnail($tmpPath, $smallImagePath, null, 100);
                createThumbnail($tmpPath, $mediumImagePath, null, 250);
                // $file->move(public_path($uploadPath), $fileName.'.'.$fileExtension);
                $file->move($uploadPath, $fileName.'.'.$fileExtension);
                $largeOne = $filePath;
            }

            $originalImagePath = $uploadPath.$fileName.'_original_'.'.'.$fileExtension;
            $file->move($uploadPath, $originalImagePath);

            $resp = [
                'type' => $mimeType,
                'extension' => $fileExtension,
                'file' => [
                    $smallImagePath,
                    $mediumImagePath,
                    $largeOne,
                    $originalImagePath
                ],
            ];
        }
        else {
            // $file->move(public_path($uploadPath), $fileName.'.'.$fileExtension);
            $file->move($uploadPath, $fileName.'.'.$fileExtension);

            $resp = [
                'type' => $mimeType,
                'extension' => $fileExtension,
                'file' => [
                    $filePath,
                    $filePath,
                    $filePath,
                    $filePath
                ],
            ];
        }

        return $resp;
    }
}

if (!function_exists('createThumbnail')) {
    function createThumbnail($tmpPath, $filePath, $width, $height)
    {
        $img = Image::make($tmpPath);
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->save($filePath);
    }
}

if (!function_exists('catLeveltoProducts')) {
    function catLeveltoProducts($cat1_id) {
        $products = [];
        $lvl2_cats = ProductCategory1::select('id')->where('parent_id', $cat1_id)->where('status', 1)->get();

        if (!empty($lvl2_cats) && count($lvl2_cats) > 0) {
            foreach ($lvl2_cats as $key => $lvl2_cat) {
                $lvl3_cats = ProductCategory1::select('id')->where('parent_id', $lvl2_cat['id'])->where('status', 1)->get();

                if (!empty($lvl3_cats) && count($lvl3_cats) > 0) {
                    foreach ($lvl3_cats as $key => $lvl3_cat) {
                        $products = Product::select('id', 'slug', 'title')->where('category_id', $lvl3_cat['id'])->where('status', '!=', 2)->get();
                    }
                }
            }
        }

        return $products;
    }
}

if (!function_exists('catLeve2toProducts')) {
    function catLeve2toProducts($cat2_id) {
        $products = [];
        $lvl3_cats = ProductCategory1::select('id')->where('parent_id', $cat2_id)->where('status', 1)->get();

        if (!empty($lvl3_cats) && count($lvl3_cats) > 0) {
            foreach ($lvl3_cats as $key => $lvl3_cat) {
                $products = Product::select('id', 'slug', 'title')->where('category_id', $lvl3_cat['id'])->where('status', '!=', 2)->get();
            }
        }

        return $products;
    }
}

if (!function_exists('lead_page')) {
    function lead_page($page) {
        if (str_contains($page, 'contact')) {
            return 'Contact page';
        }
        elseif (str_contains($page, 'product')) {
            $explodedProduct = explode('/', $page);
            // dd($explodedProduct);
            $explodedProductCount = count($explodedProduct);

            return $explodedProduct[4];
        }
    }
}

// set current data position
if (!function_exists('positionSet')) {
    function positionSet(string $tableName): int {
        $latestPosition = DB::table($tableName)->select('position')->latest('position')->first();
        if (isset($latestPosition)) {
            return (int) $latestPosition->position + 1;
        } else {
            return 1;
        }
        
    }
}

// product rating calculation
if (!function_exists('ratingCalculation')) {
    function ratingCalculation($reviews) {
        $numberOfReviews = $totalStars = $average = 0;

        if (count($reviews) > 0) {
            foreach($reviews as $review) {
                $numberOfReviews++;
                $totalStars += $review['rating'];
            }
            $average = $totalStars / $numberOfReviews;
            if ($average > 5) $average = 5;
        }
        return round($average, 1);
    }
}

// products categories for admin panel with category link
if (!function_exists('productCategories')) {
    function productCategories(int $productId, int $level, string $type): string {
        $query = ProductCategory::select('category_id', 'title');

        $query->when(($level == 1), function($query) use ($level) {
            $query->join('product_category1s', 'product_category1s.id', '=', 'product_categories.category_id');
        });
        $query->when(($level == 2), function($query) use ($level) {
            $query->join('product_category2s', 'product_category2s.id', '=', 'product_categories.category_id');
        });
        $query->when(($level == 3), function($query) use ($level) {
            $query->join('product_category3s', 'product_category3s.id', '=', 'product_categories.category_id');
        });
        $query->when(($level == 4), function($query) use ($level) {
            $query->join('product_category4s', 'product_category4s.id', '=', 'product_categories.category_id');
        });

        $data = $query->where('product_id', $productId)
        ->where('level', $level)
        ->get();

        $content = '';
        foreach($data as $index => $singleData) {
            $content .= '
            <a href="'.route('admin.product.category.detail', [$level, $singleData->category_id]) .'">
                '.$singleData->title.'
            </a>
            ';

            if ($type == "vertical") {
                $content .= "<br>";
            } else {
                if(count($data) != ($index + 1)) $content .=',';
            }
        }

        return $content;
    }
}

// products categories for admin panel with category link
if (!function_exists('productCategoriesFront')) {
    function productCategoriesFront(int $productId, int $level) {
        $query = ProductCategory::select('category_id', 'title', 'slug');

        $query->when(($level == 1), function($query) use ($level) {
            $query->join('product_category1s', 'product_category1s.id', '=', 'product_categories.category_id');
        });
        $query->when(($level == 2), function($query) use ($level) {
            $query->join('product_category2s', 'product_category2s.id', '=', 'product_categories.category_id');
        });
        $query->when(($level == 3), function($query) use ($level) {
            $query->join('product_category3s', 'product_category3s.id', '=', 'product_categories.category_id');
        });
        $query->when(($level == 4), function($query) use ($level) {
            $query->join('product_category4s', 'product_category4s.id', '=', 'product_categories.category_id');
        });

        $data = $query->where('product_id', $productId)
        ->where('level', $level)
        ->first();

        // $content = [];
        // foreach($data as $index => $singleData) {
        //     $content[] = [

        //     ];
        // }

        return $data;
    }
}

// products categories for frontend with category link
if (!function_exists('productToCategoryFront')) {
    function productToCategoryFront(object $product): string {
        $content = '';
        if ($product->categoryDetails) {
            foreach ($product->categoryDetails as $index => $cat) {
                $content .= '
                <a href="'.route('front.category.detail', $cat->categoryDetails->slug) .'">
                    '.$cat->categoryDetails->title.'
                </a>
                ';

                if(count($product->categoryDetails) != ($index + 1)) $content .=',';
            }
        }

        return $content;
    }
}

// frontend product pricing currency wise
if (!function_exists('productPricing')) {
    function productPricing(object $product): array {
        $resp = [];
        $currencyData = ipToCurrency();
        if (!empty($product->pricing) && count($product->pricing) > 0) {
            foreach($product->pricing as $singlePricing) {
                if ($singlePricing->variation_child_id == 0) {
                    if ($singlePricing->currency_id == $currencyData->currency_id) {
                        $resp = [
                            'mrp' => (float) $singlePricing->mrp, 
                            'selling_price' => (float) $singlePricing->selling_price, 
                            'currency' => (string) $singlePricing->currency->icon,
                            'currency_entity' => (string) $singlePricing->currency->entity,
                            'currency_id' => (string) $singlePricing->currency->id
                        ];
                    }
                }
            }
        }
        return $resp;
    }
}

// rating type color
if(!function_exists('bootstrapRatingTypeColor')) {
    function bootstrapRatingTypeColor(int $rating): string {
        if ($rating <= 5 && $rating >= 4) {
            return 'success';
        } elseif ($rating <= 3.99 && $rating >= 2.01) {
            return 'warning';
        } elseif ($rating <= 2 && $rating >= 0.01) {
            return 'danger';
        } else {
            return 'muted';
        }
    }
}

// currency details
if(!function_exists('currencyDetails')) {
    function currencyDetails(int $id): object {
        $currencyDetails = Currency::findOrFail($id);
        return $currencyDetails;
    }
}

// cart amount
if(!function_exists('cartDetails')) {
    function cartDetails(object $cartContent): array {
        $resp = [];

        $totalCartAmount = $taxApplicable = $taxCharge = $taxPercentage = $shippingChargeMinCartValue = $minimumCartAmountToMaintain = $shippingCharge = $couponApplicable = $couponDiscount = $discountAmount = 0;
        // $orderValueAfterTax = 0;
        $currency = $guestToken = $couponType = $couponName = '';

        $currencyData = ipToCurrency();

        // cart details
        foreach ($cartContent as $cartItem) {
            // get currency details
            $data = productPricing($cartItem->productDetails);
            // $data = productPricing($cartItem->productDetails, $currencyData->currency_id);

            $mrp = $data['mrp'];
            $selling_price = $data['selling_price'];
            $currency = $data['currency'];
            $currency_id = $data['currency_id'];
            $guestToken = $cartItem->guest_token;

            $totalCartAmount += $selling_price * $cartItem->qty;
        }

        // tax calculation
        $appsettings = applicationSettings();
        if ($appsettings->tax_on_order == 1) {
            $taxApplicable = 1;

            $taxPercentage = $currencyData->currencyDetails->order_tax_percentage;
            $taxCharge = ($totalCartAmount * $taxPercentage) / 100;
        }
        // $orderValueAfterTax = $totalCartAmount + $taxCharge;

        // shipping charge on minimum cart value
        if ($appsettings->min_cart_value_shipping_charge == 1) {
            $shippingChargeMinCartValue = 1;

            $minimumCartAmountToMaintain = $currencyData->currencyDetails->minimum_cart_amount;

            if ($totalCartAmount < $minimumCartAmountToMaintain) {
                $shippingCharge = $currencyData->currencyDetails->shipping_amount;
            }
        }

        // coupon applicable or not
        $couponId = $cartContent[0]->coupon_code;
        if ($couponId != 0) {
            $couponApplicable = 1;
            $couponName = $cartContent[0]->couponDetails->code;

            // coupon discount
            $discountDetails = CouponDiscount::where('coupon_id', $cartContent[0]->coupon_code)->where('currency_id', $currencyData->currency_id)->first();

            if (!empty($discountDetails)) {
                $discountType = $discountDetails->discount_type;
                $discountAmount = $discountDetails->discount_amount;
            } else {
                $resp = [
                    'status' => 'failure',
                    'message' => 'Coupon currency issue occured',
                ];
                return $resp;
            }

            // $discountType = $cartContent[0]->couponDetails->couponDiscount->discount_type;
            // $discountAmount = $cartContent[0]->couponDetails->couponDiscount->discount_amount;

            // dd($data);

            // flat discount
            if ($discountType == 1) {
                $couponDiscount = $discountAmount;
                $couponType = 'flat';
            }
            // percent discount
            elseif ($discountType == 2) {
                $couponDiscount = $totalCartAmount * ($discountAmount / 100);
                $couponType = 'percent';
            }
            // is type mismatch
            else {
                $resp = [
                    'status' => 'failure',
                    'message' => 'Coupon type issue occured',
                ];
                return $resp;
            }
        }

        // dd($couponDiscount);

        // final cart value after tax & shipping charge
        $finalCartValue = ($totalCartAmount - $couponDiscount) + ($taxCharge + $shippingCharge);

        $resp = [
            'status' => 'success',
            'guestToken' => (string) $guestToken,
            'totalCartAmount' => $totalCartAmount,
            'currencyId' => (int) $currency_id,
            // 'currencyIcon' => (string) '<i class="'.$currency.'"></i>',
            // 'currencyIconClass' => (string) $currency,
            'currencyEntity' => (string) $currencyData->currencyDetails->entity,

            'taxApplicable' => (int) $taxApplicable,
            'taxPercentage' => $taxPercentage,
            'taxCharge' =>  $taxCharge,
            // 'orderValueAfterTax' => $orderValueAfterTax,

            'shippingChargeMinCartValue' => $shippingChargeMinCartValue,
            'minimumCartAmountToMaintain' => $minimumCartAmountToMaintain,
            'shippingCharge' => $shippingCharge,

            'couponApplicable' => (int) $couponApplicable,
            'couponId' => (int) $couponId,
            'couponType' => (string) $couponType,
            'couponName' => (string) $couponName,
            'couponDiscount' => round($couponDiscount, 2),
            'couponDiscountAmountDB' => $discountAmount,

            'finalCartValue' => round($finalCartValue, 2),
        ];

        return $resp;
    }
}

if(!function_exists('couponDiscountData')) {
    function couponDiscountData(int $couponId, int $currencyId): array {
        $data = CouponDiscount::where('coupon_id', $couponId)->where('currency_id', $currencyId)->first();

        if (!empty($data)) {
            $resp = [
                'status' => 'success',
                'message' => 'Data found',
                'data' => $data,
            ];
        } else {
            $resp = [
                'status' => 'failure',
                'message' => 'Invalid data',
            ];
        }
        return $resp;
    }
}

if(!function_exists('minimumCartMaintainData')) {
    function minimumCartMaintainData(int $couponId, int $currencyId): array {
        $data = CouponMinimumCartAmount::where('coupon_id', $couponId)->where('currency_id', $currencyId)->first();

        if (!empty($data)) {
            $resp = [
                'status' => 'success',
                'message' => 'Data found',
                'data' => $data,
            ];
        } else {
            $resp = [
                'status' => 'failure',
                'message' => 'Invalid data',
            ];
        }
        return $resp;
    }
}

if(!function_exists('couponProductsData')) {
    function couponProductsData(int $couponId, int $productId): string {
        $resp = '';
        $data = CouponProduct::where('coupon_id', $couponId)->where('product_id', $productId)->first();

        if (!empty($data)) {
            $resp = 'selected';
        }
        return $resp;
    }
}

if(!function_exists('imageUploadNotice')) {
    function imageUploadNotice(string $type): array {
        $data = ImageSize::where('type', $type)->first();

        $respText = "Size: less than 1 mb | Extension: .webp for better SEO | Dimensions: <span class='text-danger'>".$data->width.'x'.$data->height.' px</span> (WxH)';
        $respHtml = '<p class="font-weight-bold small text-muted">'.$respText.'</p>';

        return [
            'text' => $respText,
            'html' => $respHtml,
        ];
    }
}

if (!function_exists('category1DetailsAdmin')) {
    function category1DetailsAdmin($blog_id) {
        $categories = BlogCategorySetup::select('blog_category1s.id', 'blog_category1s.title')->where('blog_id', $blog_id)
        ->join('blog_category1s', 'blog_category1s.id', '=', 'blog_category_setups.category_id')
        ->where('level', 1)
        ->where('blog_category1s.status', 1)
        ->get();

        $resp = '';
        foreach($categories as $index => $category) {
            $resp .= '<a href="'.route('admin.blog.category1.detail', $category->id).'">'.$category->title.'</a>';
            if(count($categories) != ($index + 1)) $resp .=', ';
        }

        return $resp;
    }
}

if (!function_exists('category2DetailsAdmin')) {
    function category2DetailsAdmin($blog_id) {
        $categories = BlogCategorySetup::select('blog_category2s.id', 'blog_category2s.title')->where('blog_id', $blog_id)
        ->join('blog_category2s', 'blog_category2s.id', '=', 'blog_category_setups.category_id')
        ->where('level', 2)
        ->where('blog_category2s.status', 1)
        ->get();

        $resp = '';
        foreach($categories as $index => $category) {
            $resp .= '<a href="'.route('admin.blog.category2.detail', $category->id).'">'.$category->title.'</a>';
            if(count($categories) != ($index + 1)) $resp .=', ';
        }

        return $resp;
    }
}

// indian money format
if (!function_exists('indianMoneyFormat')) {
    function indianMoneyFormat($amount) {
        return preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount);
    }
}

// return unique multidimensional array
if (!function_exists('makeUniqueMultidimensionalArray')) {
    function makeUniqueMultidimensionalArray($array, $key) {
        $uniqueValues = [];
        $resultArray = [];

        foreach ($array as $item) {
            $value = $item[$key];
            $qty = $item['qty'];

            if (!isset($uniqueValues[$value]) || $uniqueValues[$value]['qty'] < $qty) {
                $uniqueValues[$value] = $item;
            }
        }

        $resultArray = array_values($uniqueValues);

        return $resultArray;
    }
}

// datetime x mins ago
if (!function_exists('minsAgo')) {
    function minsAgo($dateTime) {
        $seconds_ago = (time() - strtotime($dateTime));

        if ($seconds_ago >= 31536000) {
            $resp = intval($seconds_ago / 31536000) . " years ago";
        } elseif ($seconds_ago >= 2419200) {
            $resp = intval($seconds_ago / 2419200) . " months ago";
        } elseif ($seconds_ago >= 86400) {
            $resp = intval($seconds_ago / 86400) . " days ago";
        } elseif ($seconds_ago >= 3600) {
            $resp = intval($seconds_ago / 3600) . " hours ago";
        } elseif ($seconds_ago >= 120) {
            $resp = intval($seconds_ago / 60) . " minutes ago";
        } 
        // elseif ($seconds_ago >= 60) {
        //     $resp = "a minute ago";
        // } 
        else {
            $resp = "Just now";
        }

        return $resp;
    }
}

// product status
if (!function_exists('showInFrontendProductStatusID')) {
    function showInFrontendProductStatusID() {
        $data = ProductStatus::where('show_in_frontend', 1)->pluck('id')->toArray();
        return $data;
    }
}

// date difference
if (!function_exists('dateDiff')) {
    function dateDiff($date1, $date2) {
        $datediff = strtotime($date1) - strtotime($date2);
        return round($datediff / (60 * 60 * 24));
    }
}

// send mail helper
function SendMail($data)
{
    // mail file setup
    $mailFile = MailFileSetup::where('type', $data['type'])->first();
    // dd($mailFile);

    // mail log
    // $newMail = new MailLog();
    // $newMail->from = $mailFile->mail_from;
    // $newMail->to = $data['target_email'];
    // $newMail->subject = $mailFile->subject;
    // $newMail->blade_file = $data['blade_file'];
    // $newMail->payload = json_encode($data);
    // $newMail->save();

    Mail::send('email-template/forgot-password', [], function ($message){
        $message->to('bardhansuvajit@gmail.com')->subject('Testing mail');
    });

    return '';

    // send mail
    // $mailSend = Mail::send('email-template/'.$mailFile->blade_file, $data, function ($message) use ($data, $mailFile) {
    //     $message->to($data['target_email'], $data['target_name'])
    //     ->subject($mailFile->subject)
    //     ->from($mailFile->mail_from.'@test.com', env('APP_NAME'));
    // });

    // dd($mailSend);
}
