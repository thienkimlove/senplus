$(document).ready(function () {
    if($('.wrapper').length>0){
        changeBg();
    }
    showPopupGuiding($('#popupGuidings'));
    var showHidePopup = 0;
    $('.showHidePopup').bind('click',function () {
        tooglePopup('.box_right');
        if(showHidePopup == 0){
            $('.openBtn').fadeOut(100);
            showHidePopup ++;
        }else {
            $('.openBtn').fadeIn(1000);
            showHidePopup --;
        }
    });
});
function tooglePopup(popup) {
    $(popup).toggleClass('openPopup');
}
function showPopupGuiding(popup) {
    $(popup).siblings().removeClass('showPopup');
    $(popup).addClass('showPopup');
    $('.bg_drop').fadeIn();
    $('.closePopup').click(function () {
        $('.bg_drop').fadeOut();
        $(popup).removeClass('showPopup');
    })
    $('.bg_drop').click(function () {
        $(this).fadeOut();
        $(popup).removeClass('showPopup');
    });
}

function showPopupNotify(popup) {
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
function changeBg() {
    var bg = 1;
    setInterval(function () {
           bg++;
           $('.wrapper').css('background','url(/frontend/assets/img/bg'+bg+'.jpg) center center no-repeat');
           if(bg>=5){
               bg=0;
           }
    },8000);
}