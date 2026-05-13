// Auto Popup Start

$(function () {
    var overlay = $('<div id="overlay"></div>');
    overlay.show();
    overlay.appendTo(document.body);
    setTimeout(function () {
        $('.popup-form-background').show();
    }, 6000);
    $('#close_popup').click(function () {
        $('.popup-form-background').hide();
        overlay.appendTo(document.body).remove();
        return false;
    });
});

// Auto Popup End


// Sidebar Form

$("#close_sidebar").click(function () {
    $(".sidebar-form-fix").css("right", "-250px");
})
$(".sidebar-btn").click(function () {
    $(".sidebar-form-fix").css("right", "0px");
})

$(document).ready(function () {

    //Button Popup Form

    $("#close_popup2").click(function () {
        $(".enquire-popup-form-background").css("display", "none");
    })
    $(".open_popup").click(function () {
        $(".enquire-popup-form-background").css("display", "block");
    })

    // mobile navbar
    $(".fa-bars").click(function () {
        $(".nav-links").toggleClass("open-nav");
    });

    $(".fa-bars").click(function () {
        $(".fa-bars").toggleClass("fa-x");
    });
});


// Smooth Scroll
$(document).ready(function () {
    $("a").on('click', function (event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function () {
                window.location.hash = hash;
            });
        }
    });
});