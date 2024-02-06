<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::name('admin.')->group(function() {
    // login
    Route::middleware('guest:admin', 'PreventBackHistory')->group(function() {
        Route::view('/login', 'admin.auth.login')->name('login');
        Route::post('/check', [AuthController::class, 'check'])->name('check');
    });

    // profile
    Route::middleware('auth:admin', 'PreventBackHistory')->group(function() {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // order
        Route::prefix('order')->name('order.')->group(function() {
            Route::get('/', [OrderController::class, 'index'])->name('list.all');
            Route::get('/detail/{id}', [OrderController::class, 'detail'])->name('detail');
            Route::get('/status/{id}', [OrderController::class, 'status'])->name('status');

            Route::prefix('product')->name('product.')->group(function() {
                Route::get('/status/{id}', [OrderProductController::class, 'status'])->name('status');
            });
        });

        // product
        Route::prefix('product')->name('product.')->group(function() {
            Route::get('/list', [ProductController::class, 'index'])->name('list.all');
            Route::post('/store', [ProductController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('detail');
            Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('delete');
            Route::get('/status/{id}', [ProductController::class, 'status'])->name('status');
            Route::get('/save/draft/{id}', [ProductController::class, 'saveDraft'])->name('save.draft');
            Route::post('product/fetch', [ProductController::class, 'fetch'])->name('featured.fetch');

            Route::prefix('setup')->name('setup.')->group(function() {
                Route::get('/category', [ProductSetupController::class, 'category'])->name('category');
                Route::get('/category/edit/{id}', [ProductSetupController::class, 'categoryEdit'])->name('category.edit');
                Route::post('/category/update', [ProductSetupController::class, 'categoryUpdate'])->name('category.update');

                Route::get('/title/{id}', [ProductSetupController::class, 'title'])->name('title');
                Route::get('/price/{id}', [ProductSetupController::class, 'price'])->name('price');

                Route::get('/images/{id}', [ProductSetupController::class, 'images'])->name('images');
                Route::get('/images/delete/{id}', [ProductSetupController::class, 'imageDelete'])->name('images.delete');
                Route::post('/images/position/update', [ProductSetupController::class, 'imagesPositionUpdate'])->name('images.position.update');
                Route::get('/images/detailed/{id}', [ProductSetupController::class, 'imagesDetailed'])->name('images.detailed');
                Route::get('/images/status/{id}', [ProductSetupController::class, 'imagesStatus'])->name('images.status');

                Route::get('/highlights/{id}', [ProductSetupController::class, 'highlights'])->name('highlights');
                Route::post('/highlights/position', [ProductSetupController::class, 'highlightPosition'])->name('highlights.position');
                Route::get('/highlights/status/{id}', [ProductSetupController::class, 'highlightStatus'])->name('highlights.status');
                Route::get('/highlights/delete/{id}', [ProductSetupController::class, 'highlightDelete'])->name('highlights.delete');

                Route::get('/usage-instruction/{id}', [ProductSetupController::class, 'usage'])->name('usage');
                Route::post('/usage-instruction/position', [ProductSetupController::class, 'usagePosition'])->name('usage.position');
                Route::get('/usage-instruction/status/{id}', [ProductSetupController::class, 'usageStatus'])->name('usage.status');
                Route::get('/usage-instruction/delete/{id}', [ProductSetupController::class, 'usageDelete'])->name('usage.delete');

                Route::get('/box-item/{id}', [ProductSetupController::class, 'boxitem'])->name('boxitem');
                Route::post('/box-item/position', [ProductSetupController::class, 'boxitemPosition'])->name('boxitem.position');
                Route::get('/box-item/status/{id}', [ProductSetupController::class, 'boxitemStatus'])->name('boxitem.status');
                Route::get('/box-item/delete/{id}', [ProductSetupController::class, 'boxitemDelete'])->name('boxitem.delete');

                Route::get('/description/{id}', [ProductSetupController::class, 'description'])->name('description');

                Route::get('/ingredient/{id}', [ProductSetupController::class, 'ingredient'])->name('ingredient');
                Route::post('/ingredient/position', [ProductSetupController::class, 'ingredientPosition'])->name('ingredient.position');
                Route::get('/ingredient/status/{id}', [ProductSetupController::class, 'ingredientStatus'])->name('ingredient.status');
                Route::get('/ingredient/delete/{id}', [ProductSetupController::class, 'ingredientDelete'])->name('ingredient.delete');

                Route::get('/seo/{id}', [ProductSetupController::class, 'seo'])->name('seo');

                Route::get('/variation/{id}', [ProductSetupController::class, 'variation'])->name('variation');
                Route::get('/variation/delete/{id}', [ProductSetupController::class, 'variationParentDelete'])->name('variation.parent.delete');
                Route::get('/variation/{id}/detail/{parentId}', [ProductSetupController::class, 'variationParentDetail'])->name('variation.parent.detail');
                Route::get('/variation/{id}/edit/{parentId}', [ProductSetupController::class, 'variationParentEdit'])->name('variation.parent.edit');

                Route::get('/variation/{id}/create/{parentId}/child', [ProductSetupController::class, 'variationChildCreate'])->name('variation.child.create');
                Route::get('/variation/status/{childId}', [ProductSetupController::class, 'variationChildStatus'])->name('variation.child.status');
                Route::post('/variation/{id}/parent/{parentId}/position', [ProductSetupController::class, 'variationChildPosition'])->name('variation.child.position');
                Route::get('/variation/child/delete/{id}', [ProductSetupController::class, 'variationChildDelete'])->name('variation.child.delete');

                Route::prefix('store')->name('store.')->group(function() {
                    Route::post('/category', [ProductSetupController::class, 'categoryStore'])->name('category');
                    Route::post('/title', [ProductSetupController::class, 'titleUpdate'])->name('title');
                    Route::post('/price', [ProductSetupController::class, 'priceUpdate'])->name('price');
                    Route::post('/images', [ProductSetupController::class, 'imagesUpdate'])->name('images');
                    Route::post('/highlights', [ProductSetupController::class, 'highlightsUpdate'])->name('highlights');
                    Route::post('/ingredient', [ProductSetupController::class, 'ingredientUpdate'])->name('ingredient');
                    Route::post('/usage', [ProductSetupController::class, 'usageUpdate'])->name('usage');
                    Route::post('/boxitem', [ProductSetupController::class, 'boxitemUpdate'])->name('boxitem');
                    Route::post('/description', [ProductSetupController::class, 'descriptionUpdate'])->name('description');
                    Route::post('/seo', [ProductSetupController::class, 'seoUpdate'])->name('seo');

                    Route::post('/variation/parent', [ProductSetupController::class, 'variationParent'])->name('variation.parent');
                    Route::post('/variation/child', [ProductSetupController::class, 'variationChild'])->name('variation.child');
                });
            });

            Route::prefix('review')->name('review.')->group(function() {
                Route::get('/{id}', [ProductReviewController::class, 'index'])->name('index');
            });

            Route::prefix('feature')->name('feature.')->group(function() {
                Route::get('/', [ProductFeatureController::class, 'index'])->name('all');
                Route::post('/position', [ProductFeatureController::class, 'position'])->name('position');
            });

            // collection
            Route::prefix('collection')->name('collection.')->group(function() {
                Route::get('/', [CollectionController::class, 'index'])->name('list.all');
                Route::get('/create', [CollectionController::class, 'create'])->name('create');
                Route::post('/store', [CollectionController::class, 'store'])->name('store');
                Route::get('/detail/{id}', [CollectionController::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [CollectionController::class, 'edit'])->name('edit');
                Route::post('/update', [CollectionController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [CollectionController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [CollectionController::class, 'status'])->name('status');
                Route::post('/position', [CollectionController::class, 'position'])->name('position');
            });

            // category
            Route::prefix('category/{level}')->name('category.')->group(function() {
                Route::get('/', [CategoryController::class, 'index'])->name('list.all');
                Route::get('/create', [CategoryController::class, 'create'])->name('create');
                Route::post('/store', [CategoryController::class, 'store'])->name('store');
                Route::get('/detail/{id}', [CategoryController::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
                Route::post('/update', [CategoryController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [CategoryController::class, 'status'])->name('status');
                Route::post('/position', [CategoryController::class, 'position'])->name('position');

                Route::post('/fetch', [CategoryController::class, 'fetchByParent'])->name('fetch');
                Route::post('/fetch/edit', [CategoryController::class, 'fetchByParentEdit'])->name('fetch.edit');

                // highlight
                Route::prefix('highlight')->name('highlight.')->group(function() {
                    Route::get('/{id}', [Category1HighlightController::class, 'index'])->name('list.all');
                    Route::get('/create/{id}', [Category1HighlightController::class, 'create'])->name('create');
                    Route::post('/store', [Category1HighlightController::class, 'store'])->name('store');
                    Route::get('/detail/{id}', [Category1HighlightController::class, 'detail'])->name('detail');
                    Route::get('/edit/{id}', [Category1HighlightController::class, 'edit'])->name('edit');
                    Route::post('/update', [Category1HighlightController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [Category1HighlightController::class, 'delete'])->name('delete');
                    Route::get('/status/{id}', [Category1HighlightController::class, 'status'])->name('status');
                    Route::post('/position', [Category1HighlightController::class, 'position'])->name('position');
                });
            });
        });

        // review
        Route::prefix('review')->name('review.')->group(function() {
            Route::get('/', [ReviewController::class, 'index'])->name('list.all');
            Route::get('/create', [ReviewController::class, 'create'])->name('create');
            Route::post('/store', [ReviewController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [ReviewController::class, 'detail'])->name('detail');
            Route::get('/edit/{id}', [ReviewController::class, 'edit'])->name('edit');
            Route::post('/update', [ReviewController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [ReviewController::class, 'delete'])->name('delete');
            Route::get('/status/{id}', [ReviewController::class, 'status'])->name('status');
        });

        // user
        Route::prefix('user')->name('user.')->group(function() {
            Route::get('/', [UserController::class, 'index'])->name('list.all');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [UserController::class, 'detail'])->name('detail');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::post('/update', [UserController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
            Route::get('/status/{id}', [UserController::class, 'status'])->name('status');
            Route::post('/Reset/password', [UserController::class, 'resetPassword'])->name('reset.password');
        });

        // coupon
        Route::prefix('coupon')->name('coupon.')->group(function() {
            Route::get('/', [CouponController::class, 'index'])->name('list.all');
            Route::get('/create', [CouponController::class, 'create'])->name('create');
            Route::post('/store', [CouponController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [CouponController::class, 'detail'])->name('detail');
            Route::get('/edit/{id}', [CouponController::class, 'edit'])->name('edit');
            Route::post('/update', [CouponController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [CouponController::class, 'delete'])->name('delete');
            Route::get('/status/{id}', [CouponController::class, 'status'])->name('status');
            Route::post('/position', [CouponController::class, 'position'])->name('position');
        });

        // product image
        // Route::prefix('product/image')->name('product.image.')->group(function() {
        //     Route::get('/delete/{id}', [ProductImageController::class, 'delete'])->name('delete');
        // });

        // product manual
        // Route::prefix('product/manual')->name('product.manual.')->group(function() {
        //     Route::get('/delete/{id}', [ProductManualController::class, 'delete'])->name('delete');
        // });

        // product datasheet
        // Route::prefix('product/datasheet')->name('product.datasheet.')->group(function() {
        //     Route::get('/delete/{id}', [ProductDatasheetController::class, 'delete'])->name('delete');
        // });

        // blog
        Route::prefix('blog')->name('blog.')->group(function() {
            Route::prefix('category1')->name('category1.')->group(function() {
                Route::get('/', [BlogCategory1Controller::class, 'index'])->name('list.all');
                Route::get('/create', [BlogCategory1Controller::class, 'create'])->name('create');
                Route::post('/store', [BlogCategory1Controller::class, 'store'])->name('store');
                Route::get('/detail/{id}', [BlogCategory1Controller::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [BlogCategory1Controller::class, 'edit'])->name('edit');
                Route::post('/update', [BlogCategory1Controller::class, 'update'])->name('update');
                Route::get('/delete/{id}', [BlogCategory1Controller::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [BlogCategory1Controller::class, 'status'])->name('status');
                Route::post('/position', [BlogCategory1Controller::class, 'position'])->name('position');

                Route::post('/fetch', [BlogCategory1Controller::class, 'fetchCategory2s'])->name('category2.fetch');
                Route::post('/fetch/selected', [BlogCategory1Controller::class, 'fetchCategory2sSelected'])->name('category2.fetch.selected');
            });

            Route::prefix('category2')->name('category2.')->group(function() {
                Route::get('/', [BlogCategory2Controller::class, 'index'])->name('list.all');
                Route::get('/create', [BlogCategory2Controller::class, 'create'])->name('create');
                Route::post('/store', [BlogCategory2Controller::class, 'store'])->name('store');
                Route::get('/detail/{id}', [BlogCategory2Controller::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [BlogCategory2Controller::class, 'edit'])->name('edit');
                Route::post('/update', [BlogCategory2Controller::class, 'update'])->name('update');
                Route::get('/delete/{id}', [BlogCategory2Controller::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [BlogCategory2Controller::class, 'status'])->name('status');
                Route::post('/position', [BlogCategory2Controller::class, 'position'])->name('position');
            });

            Route::prefix('tag')->name('tag.')->group(function() {
                Route::get('/', [BlogTagController::class, 'index'])->name('list.all');
                Route::get('/create', [BlogTagController::class, 'create'])->name('create');
                Route::post('/store', [BlogTagController::class, 'store'])->name('store');
                Route::get('/detail/{id}', [BlogTagController::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [BlogTagController::class, 'edit'])->name('edit');
                Route::post('/update', [BlogTagController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [BlogTagController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [BlogTagController::class, 'status'])->name('status');
                Route::post('/position', [BlogTagController::class, 'position'])->name('position');
            });

            Route::prefix('list')->name('list.')->group(function() {
                Route::get('/', [BlogController::class, 'index'])->name('all');
                Route::get('/create', [BlogController::class, 'create'])->name('create');
                Route::post('/store', [BlogController::class, 'store'])->name('store');
                Route::get('/detail/{id}', [BlogController::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('edit');
                Route::post('/update', [BlogController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [BlogController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [BlogController::class, 'status'])->name('status');
            });

            Route::prefix('feature')->name('feature.')->group(function() {
                Route::get('/', [BlogFeatureController::class, 'index'])->name('all');
                Route::post('/position', [BlogFeatureController::class, 'position'])->name('position');
            });
        });

        // lead
        Route::prefix('lead')->name('lead.')->group(function() {
            Route::get('/', [LeadController::class, 'index'])->name('list.all');
        });

        // content
        Route::prefix('content')->name('content.')->group(function() {
            // seo
            Route::prefix('seo')->name('seo.')->group(function() {
                Route::get('/', [SeoController::class, 'index'])->name('list.all');
                Route::get('/detail/{id}', [SeoController::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [SeoController::class, 'edit'])->name('edit');
                Route::post('/update', [SeoController::class, 'update'])->name('update');
            });

            // banner
            Route::prefix('banner')->name('banner.')->group(function() {
                Route::get('/', [BannerController::class, 'index'])->name('list.all');
                Route::get('/create', [BannerController::class, 'create'])->name('create');
                Route::post('/store', [BannerController::class, 'store'])->name('store');
                Route::get('/detail/{id}', [BannerController::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [BannerController::class, 'edit'])->name('edit');
                Route::post('/update', [BannerController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [BannerController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [BannerController::class, 'status'])->name('status');
                Route::post('/position', [BannerController::class, 'position'])->name('position');
            });

            Route::get('/page/{page}', [ContentController::class, 'edit'])->name('edit');
            Route::get('/page/status/{id}', [ContentController::class, 'status'])->name('status');
            Route::post('/page/update', [ContentController::class, 'update'])->name('page.update');

            // // cancellation
            // Route::get('/cancellation', [ContentController::class, 'cancellation'])->name('cancellation');
            // // terms
            // Route::get('/terms', [ContentController::class, 'terms'])->name('terms');
            // // privacy
            // Route::get('/privacy', [ContentController::class, 'privacy'])->name('privacy');
            // // security
            // Route::get('/security', [ContentController::class, 'security'])->name('security');

            // Route::post('/content/page/update', [ContentController::class, 'contentPageUpdate'])->name('page.update');
        });

        // management
        Route::prefix('management')->name('management.')->group(function() {
            // notice
            Route::prefix('notice')->name('notice.')->group(function() {
                Route::get('/', [NoticeController::class, 'index'])->name('list.all');
                Route::get('/create', [NoticeController::class, 'create'])->name('create');
                Route::post('/store', [NoticeController::class, 'store'])->name('store');
                Route::get('/detail/{id}', [NoticeController::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [NoticeController::class, 'edit'])->name('edit');
                Route::post('/update', [NoticeController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [NoticeController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [NoticeController::class, 'status'])->name('status');
                Route::get('/frontend/show//{id}', [NoticeController::class, 'show'])->name('frontend.show');
                Route::post('/position', [NoticeController::class, 'position'])->name('position');
            });

            // partner
            Route::prefix('partner')->name('partner.')->group(function() {
                Route::get('/', [PartnerController::class, 'index'])->name('list.all');
                Route::get('/create', [PartnerController::class, 'create'])->name('create');
                Route::post('/store', [PartnerController::class, 'store'])->name('store');
                Route::get('/detail/{id}', [PartnerController::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [PartnerController::class, 'edit'])->name('edit');
                Route::post('/update', [PartnerController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [PartnerController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [PartnerController::class, 'status'])->name('status');
                Route::post('/position', [PartnerController::class, 'position'])->name('position');
            });

            // testimonial
            Route::prefix('testimonial')->name('testimonial.')->group(function() {
                Route::get('/', [TestimonialController::class, 'index'])->name('list.all');
                Route::get('/create', [TestimonialController::class, 'create'])->name('create');
                Route::post('/store', [TestimonialController::class, 'store'])->name('store');
                Route::get('/detail/{id}', [TestimonialController::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [TestimonialController::class, 'edit'])->name('edit');
                Route::post('/update', [TestimonialController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [TestimonialController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [TestimonialController::class, 'status'])->name('status');
            });

            // instagram post
            Route::prefix('instagram')->name('instagram.')->group(function() {
                // post
                Route::prefix('post')->name('post.')->group(function() {
                    Route::get('/', [InstagramController::class, 'post'])->name('list.all');
                });

                // setup
                Route::prefix('setup')->name('setup.')->group(function() {
                    Route::get('/', [InstagramController::class, 'setup'])->name('index');
                });





                // Route::get('/create', [InstagramPostController::class, 'create'])->name('create');
                // Route::post('/store', [InstagramPostController::class, 'store'])->name('store');
                // Route::get('/detail/{id}', [InstagramPostController::class, 'detail'])->name('detail');
                // Route::get('/edit/{id}', [InstagramPostController::class, 'edit'])->name('edit');
                // Route::post('/update', [InstagramPostController::class, 'update'])->name('update');
                // Route::get('/delete/{id}', [InstagramPostController::class, 'delete'])->name('delete');
                // Route::get('/status/{id}', [InstagramPostController::class, 'status'])->name('status');
            });

            // social media
            Route::prefix('socialmedia')->name('socialmedia.')->group(function() {
                Route::get('/', [SocialMediaController::class, 'index'])->name('list.all');
                Route::get('/create', [SocialMediaController::class, 'create'])->name('create');
                Route::post('/store', [SocialMediaController::class, 'store'])->name('store');
                Route::get('/detail/{id}', [SocialMediaController::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [SocialMediaController::class, 'edit'])->name('edit');
                Route::post('/update', [SocialMediaController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [SocialMediaController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [SocialMediaController::class, 'status'])->name('status');
                Route::post('/position', [SocialMediaController::class, 'position'])->name('position');
            });

        });

        // office
        Route::prefix('application')->name('office.')->group(function() {
            // information
            Route::prefix('information')->name('information.')->group(function() {
                Route::get('/detail', [OfficeInformationController::class, 'detail'])->name('detail');
                Route::get('/edit', [OfficeInformationController::class, 'edit'])->name('edit');
                Route::post('/update', [OfficeInformationController::class, 'update'])->name('update');
            });

            // address
            Route::prefix('address')->name('address.')->group(function() {
                Route::get('/', [OfficeAddressController::class, 'index'])->name('list.all');
                Route::get('/create', [OfficeAddressController::class, 'create'])->name('create');
                Route::post('/store', [OfficeAddressController::class, 'store'])->name('store');
                Route::get('/detail/{id}', [OfficeAddressController::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [OfficeAddressController::class, 'edit'])->name('edit');
                Route::post('/update', [OfficeAddressController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [OfficeAddressController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [OfficeAddressController::class, 'status'])->name('status');
                Route::post('/position', [OfficeAddressController::class, 'position'])->name('position');
            });

            // phone number
            Route::prefix('phone')->name('phone.')->group(function() {
                Route::get('/', [OfficePhoneController::class, 'index'])->name('list.all');
                Route::get('/create', [OfficePhoneController::class, 'create'])->name('create');
                Route::post('/store', [OfficePhoneController::class, 'store'])->name('store');
                Route::get('/detail/{id}', [OfficePhoneController::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [OfficePhoneController::class, 'edit'])->name('edit');
                Route::post('/update', [OfficePhoneController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [OfficePhoneController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [OfficePhoneController::class, 'status'])->name('status');
                Route::post('/position', [OfficePhoneController::class, 'position'])->name('position');
            });

            // email
            Route::prefix('email')->name('email.')->group(function() {
                Route::get('/', [OfficeEmailController::class, 'index'])->name('list.all');
                Route::get('/create', [OfficeEmailController::class, 'create'])->name('create');
                Route::post('/store', [OfficeEmailController::class, 'store'])->name('store');
                Route::get('/detail/{id}', [OfficeEmailController::class, 'detail'])->name('detail');
                Route::get('/edit/{id}', [OfficeEmailController::class, 'edit'])->name('edit');
                Route::post('/update', [OfficeEmailController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [OfficeEmailController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [OfficeEmailController::class, 'status'])->name('status');
                Route::post('/position', [OfficeEmailController::class, 'position'])->name('position');
            });

        });

        // profile
        Route::prefix('profile')->name('profile.')->group(function() {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::post('/update', [ProfileController::class, 'update'])->name('update');
            Route::get('/password', [ProfileController::class, 'password'])->name('password.index');
            Route::post('/password/update', [ProfileController::class, 'passwordUpdate'])->name('password.update');
        });

        // database reset
        Route::get('/database/reset', [DBResetController::class, 'index'])->name('database.reset.index');

    });

    // ckeditor custom upload adapter path
    Route::post('/ckeditor/upload', [UploadAdapterController::class, 'upload']);
});