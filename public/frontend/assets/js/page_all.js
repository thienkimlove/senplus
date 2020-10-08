/*!
 * project_shg
 * 
 * 
 * @author Thuclfc
 * @version 2.0.0
 * Copyright 2020. MIT licensed.
 */$(document).ready(function () {
  $('.btnUserID').click(function () {
    $('#userPopup').toggleClass('active');
  });
  var showHidePopup = 0;
  $('.showHidePopup').bind('click', function () {
    tooglePopup('.box_right');

    if (showHidePopup == 0) {
      $('.openBtn').fadeOut(100);
      showHidePopup++;
    } else {
      $('.openBtn').fadeIn(1000);
      showHidePopup--;
    }
  });
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
  });
  $('#popupProfile .closePopup').click(function () {
    $('#popupProfile').toggleClass('showPopProfile');
  });
  $('#btnShowMainMenu').click(function () {
    $('#popupCorporateCulture').toggleClass('showPopCorCul');
  });
  $('#popupCorporateCulture .closePopup').click(function () {
    $('#popupCorporateCulture').toggleClass('showPopCorCul');
  });
});

function tooglePopup(popup) {
  $(popup).toggleClass('openPopup');
}

function showMenu(btnShowMenu) {
  $('#mainMenu').addClass('active');
  $('#mainMenu .bg_drop').click(function () {
    $('#mainMenu').removeClass('active');
  });
}

function showPopup(popup) {
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