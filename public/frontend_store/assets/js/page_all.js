/*!
 * project_shg
 * 
 * 
 * @author Thuclfc
 * @version 2.0.0
 * Copyright 2020. MIT licensed.
 */$(document).ready(function () {
  $('.btnShowTab').click(function () {
    tabs($(this));
  });
  $('.tab').click(function () {
    tabs($(this));
  });
  $('.btnUserID').click(function () {
    $('#userPopup').toggleClass('active');
  });
});

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
  $(popup + ' .closePopup').click(function () {
    $('.bg_drop').fadeOut();
    $(popup).removeClass('showPopup');
  });
  $(popup + ' .bg_drop').click(function () {
    $(this).fadeOut();
    $(popup).removeClass('showPopup');
  });
}

function tabs(tab) {
  $(tab).siblings().removeClass('active');
  $(tab).addClass('active');
  var content = $(tab).data('content');
  $(content).siblings().removeClass('active');
  $(content).addClass('active');
}