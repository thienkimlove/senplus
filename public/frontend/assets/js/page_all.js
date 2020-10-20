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
  $('#showMenuGuide').click(function () {
    $('#menuQuestion').toggleClass('showMenu');
    $('#menuQuestion').mouseleave(function () {
      $(this).removeClass('showMenu');
    });
  });
  $('.userBlock').click(function () {
    $('body').toggleClass('fixed');
    $('#popupProfile').toggleClass('showPopProfile');
    $('#popupProfile .closePopup').click(function () {
      $('#popupProfile').toggleClass('showPopProfile');
      $('body').toggleClass('fixed');
    });
    $('#popupProfile').mouseleave(function () {
      $(this).removeClass('showPopProfile');
    });
  });
  $('#btnShowMainMenu').click(function () {
    showMenuSide = 1;
    $('body').toggleClass('fixed');
    $(this).toggleClass('closeSt');
    $('#popupCorporateCulture').toggleClass('showPopCorCul');
    $('#popupCorporateCulture .closePopup').click(function () {
      $('#popupCorporateCulture').toggleClass('showPopCorCul');
      $('body').toggleClass('fixed');
    });
    $('#popupCorporateCulture').mouseleave(function () {
      $(this).removeClass('showPopCorCul');
    });
  });

  if ($('.hasIconEdit').length > 0) {
    $('.hasIconEdit').click(function () {
      showPopup($(this));
    });
  }
});

function showPopup(btnClick) {
  var popup = $(btnClick).data('popup');
  $(popup).addClass('showPopup');
  $(popup).mouseleave(function () {
    $(this).removeClass('showPopup');
  });
}

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