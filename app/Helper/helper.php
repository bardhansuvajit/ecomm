<?php

use App\Models\Order;

// generate unique alpha numeric digit
function mt_rand_custom(int $length_of_string)
{
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($str_result), 0, $length_of_string);
}

// generate human readable date
function h_date(string $date)
{
    return date('j F Y, g:i A', strtotime($date));
}

// calculate discount
function discountCalculate($offerPrice, $price) {
    if ($offerPrice < $price && $offerPrice != $price) {
        $diff = $price - $offerPrice;
        return ceil(($diff / $price) * 100).'%';
    } else {
        return false;
    }
}

// delivery address card HTML
// used in: CART & CHECKOUT page
function deliveryAddressCard(object $address) {
    $changeRoute = route('front.address.index');

    $addressHTML = '
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-10">
                    <div class="single-address">
                        <div class="short_address">
                            <span class="delivery_person">'.$address->full_name.'</span>
                            <span class="delivery_contact">'.$address->mobile_no.'</span>';
                            if ($address->type != 'not specified') {
                                $addressHTML .= '<span class="address_type badge">'.strtoupper($address->type).'</span>';
                            }
        $addressHTML .= '</div>
                        <div class="detailed_address">
                            <p class="deliveryAddress mb-0">
                                '.$address->street_address.',
                                '.$address->city.',
                                '.$address->pincode.',
                                '.$address->locality.',
                                '.$address->state.'
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-2 text-end pt-2">
                    <a href="'.$changeRoute.'" class="small fw-600">CHANGE</a>
                </div>
            </div>
        </div>
    </div>
    ';

    return $addressHTML;
}

// generate sequencial order number
if (!function_exists('orderNumberGenerate')) {
    function orderNumberGenerate() {
        $orderExists = Order::select('id')->latest('id')->first();
        if(empty($orderExists)) $orderSeq = 1;
        else $orderSeq = (int) $orderExists->id + 1;

        $ordNo = sprintf("%'.05d", $orderSeq);
        $order_no = date('y').$ordNo;

        return $order_no;
    }
}

// file upload
if (!function_exists('fileUpload')) {
    function fileUpload($file, $folder = 'image') {
        $fileName = mt_rand_custom(20);
        $imageExtension = $file->getClientOriginalExtension();
        $uploadPath = 'uploads/'.$folder.'/';
        $filePath = $uploadPath.$fileName.'.'.$imageExtension;
        $tmpPath = $file->getRealPath();

        // images only
        if (in_array($imageExtension, ['jpeg', 'png', 'jpg'])) {
            // THUMBNAIL CREATE HERE
            $smallImagePath = $uploadPath.$fileName.'_small-thumb_'.'.'.$imageExtension;
            $mediumImagePath = $uploadPath.$fileName.'_medium-thumb_'.'.'.$imageExtension;
            $largeImagePath = $uploadPath.$fileName.'_large-thumb_'.'.'.$imageExtension;

            createThumbnail($tmpPath, $smallImagePath, null, 100);
            createThumbnail($tmpPath, $mediumImagePath, null, 250);
            createThumbnail($tmpPath, $largeImagePath, null, 500);

            $resp = [$smallImagePath, $mediumImagePath, $largeImagePath];
        } else {
            // dd('no image');
            $file->move(public_path($uploadPath), $fileName.'.'.$imageExtension);
            $resp = [$filePath];
        }

        return $resp;
    }
}

function createThumbnail($tmpPath, $filePath, $width, $height)
{
    $img = Image::make($tmpPath);
    $img->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
    })->save($filePath);
}

// rating show
if (!function_exists('ratingShow')) {
    function ratingShow($rating) {
        return number_format($rating, 1);
    }
}

// rating star show
if (!function_exists('ratingStarShow')) {
    function ratingStarShow($rating) {
        $starSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#000" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>';

        $resp = '';

        for($i = 0; $i < (int) $rating; $i++) {
            $resp .= $starSvg;
        }

        return $resp;
    }
}