$(document).ready(function () {
    $('.userBlock').click(function () {
        $('#popupProfile').toggleClass('showPopProfile');
        $('#popupProfile .closePopup').click(function () {
            $('#popupProfile').removeClass('showPopProfile');
        });
        $('#popupProfile').mouseleave(function () {
            $(this).removeClass('showPopProfile');
        });
    });
    $('.btnHelpCenter').click(function () {
        $('#popupHelpCenter').addClass('showPop');
        $('body').addClass('fixed');
        $('#popupHelpCenter').mouseleave(function () {
            $(this).removeClass('showPop');
            $('body').removeClass('fixed');
        });
        $('#popupHelpCenter .closePopup').click(function () {
            $('#popupHelpCenter').removeClass('showPop');
            $('body').removeClass('fixed');
        });
    });
    $('#btnShowMainMenu').click(function () {
        $('#popupCorporateCulture').toggleClass('showPopCorCul');
        $('#popupCorporateCulture .closePopup').click(function () {
            $('#popupCorporateCulture').removeClass('showPopCorCul');
        });
        $('#popupCorporateCulture').mouseleave(function () {
            $(this).removeClass('showPopCorCul');
        });
    });
    if( $("#sliderNewPost").length > 0){
        $("#sliderNewPost").owlCarousel({
            autoPlay : false,
            navigation: true,
            pagination: false,
            paginationNumbers: false,
            paginationSpeed : 1000,
            singleItem : true,
            autoHeight : true
        });
    }
    if( $("#partnerSlider").length > 0){
        $("#partnerSlider").owlCarousel({
            autoPlay : true,
            navigation: true,
            pagination: false,
            paginationNumbers: false,
            paginationSpeed : 1000,
            singleItem : false,
            items: 5,
            responsive: true
        });
    }

    $(window).on('DOMMouseScroll mousewheel', function (event) {
        if (event.originalEvent.wheelDelta > 0) {
            if ($(this).scrollTop() >= 50) {
                $('header').addClass('show');
            } else if ($(this).scrollTop() < 20) {
                $('header').removeClass('show');
            }
        } else {
            $('header').removeClass('show');
        }
    });

    //scroll effect
    $.fn.isInViewport = function() {
        var elementTop = $(this).offset().top + 100;
        var elementBottom = elementTop + $(this).outerHeight() + 100;

        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();

        // return  viewportTop ;
        return elementBottom > viewportTop && elementTop < viewportBottom;
    };
    $(window).on('resize scroll load', function() {
        $('#effect1').each(function() {
            if ($(this).isInViewport()) {
                $('.card1,.card2, .card3').addClass('active');
            }else {
                $('.card1,.card2, .card3').removeClass('active');
            }
        });
        $('#effect2').each(function() {
            if ($(this).isInViewport()) {
                $('.card4,.card5, .card6').addClass('active');
            }else {
                $('.card4,.card5, .card6').removeClass('active');
            }
        });
        $('#sec2quotes').each(function() {
            if ($(this).isInViewport()) {
                $('#sec2quotes div').addClass('active');
            }else {
                $('#sec2quotes div').removeClass('active');
            }
        });
        $('#cOrange').each(function() {
            if ($(this).isInViewport()) {
                $(this).addClass('active');
            }else {
                $(this).removeClass('active');
            }
        });
        $('#cPurple').each(function() {
            if ($(this).isInViewport()) {
                $(this).addClass('active');
            }else {
                $(this).removeClass('active');
            }
        });
        $('#cGreen').each(function() {
            if ($(this).isInViewport()) {
                $(this).addClass('active');
            }else {
                $(this).removeClass('active');
            }
        });
        $('#cBlue').each(function() {
            if ($(this).isInViewport()) {
                $(this).addClass('active');
            }else {
                $(this).removeClass('active');
            }
        });
        $('#section3 .title').each(function() {
            if ($(this).isInViewport()) {
                $(this).addClass('active');
            }else {
                $(this).removeClass('active');
            }
        });
    });
    $('#section7 .content1 .item .name').click(function () {
        var item = $(this).parent();
        item.toggleClass('active');
    });
    $('#section7 .content1 .item .company').click(function () {
        var item = $(this).parent();
        item.toggleClass('active');
    });
});

function tooglePopup(popup) {
    $(popup).toggleClass('openPopup');
}
function showPopup(btnClick) {
    let popup = $(btnClick).data('popup');
    $(popup).addClass('showPopup');
    $('.bg_drop').fadeIn();
    $('.closePopup').click(function () {
        $('.bg_drop').fadeOut();
        $(popup).removeClass('showPopup');
    });
    $('.bg_drop').click(function () {
        $(this).fadeOut();
        $(popup).removeClass('showPopup');
    });
}
function showPopupNotify(popup) {
    $(popup).siblings().removeClass('showPopup');
    $(popup).addClass('showPopup');
    $('.bg_drop').fadeIn();
    $('.closePopup').click(function () {
        $('.bg_drop').fadeOut();
        $(popup).removeClass('showPopup');
    });
}
