<div class="offcanvas offcanvas-end" tabindex="-1" id="quickCart" aria-labelledby="quickCartLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="quickCartLabel">Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body py-0">
        <div id="cart-status">
            <div class="cart-exists">
                <div class="c-content">
                    @include('front.quick.cart-product')
                </div>

                <div class="goto-links">
                    <a href="{{ route('front.checkout.index') }}" class="btn btn-dark w-100 checkout">
                        Checkout
                        <div class="icon"><i class="material-icons md-light">chevron_right</i></div>
                    </a>
                </div>
            </div>

            {{-- <div class="empty text-center">
                <div class="image">
                    <img src="{{ asset('uploads/static-svgs/undraw_empty_cart_co35.svg') }}" alt="empty-cart" class="w-100">
                </div>
                <h6>Your cart is empty</h6>
                <p class="small text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, deleniti!</p>
            </div> --}}
        </div>
    </div>
</div>