let baseUrl = window.location.origin;
if (baseUrl.indexOf('torzo') > -1) {
    baseUrl = "https://torzo.in/dev/ecomm/public";
}

const loginModalEl = new bootstrap.Modal('#loginModal')
const registerModalEl = new bootstrap.Modal('#registerModal')
const loginModal = document.getElementById('loginModal')
const registerModal = document.getElementById('registerModal')
const quickCartEl = new bootstrap.Offcanvas('#quickCart')
const publicCouponEl = new bootstrap.Offcanvas('#publicCoupon')

loginModal.addEventListener('shown.bs.modal', event => {
    document.querySelector('input[name="login-phone-number"]').focus();
})
registerModal.addEventListener('shown.bs.modal', event => {
    document.querySelector('input[name="phone-number"]').focus();
})

function getQuery(q) {
    return (window.location.search.match(new RegExp('[?&]' + q + '=([^&]+)')) || [, null]) [1];
}

function currentPage() {
    return location.pathname.split('/').slice(-1)[0];
}

function toastFire(type = 'success', title) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom',
        timer: 5000,
        showConfirmButton: false,
        showCloseButton: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    Toast.fire({
        icon: type,
        title: title
    })
}

function maxLengthCheck(object) {
    if (object.value.length > object.maxLength)
    object.value = object.value.slice(0, object.maxLength)
}

function isNumeric(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode (key);
    // var regex = /[0-9]|\./; // digits supporting decimal/ .
    var regex = /^[0-9]*$/; // only integer
    if ( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}

function isChar(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode (key);
    var regex = /^[a-zA-Z\s]*$/; // only string regex
    if ( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}

// visibility toggle
$(document).on('click', '.visibility-toggle', function(e) {
    e.preventDefault();
    const type = ($(this).closest('.input-group').find('input').attr('type') == "text") ? 'password' : 'text';
    const icon = ($(this).closest('.input-group').find('input').attr('type') == "text") ? 'visibility_off' : 'visibility';
    $(this).closest('.input-group').find('input').attr('type', type)
    $(this).find('.material-icons').text(icon)
});

/* When user scrolls down, hide the navbar. When user scrolls up, show the navbar */
var prevScrollpos = window.pageYOffset;
document.getElementById("onscroll-nav").style.top = "0";

if ($(window).width() > 992) {
    window.onscroll = function () {
        var currentScrollPos = window.pageYOffset;
        var lastScrollTop = 0;
        if (prevScrollpos > currentScrollPos) {
            document.getElementById("onscroll-nav").style.top = "0";
            document.getElementById("onscroll-nav").style.borderBottom = "1px solid #e4e4e4";
            document.getElementById("onscroll-nav").style.boxShadow = "0 0 0.125rem rgba(0, 0, 0, 0.125)";
            // document.getElementById("quick_container").style.top = "52px";
            document.getElementsByClassName("sticky-section")[0].style.top = "70px";
        } else {
            document.getElementById("onscroll-nav").style.top = "-67px";
            // document.getElementById("quick_container").style.top = "-1px";
            document.getElementsByClassName("sticky-section")[0].style.top = "10px";
        }
        // checking if scroll position is 15 to top
        if (currentScrollPos < 15) {
            document.getElementById("onscroll-nav").style.borderBottom = "1px solid transparent";
            document.getElementById("onscroll-nav").style.boxShadow = "0 0 0 rgba(0, 0, 0, 0)";
        }
        // checking if scrolled down
        if (currentScrollPos > lastScrollTop) {
            document.getElementById("onscroll-nav").style.borderBottom = "1px solid #e4e4e4";
            document.getElementById("onscroll-nav").style.boxShadow = "0 0 0.125rem rgba(0, 0, 0, 0.125)";
        }
        prevScrollpos = currentScrollPos;
        // lastScrollTop = currentScrollPos <= 0 ? 0 : currentScrollPos; // For Mobile or negative scrolling
    }
} else {
    window.onscroll = function () {
        var currentScrollPos = window.pageYOffset;
        var lastScrollTop = 0;
        if (prevScrollpos > currentScrollPos) {
            document.getElementById("onscroll-nav").style.top = "0";
            document.getElementById("onscroll-nav").style.borderBottom = "1px solid #e4e4e4";
            document.getElementById("onscroll-nav").style.boxShadow = "0 0 0.125rem rgba(0, 0, 0, 0.125)";
            // document.getElementById("quick_container").style.top = "80px";
            document.getElementsByClassName("sticky-section")[0].style.top = "63px";
        } else {
            document.getElementById("onscroll-nav").style.top = "-38px";
            // document.getElementById("quick_container").style.top = "38px";
            document.getElementsByClassName("sticky-section")[0].style.top = "10px";
        }
        // checking if scroll position is 15 to top
        if (currentScrollPos < 15) {
            document.getElementById("onscroll-nav").style.borderBottom = "1px solid transparent";
            document.getElementById("onscroll-nav").style.boxShadow = "0 0 0 rgba(0, 0, 0, 0)";
        }
        // checking if scrolled down
        if (currentScrollPos > lastScrollTop) {
            document.getElementById("onscroll-nav").style.borderBottom = "1px solid #e4e4e4";
            document.getElementById("onscroll-nav").style.boxShadow = "0 0 0.125rem rgba(0, 0, 0, 0.125)";
        }
        prevScrollpos = currentScrollPos;
        // lastScrollTop = currentScrollPos <= 0 ? 0 : currentScrollPos; // For Mobile or negative scrolling
    }
}

/* When user clicks on search bar, search result shows */
$('#search-bar').on('click', function () {
    $("#search-result-holder").show();
});


/* When user clicks outside search result box, it disappears */
$(document).mouseup(function (e) {
    var searchHolder = $("#search-result-holder");
    // if the target of the click isn't the container nor a descendant of the container
    if (!searchHolder.is(e.target) && searchHolder.has(e.target).length === 0) {
        searchHolder.hide();
    }
});

$('#registerForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: {
            _token: $('#registerForm input[name="_token"]').val(),
            phone: $('#registerForm input[name="phone-number"]').val(),
            password: $('#registerForm input[name="password"]').val(),
            redirect: $('#registerForm input[name="redirect"]').val(),
        },
        beforeSend: function() {
            $('#regMessage').html('')
        },
        success: function(res) {
            if (res.status == 400) {
                $.each(res.data, (key, val) => {
                    $('#regMessage').append(`<p class="small text-danger mb-1">${val}</p>`);
                });
            } else {
                toastFire('success', res.message);

                let content = `
                <div class="btn-group user-detail">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ${res.name}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <h6 class="dropdown-header">${res.name}</h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="${baseUrl}/user/account">Account</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="${baseUrl}/user/order">Orders</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="${baseUrl}/user/profile">Profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript: void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                    </ul>
                </div>
                `;
                $('#login-container').html(content);

                // $('#login-container').html(`<a href="" class="btn btn-dark">${res.name}</a>`);
                registerModalEl.hide();

                if (res.redirect.length > 0) {
                    window.location = res.redirect
                }
            }
        },
        error: function(xhr) {

        }
    });
});

