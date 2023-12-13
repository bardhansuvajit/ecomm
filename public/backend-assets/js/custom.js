$('form').on('submit', () => {
    $('button[type="submit"]').prop('disabled', true).text('Loading...');
});

var $scroll = $('.sidebar');
$('.nav-item > a').each(function () {
    if ($(this).hasClass('active')) {
        $scroll.scrollTop($(this).position().top + $scroll.scrollTop())
    }
})

// sweetalert toast
function toastFire(type = 'success', title) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom',
        timer: 3000,
        showCloseButton: true,
        showConfirmButton: false,
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

//  enable tooltip everywhere
$('[data-toggle="tooltip"]').tooltip();

// category create page
$('input[name=level]').on('change', function() {
    checkCatParentLevel();
});

function checkCatParentLevel() {
    let lavel = $('input[name=level]:checked').val();

    if (lavel === "parent") {
        $('#selectParent').hide();
    } else {
        $('#selectParent').show();
    }
}

// status toggle
function statusToggle(route) {
    $.ajax({
        url: route,
        success: function(resp) {
            if (resp.status == 200) {
                toastFire('success', resp.message);
            } else {
                toastFire('error', resp.message);
            }
        }
    });
}

// product/ order status change
function statusUpdate(route, status) {
    $.ajax({
        url: route,
        data: {
            status: status
        },
        success: function(resp) {
            if (resp.status == 200) {
                toastFire('success', resp.message);
            } else {
                toastFire('error', resp.message);
            }
        }
    });
}

// jquery UI sortable
$( ".sortable" ).sortable({
    delay: 150,
    stop: function() {
        var selectedData = new Array();
        var route = $(this).attr('data-position-update-route');
        var token = $(this).attr('data-csrf-token');
        $('.sortable > .single').each(function() {
            selectedData.push($(this).attr('id'));
        });
        updatePosition(selectedData, route, token);
    }
});

function updatePosition(data, route, token) {
    $.ajax({
        url: route,
        type: 'post',
        data: {'_token': token, position: data},
        success: function(resp) {
            if (resp.status == 200) {
                toastFire('success', resp.message);
            } else {
                toastFire('error', resp.message);
            }
            // alert('your change successfully saved');
        }
    })
}

// image height, width
function imgDetails(imgPath) {
    var resp = [];
    // var img = document.createElement("img");
    // img.onload = function (event) {
    //     var width = img.naturalWidth;
    //     var height = img.naturalHeight;
    //     // console.log("natural:", img.naturalWidth, img.naturalHeight);
    //     // console.log("width,height:", img.width, img.height);
    //     // console.log("offsetW,offsetH:", img.offsetWidth, img.offsetHeight);
    // }
    // img.src = imgPath;
    // // document.body.appendChild(img);
    var width = height = 0;
    resp = [width, height];
    return resp;
}
