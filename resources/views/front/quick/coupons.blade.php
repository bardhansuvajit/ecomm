<div class="offcanvas offcanvas-end" tabindex="-1" id="publicCoupon" aria-labelledby="publicCouponLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="publicCouponLabel">Coupons</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body py-0">
        <div id="public-coupons">
            <div class="coupons-found">
                <div class="c-content">

                    <div class="single-coupon">
                        <div class="card rounded-0">
                            <div class="card-body">
                                <div class="highlight-part">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6>CART10</h6>
                                            <p class="text-muted mb-0">
                                                20% Off
                                            </p>
                                            {{-- <p class="text-muted mb-0">
                                                Flat 
                                                <span class="currency-icon">Rs</span>
                                                <span class="amount">2,000</span>
                                                Off
                                            </p> --}}
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="javascript: void(0)">APPLY</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="detailed-part mt-3">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit nulla nostrum fugit neque placeat cupiditate in dolore magnam! Doloribus, magni.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- <div class="coupons-missing">
                <div class="empty text-center">
                    <div class="image">
                        <img src="{{ asset('uploads/static-svgs/undraw_no_data_re_kwbl.svg') }}" alt="empty-cart" class="w-100">
                    </div>
                    <h6>No coupons found</h6>
                    <p class="small text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, deleniti!</p>
                </div>
            </div> --}}
        </div>
    </div>
</div>