<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public function categoryDetails()
    {
        return $this->hasMany('App\Models\ProductCategory', 'product_id', 'id');
    }

    public function boxItems()
    {
        return $this->hasMany('App\Models\ProductBoxItem', 'product_id', 'id')->orderBy('position');
    }

    public function frontBoxItems()
    {
        return $this->hasMany('App\Models\ProductBoxItem', 'product_id', 'id')->where('status', 1)->orderBy('position');
    }

    public function imageDetails()
    {
        return $this->hasMany('App\Models\ProductImage', 'product_id', 'id')->orderBy('position')->orderBy('created_at');
    }

    public function frontImageDetails()
    {
        return $this->hasMany('App\Models\ProductImage', 'product_id', 'id')->where('status', 1)->orderBy('position');
    }

    public function redirectProductDetails()
    {
        return $this->hasOne('App\Models\Product', 'id', 'replacement_product_id');
        // return $this->hasOne('App\Models\Product', 'id', 'replacement_product_id')->where('replacement_product_id', '!=', 0);
    }

    public function highlightDetails()
    {
        return $this->hasMany('App\Models\ProductHighlight', 'product_id', 'id')->orderBy('position');
    }

    public function frontHighlightDetails()
    {
        return $this->hasMany('App\Models\ProductHighlight', 'product_id', 'id')->where('status', 1)->orderBy('position');
    }

    public function usageDetails()
    {
        return $this->hasMany('App\Models\ProductUsageInstruction', 'product_id', 'id')->orderBy('position');
    }

    public function frontUsageDetails()
    {
        return $this->hasMany('App\Models\ProductUsageInstruction', 'product_id', 'id')->where('status', 1)->orderBy('position');
    }

    public function reviewDetailsLatest()
    {
        return $this->hasMany('App\Models\ProductReview', 'product_id', 'id')->where('status', 1)->latest('id');
    }

    public function activeReviewDetails()
    {
        return $this->hasMany('App\Models\ProductReview', 'product_id', 'id')->where('status', 1);
    }

    public function activeTopReviewDetails()
    {
        return $this->hasMany('App\Models\ProductReview', 'product_id', 'id')->where('status', 1)->limit(3);
    }

    public function pricing()
    {
        return $this->hasMany('App\Models\ProductPricing', 'product_id', 'id');
    }

    public function ingredientDetails()
    {
        return $this->hasMany('App\Models\ProductIngredient', 'product_id', 'id')->orderBy('position');
    }

    public function frontingredientDetails()
    {
        return $this->hasMany('App\Models\ProductIngredient', 'product_id', 'id')->where('status', 1)->orderBy('position');
    }

    // public function variationParents()
    // {
    //     return $this->hasMany('App\Models\ProductVariationParent', 'product_id', 'id')->orderBy('position');
    // }

    // public function frontVariationParents()
    // {
    //     return $this->hasMany('App\Models\ProductVariationParent', 'product_id', 'id')->where('status', 1)->orderBy('position');
    // }

    public function wishlistDetail()
    {
        return $this->hasOne('App\Models\ProductWishlist', 'product_id', 'id')->where('user_id', auth()->guard('web')->user()->id);
    }

    public function statusDetail()
    {
        return $this->hasOne('App\Models\ProductStatus', 'id', 'status');
    }

    public function subscriptionData()
    {
        return $this->hasMany('App\Models\ProductSubscription', 'product_id', 'id')->where('user_id', auth()->guard('web')->user()->id);
    }

    public function variationOptions()
    {
        return $this->hasMany('App\Models\ProductVariation', 'product_id', 'id');
    }

    public function activeVariationOptions()
    {
        return $this->hasMany('App\Models\ProductVariation', 'product_id', 'id')->where('status', 1);
    }

    public function activeVariations()
    {
        return $this->hasManyThrough(VariationOption::class, ProductVariation::class, 'product_id', 'id', 'id', 'variation_option_id')->where('product_variations.status', 1);
    }
}