$('#loginForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: {
            _token: $('#loginForm input[name="_token"]').val(),
            mobile_no: $('#loginForm input[name="login-phone-number"]').val(),
            password: $('#loginForm input[name="login-password"]').val(),
            redirect: $('#loginForm input[name="redirect"]').val(),
        },
        beforeSend: function() {
            $('#loginMessage').html('')
        },
        success: function(res) {
            if (res.status == 400) {
                toastFire('error', res.message);
            } else {
                toastFire('success', res.message);

                let content = `
                <div class="btn-group user-detail">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ${res.name}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <h6 class="dropdown-header">${res.name}</h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="${baseUrl}/user/account">Account</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="${baseUrl}/user/order">Orders</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="${baseUrl}/user/profile">Profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript: void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                    </ul>
                </div>
                `;
                $('#login-container').html(content);

                loginModalEl.hide();

                if (res.redirect.length > 0) {
                    window.location = res.redirect
                }
            }
        },
        error: function(xhr) {

        }
    });
});

const swiperBanner = new Swiper('.swiper-banner', {
    slidesPerView: 1.1,
    spaceBetween: 10,
    pagination: {
        el: '.swiper-pagination',
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

const swiperDeals = new Swiper('.swiper-deals', {
    slidesPerView: 2,
    spaceBetween: 10,
    pagination: {
        el: '.swiper-pagination',
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        // when window width is >= 640px
        640: {
            slidesPerView: 3,
            spaceBetween: 10
        },
        // when window width is >= 768px
        768: {
            slidesPerView: 4,
            spaceBetween: 10
        },
        // when window width is >= 1024px
        1024: {
            slidesPerView: 5,
            spaceBetween: 10
        }
      }
});

const swiperSimilar = new Swiper('.swiper-similar', {
    slidesPerView: 2,
    spaceBetween: 10,
    pagination: {
        el: '.swiper-pagination',
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        // when window width is >= 640px
        640: {
            slidesPerView: 3,
            spaceBetween: 10
        },
        // when window width is >= 768px
        768: {
            slidesPerView: 4,
            spaceBetween: 10
        },
        // when window width is >= 1024px
        1024: {
            slidesPerView: 5,
            spaceBetween: 10
        }
      }
});

const swiperRecent = new Swiper('.swiper-recent', {
    slidesPerView: 2,
    spaceBetween: 10,
    pagination: {
        el: '.swiper-pagination',
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        // when window width is >= 640px
        640: {
            slidesPerView: 3,
            spaceBetween: 10
        },
        // when window width is >= 768px
        768: {
            slidesPerView: 4,
            spaceBetween: 10
        },
        // when window width is >= 1024px
        1024: {
            slidesPerView: 5,
            spaceBetween: 10
        }
      }
});

// product detail page ends
var swiperThumb = new Swiper(".thumb", {
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    slidesPerView: 5,
    freeMode: true,
    watchSlidesProgress: true,
});
var swiperGallery = new Swiper(".gallery", {
    spaceBetween: 10,
    thumbs: {
      swiper: swiperThumb,
    },
});
$('.thumb .swiper-slide').on('mouseover', function() {
    swiperGallery.slideTo($(this).index());
});
var activeImage = $('.swiper-slide.swiper-slide-active .image-holder img');
// product detail page ends

function getRows(selector) {
    var height = $(selector).height();
    var line_height = $(selector).css('line-height');
    line_height = parseFloat(line_height)
    var rows = height / line_height;
    return Math.round(rows);
}

function seeMoreText(reviewClass, thisClass) {
    if ($('.'+reviewClass).hasClass('height-3')) {
        $('.'+reviewClass).removeClass('height-3');
        $('.'+thisClass).text('See less');
    } else {
        $('.'+reviewClass).addClass('height-3');
        $('.'+thisClass).text('See more');
    }
}
function seeMoreTextQuestion(questionClass, thisClass) {
    if ($('.'+questionClass).hasClass('height-3')) {
        $('.'+questionClass).removeClass('height-3');
        $('.'+thisClass).text('See less');
    } else {
        $('.'+questionClass).addClass('height-3');
        $('.'+thisClass).text('See more');
    }
}

// global currency update start
$(document).on('change', 'input[name="global-currency"]', function(e) {
    let val = $(this).val();

    $.ajax({
        url: baseUrl+'/api/currency/update/'+val,
        beforeSend: function() {
            toastFire('info', 'Please wait...');
        },
        success: function(result) {
            if (result.status == 200) {
                toastFire('success', result.message);
                location.reload();
            } else {
                toastFire('failure', result.message);
            }
        }
    });
});
// global currency update ends

function cartAdd(type, productId, userId, route) {
    var qty = 1;
    if($('input[name="product_qty"]').val()) {
        qty = $('input[name="product_qty"]').val();
    }

    $.ajax({
        url: route,
        method : 'post',
        data : {
            _token: $('input[name="_token"]').val(),
            user_id: userId,
            product_id: productId,
            qty: qty,
        },
        beforeSend: function() {
            $('.buy-now').attr('disabled', 'disabled')
            $('.add-cart').attr('disabled', 'disabled')
        },
        success: function(result) {
            if (result.status == 400) {
                toastFire('error', result.message);
            } else {
                if(result.token.length > 0) {
                    cookieStore.set({
                        name: "_cart-token",
                        value: result.token
                    });
                }

                $('#cartCountShow').html('<span id="user_cartCountHeader">'+result.count+'</span>');

                if (type == "add-to-cart") {
                    quickCartListUpdate();

                    $('.buy-now').attr('disabled', false);
                    $('.add-cart').attr('disabled', false);
                    toastFire('success', result.message);
                } else {
                    window.location = baseUrl+"/checkout";
                }
            }
        }
    });
};

function quickCartListUpdate() {
    $.ajax({
        url: baseUrl+'/cart/json',
        method : 'get',
        beforeSend: function() {
            let beforeContent = `
            <div class="empty text-center">
                <div class="image">
                    <img src="${baseUrl}/uploads/static-svgs/undraw_dog_walking_re_l61p.svg" alt="loading-cart" class="w-100">
                </div>
                <h6>Please wait...</h6>
                <p class="small text-muted">We are getting your cart content</p>
            </div>
            `;

            $('#quickCart #cart-status').html(beforeContent);
        },
        success: function(result) {
            let content = '';
            if (result.status == 400) {
                content += 
                `<div class="empty text-center">
                    <div class="image">
                        <img src="${baseUrl}/uploads/static-svgs/undraw_empty_cart_co35.svg" alt="empty-cart" class="w-100">
                    </div>
                    <h6>Your cart is empty</h6>
                    <p class="small text-muted">You do not have anything on your cart. Keep shopping &amp; Earn cashbacks !</p>
                </div>
                `;

                $('#quickCart #cart-status').html(content);

                // toastFire('error', result.message);
            } else {
                if (result.data.length > 0) {
                    content += `
                    <div class="cart-exists">
                        <div class="c-content">
                            <div class="products">
                    `;

                    $.each(result.data, (key, value) => {
                        content += 
                        `<div class="quick-cart-single-product">
                            <div class="d-flex">
                                <div class="image-part flex-shrink-0">
                                    <a href="${value.link}" target="_blank">
                                        <div class="image-holder">
                                            <img src="${value.image}" alt="${value.slug}">
                                        </div>
                                    </a>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="title">
                                        <a href="${value.link}" target="_blank">
                                            <p class="text-dark height-2 small">${value.title}</p>
                                        </a>
                                    </div>

                                    <div class="pricing">
                                        <div class="price-details">
                                            <h5 class="selling-price">
                                                <span class="currency-icon">${value.currencyEntity}</span>
                                                <span class="amount">${value.sellingPrice}</span>
                                            </h5>
                                            <h6 class="mrp">
                                                <span class="currency-icon">${value.currencyEntity}</span>
                                                <span class="amount">${value.mrp}</span>
                                            </h6>
                                            <h6 class="discount">
                                                <span>${value.discount}</span>
                                                <span>off</span>
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="variation-details">
                                        <div class="single-variation">
                                            <div class="title">Qty:</div>
                                            <div class="quantity">
                                                <select class="form-select form-select-sm" name="cart-qty-${value.cartId}" id="cart-qty-${value.cartId}" onchange="qtyUpdate(${value.cartId})">
                                                    <option value="" selected disabled>${value.qty}</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>`;

                                    if(currentPage() != "checkout") {
                                        content += 
                                        `<div class="remove">
                                            <a href="javascript: void(0)" class="me-2" onclick="saveForLater(${value.cartId})">Save for later</a>
                                            <a href="javascript: void(0)" onclick="removeFromCart(${value.cartId})">Remove</a>
                                        </div>`;
                                    }

                                content += `</div>
                            </div>
                        </div>
                        `;
                    });
                    content += `</div>`;

                    if (result.amount.couponApplicable == 0) {
                        content += 
                        `<div class="coupon-details">
                            <div class="heading">
                                <div class="icon">
                                    <i class="material-icons">redeem</i>
                                </div>
                                <p class="fw-bold mb-0">Coupon</p>
                            </div>
                            <div class="view">
                                <a href="javascript: void(0)" onclick="allCouponsList()">View all coupons</a>
                            </div>
                            <div class="apply">
                                <form action="" method="post" id="coupon-form" onsubmit="couponApply('cart-form');return false">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Enter Coupon code/ Voucher..." name="coupon" aria-label="Enter Coupon code/ Voucher" aria-describedby="coupon-addon">
                                        <span class="input-group-text" id="coupon-addon">
                                            <button type="submit">APPLY</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>`;
                    } else {
                        content += 
                        `<div class="coupon-details">
                            <div class="heading">
                                <div class="icon">
                                    <i class="material-icons">redeem</i>
                                </div>
                                <p class="fw-bold mb-0">Coupon</p>
                            </div>
                            <div class="view">
                                <div class="d-flex justify-content-between">
                                <a href="javascript: void(0)" onclick="allCouponsList()">View all coupons</a>
                                    <a href="javascript: void(0)" onclick="removeCartCoupon()">Remove coupon</a>
                                </div>
                            </div>
                            <div class="apply">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-plaintext" placeholder="Enter Coupon code/ Voucher..." name="coupon" aria-label="Enter Coupon code/ Voucher" aria-describedby="coupon-addon" value="${result.amount.couponName}" readonly disabled>
                                    <span class="input-group-text coupon-applied" id="coupon-addon">
                                        <button type="submit">APPLIED</button>
                                    </span>
                                </div>
                            </div>
                        </div>`;
                    }

                    content += 
                    `<div class="price-details">
                        <div class="heading">
                            <div class="icon">
                                <i class="material-icons">payments</i>
                            </div>
                            <p class="fw-bold mb-0">Summary</p>
                        </div>

                        <div class="price-data">
                            <table class="table table sm">
                                <tbody>
                                    <tr>
                                        <td class="title text-muted">Total cart value</td>
                                        <td class="text-end currency">
                                            <span class="currency-icon">${result.amount.currencyEntity}</span>
                                            <span class="amount">${result.amount.totalCartAmount}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title text-muted">Shipping</td>
                                        <td class="text-end currency">
                                            <span class="currency-icon">${result.amount.currencyEntity}</span>
                                            <span class="amount">${result.amount.shippingCharge}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title text-muted">TAX</td>
                                        <td class="text-end currency">
                                            <span class="currency-icon">${result.amount.currencyEntity}</span>
                                            <span class="amount">${result.amount.taxCharge}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title text-muted">Discount</td>
                                        <td class="text-end currency">
                                            <span class="currency-icon">${result.amount.currencyEntity}</span>
                                            <span class="amount">${result.amount.couponDiscount}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title text-muted fw-bold">PAY</td>
                                        <td class="text-end currency fw-bold">
                                            <span class="currency-icon">${result.amount.currencyEntity}</span>
                                            <span class="amount">${result.amount.finalCartValue}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                    `;

                    if(currentPage() != "checkout") {
                        content += 
                        `<div class="goto-links">
                            <a href="${baseUrl}/checkout" class="btn btn-dark w-100 checkout">
                                Checkout
                                <div class="icon"><i class="material-icons md-light">chevron_right</i></div>
                            </a>
                        </div>
                        `;
                    }

                    content+= `</div>`;
                }

                $('#quickCart #cart-status').html(content);
            }
            if(currentPage() != "checkout") {
                quickCartEl.show();
            }
        }
    });
}

function allCouponsList() {
    $.ajax({
        url: baseUrl+'/coupon/list',
        success: function(result) {
            if (result.status == 200) {
                let content = '';

                if (result.data.length > 0) {
                    content += 
                    `<div class="coupons-found">
                        <div class="c-content">`;

                        $.each(result.data, (key, val) => {
                            content += `<div class="single-coupon">
                                <div class="card rounded-0">
                                    <div class="card-body">
                                        <div class="highlight-part">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h6 class="coupon-code">${val.code}</h6>
                                                    <p class="text-muted mb-0">
                                                        ${val.discountHtml}
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <a href="javascript: void(0)" class="btn btn-sm btn-dark rounded-0" onclick="couponApply('${val.code}')">APPLY</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="detailed-part mt-3">
                                            <p>${val.details}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                        });

                        content += 
                        `</div>
                    </div>
                    `;
                } else {
                    content += 
                    `<div class="coupons-missing">
                        <div class="empty text-center">
                            <div class="image">
                                <img src="${baseUrl}/uploads/static-svgs/undraw_no_data_re_kwbl.svg" alt="no-coupons" class="w-100">
                            </div>
                            <h6>No coupons found</h6>
                            <p class="small text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, deleniti!</p>
                        </div>
                    </div>
                    `;
                    toastFire('info', 'No coupons available at this moment');
                }

                $('#publicCoupon #public-coupons').html(content);
                publicCouponEl.show();
            } else {
                toastFire('error', result.message);
            }
        }
    });
}

function couponApply(type) {
    if (type == 'cart-form') {
        var coupon = $('input[name="coupon"]').val();
    } else {
        var coupon = type;
    }

    if (coupon.length > 0) {
        $.ajax({
            url: baseUrl+'/coupon/check/json',
            method : 'post',
            data: {
                _token: $('input[name="_token"]').val(),
                coupon: coupon
            },
            success: function(result) {
                if (result.status == 200) {
                    quickCartListUpdate();
                    publicCouponEl.hide();
                    toastFire('success', result.message);
                } else {
                    toastFire('error', result.message);
                }
            }
        });
    }
}

function removeCartCoupon() {
    $.ajax({
        url: baseUrl+'/coupon/remove',
        success: function(result) {
            if (result.status == 200) {
                quickCartListUpdate();
                toastFire('success', result.message);
            } else {
                toastFire('error', result.message);
            }
        }
    });
}

function saveForLater(id) {
    $.ajax({
        url: baseUrl+'/cart/save-later/'+id,
        method : 'get',
        success: function(result) {
            if (result.status == 200) {
                quickCartListUpdate();
                if (result.data == 0) {
                    $('#cartCountShow').html('<span id="user_cartCountHeader"></span>');
                } else {
                    $('#cartCountShow').html('<span id="user_cartCountHeader">'+result.data+'</span>');
                }
                toastFire('success', result.message);
            } else {
                if (result.type == 'login') {
                    loginModalEl.show();
                }
                toastFire('error', result.message);
            }
        }
    });
}

function removeFromCart(id) {
    $.ajax({
        url: baseUrl+'/cart/remove/'+id,
        method : 'get',
        success: function(result) {
            if (result.status == 200) {
                quickCartListUpdate();
                if (result.data == 0) {
                    $('#cartCountShow').html('<span id="user_cartCountHeader"></span>');
                } else {
                    $('#cartCountShow').html('<span id="user_cartCountHeader">'+result.data+'</span>');
                }
                toastFire('success', result.message);
            } else {
                toastFire('error', result.message);
            }
        }
    });
}

function qtyUpdate(id) {
    let qty = $('#cart-qty-'+id).val();
    $.ajax({
        url: baseUrl+'/cart/qty/update',
        method : 'post',
        data: {
            _token: $('input[name="_token"]').val(),
            id: id,
            qty: qty,
        },
        success: function(result) {
            if (result.status == 200) {
                quickCartListUpdate();
                toastFire('success', result.message);
            } else {
                toastFire('error', result.message);
            }
        }
    });
}

function makeBillingSameAsDeliveryAddr() {
    $.ajax({
        url: baseUrl+'/checkout/billing-address/remove/all',
        success: function(result) {
            if (result.status == 200) {
                toastFire('success', result.message);
                location.href = baseUrl+'checkout';
            } else {
                toastFire('error', result.message);
            }
        }
    });
}

$('input[name="delivery-address"]').on('change', function() {
    let prevText = $('#address-head-detail').text();
    let updatedText = $(this).attr("data-detail");

    $.ajax({
        url: baseUrl+'/user/address/default/'+$(this).val(),
        beforeSend: function() {
            $('#address-head-detail').text('Updating delivery address...');
        },
        success: function(resp) {
            if (resp.status == 200) {
                toastFire('success', 'Delivery address updated');
                $('#address-head-detail').text(updatedText);
            } else {
                $('#address-head-detail').text(prevText);
                toastFire('error', 'Something happened');
            }
        }
    })
});

if(currentPage() == "checkout") {
    const addDeliveryAddressEl = document.getElementById('addDeliveryAddress')
    const addBillingAddressEl = document.getElementById('addBillingAddress')

    addDeliveryAddressEl.addEventListener('show.bs.collapse', event => {
        document.getElementById('confirmedAddress').style.display = 'none';
        document.getElementById('billing-address').style.display = 'none';
    });
    addDeliveryAddressEl.addEventListener('hide.bs.collapse', event => {
        document.getElementById('confirmedAddress').style.display = 'block';
        document.getElementById('billing-address').style.display = 'block';
    });
    addBillingAddressEl.addEventListener('show.bs.collapse', event => {
        document.getElementById('confirmedAddress').style.display = 'none';
        document.getElementById('delivery-address').style.display = 'none';
        document.getElementById('delivery-billing-address').style.display = 'none';
    });
    addBillingAddressEl.addEventListener('hide.bs.collapse', event => {
        document.getElementById('confirmedAddress').style.display = 'block';
        document.getElementById('delivery-address').style.display = 'block';
        document.getElementById('delivery-billing-address').style.display = 'block';
    });
}

function editProfile() {
    $('.profile_default').hide();
    $('.profile_edit').show();
}

function cancelEditProfile() {
    $('.profile_default').show();
    $('.profile_edit').hide();
}

function addAddress() {
    $('.add-address-block').show();
    $('.address-hide-block').hide();
}

function hideAddAddress() {
    $('.add-address-block').hide();
    $('.address-hide-block').show();
}

function defaultAddressSet(id) {
    event.preventDefault();
    $.ajax({
        url: baseUrl+'default/'+id,
        success: function(resp) {
            if (resp.status == 200) {
                toastFire('success', 'Delivery address updated');
                location.reload();
                // window.location = 'user/address';
            } else {
                toastFire('error', 'Something happened');
            }
        }
    })
}

$(document).on('submit', '#passVerifyForm', function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: {
            _token: $('input[name="_token"]').val(),
            oldPassword: $('input[name="old-password"]').val(),
        },
        success: function(resp) {
            if (resp.status == 200) {
                $('#newPassLimiter').show();
                $('#newPasswordField').show();
                $('input[name="new-password"]').focus();

                // btn update
                $('#changeBtn').text('Change Password');

                // form update
                $('#passVerifyForm').attr('action', baseUrl+'/user/password/update');
                $('#passVerifyForm').attr('id', 'passUpdateForm');

                toastFire('success', resp.message);
            } else {
                $('#newPassLimiter').hide();
                $('#newPasswordField').hide();
                $('input[name="old-password"]').focus();
                toastFire('error', resp.message);
            }
        }
    })
});

$(document).on('submit', '#passUpdateForm', function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: {
            _token: $('input[name="_token"]').val(),
            oldPassword: $('input[name="old-password"]').val(),
            newPassword: $('input[name="new-password"]').val(),
            confirmPassword: $('input[name="confirm-password"]').val(),
        },
        success: function(resp) {
            if (resp.status == 200) {
                let content = `
                <div class="row">
                    <div class="col-12">
                        <div class="empty text-center">
                            <div class="image" style="width: 110px;">
                                <img src="${baseUrl}/uploads/static-svgs/undraw_authentication_re_svpt.svg" alt="password-updated" class="w-100">
                            </div>
                            <h6>Password updated...</h6>
                            <p class="small text-muted">Redirecting to my account page...</p>
                            <a href="${baseUrl}/user/account" class="btn btn-sm rounded-0 btn-dark">Go to My Account</a>
                        </div>
                    </div>
                </div>
                `;

                $('.password-update-content').html(content);

                toastFire('success', resp.message);

                setTimeout(() => {
                    window.location = `${baseUrl}/user/account`;
                }, 3000);
            } else {
                toastFire('error', resp.message);
            }
        }
    })
});

function wishlistToggle(productId) {
    // alert(baseUrl);
    $.ajax({
        url: baseUrl+'/wishlist/toggle/'+productId,
        // beforeSend: function () {
        //     if ($($this).hasClass('active')) {
        //         $('#wishlist_toggle > i.material-icons').html('favorite_border');
        //         $($this).removeClass('active').addClass('pulse');
        //         setTimeout(() => {
        //             $($this).removeClass('pulse');
        //         }, 500);
        //     } else {
        //         $('#wishlist_toggle > i.material-icons').html('favorite');
        //         $($this).addClass('active pulse danger');
        //         setTimeout(() => {
        //             $($this).removeClass('pulse');
        //         }, 500);
        //     }
        // },
        success: function(resp) {
            if (resp.status == 200) {
                if (resp.type == 'added') {
                    $('.wish-product-'+productId).addClass('active').html('<i class="material-icons">favorite</i>');
                } else {
                    $('.wish-product-'+productId).removeClass('active').html('<i class="material-icons">favorite_border</i>');
                }
                toastFire('success', resp.message);
            } else {
                if (resp.type == 'login') {
                    loginModalEl.show();
                }
                toastFire('error', resp.message);
            }
        }
    });
}