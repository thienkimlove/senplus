/*!
 * project_shg
 * 
 * 
 * @author Thuclfc
 * @version 2.0.0
 * Copyright 2020. MIT licensed.
 */$(document).ready(function () {
  $(window).on('DOMMouseScroll mousewheel', function (event) {
    if (event.originalEvent.wheelDelta > 0) {
      if ($(this).scrollTop() >= 50) {
        $('header').addClass('fixed');
      } else if ($(this).scrollTop() < 20) {
        $('header').removeClass('fixed');
      }
    } else {
      $('header').removeClass('fixed');
    }
  });
  $('.userBlock').click(function () {
    $('#popupProfile').toggleClass('showPopProfile');
    $('#popupProfile .closePopup').click(function () {
      $('#popupProfile').toggleClass('showPopProfile');
    });
    $('#popupProfile').mouseleave(function () {
      $(this).removeClass('showPopProfile');
    });
  });
  $('#btnShowMainMenu').click(function () {
    $('#popupCorporateCulture').toggleClass('showPopCorCul');
    $('#popupCorporateCulture .closePopup').click(function () {
      $('#popupCorporateCulture').toggleClass('showPopCorCul');
    });
    $('#popupCorporateCulture').mouseleave(function () {
      $(this).removeClass('showPopCorCul');
    });
  });
  $('#inputSearchDemo').mousedown(function () {
    $('#filterDataBox').addClass('showSearchUserBlock');
    $('#filterDataBox .btnView').click(function () {
      $('#filterDataBox').removeClass('showSearchUserBlock');
    });
  });

  if ($('.multiSeclect').length) {
    $('.multiSeclect').val(0);
    $('.multiSeclect').selectpicker('refresh');
  }
});

function showPopupGuiding(popup) {
  $(popup).siblings().removeClass('showPopup');
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