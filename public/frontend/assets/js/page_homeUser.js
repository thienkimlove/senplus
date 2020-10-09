/*!
 * project_shg
 * 
 * 
 * @author Thuclfc
 * @version 2.0.0
 * Copyright 2020. MIT licensed.
 */$(document).ready(function () {
  if ($('.datepicker').length > 0) {
    $('.datepicker').datetimepicker();
  }

  var popup = '';
  $('.titleCampaign').hover(function () {
    popup = $(this).data('popup');
    $('.popupCampaign').removeClass('showPopup');
    $(popup).addClass('showPopup');
    $(popup).mouseover(function () {
      $(this).addClass('showPopup');
    }).mouseout(function () {
      $(this).removeClass('showPopup');
    });
  });
  $('.btnEdit').click(function () {
    edit($(this));
  });
  $('.btnEditDate').click(function () {
    editDate($(this));
  });
  $('.checkBoxGroup').click(function () {
    editCheckbox($(this));
  }); // $('#surveyObject').click(function () {
  //     editManyCheckbox($(this));
  // });

  $('#btnEditPermission').click(function () {
    editCheckbox($(this));
  });
  $('#inputSearchDemo').mousedown(function () {
    $('#searchUserBlock').addClass('showSearchUserBlock');
    $('#searchUserBlock').mouseleave(function () {
      $(this).removeClass('showSearchUserBlock');
    });
  });
});

function showPopup(btnClick) {
  var popup = $(btnClick).data('popup');
  $(popup).addClass('showPopup');
  $(popup).mouseleave(function () {
    $(this).removeClass('showPopup');
  });
}

function edit(btnEdit) {
  var dataNeedEdit = $(btnEdit).data('edit');
  $(dataNeedEdit).find('*').removeAttr('disabled').removeAttr('readonly');
  $(dataNeedEdit).find('*').removeClass('disabled');
  $('.btnSave').click(function () {
    $(dataNeedEdit).find('*').not('button').attr('disabled', 'disabled');
    $(dataNeedEdit).find('*').addClass('disabled');
  });
}

function editDate(btnEdit) {
  var dataNeedEdit = $(btnEdit).data('edit');
  $(dataNeedEdit).removeAttr('readonly');
  $(dataNeedEdit).removeClass('disabled');
  $(dataNeedEdit).parent().mouseleave(function (e) {
    $(dataNeedEdit).attr('readonly', 'readonly');
    $(dataNeedEdit).addClass('disabled');
    e.preventDefault();
  });
}

function editCheckbox(btnEdit) {
  var positionShow = $(btnEdit).data('show');
  var inputCheck = $(btnEdit).find('input');
  $(inputCheck).prop('checked', false);
  $(inputCheck).change(function (e) {
    $($(this)).prop('checked', true);
    $(positionShow).attr('value', $(this).val());
    e.preventDefault();
  });
}

function editManyCheckbox(btnEdit) {
  var uncheck = [];
  var manyCheck = [];
  var positionShow = $(btnEdit).data('show');
  var inputCheck = $(btnEdit).find('input');
  $(inputCheck).removeAttr('checked');
  $(inputCheck).prop('checked', false);
  $.each(inputCheck, function (key, value) {
    $(this).change(function (e) {
      e.preventDefault();
      toggleCheck($(this));

      if ($(this).hasClass('checked')) {
        manyCheck.push($(this).val());
      } else {
        uncheck.push($(this).val());
      }

      const new_arr = manyCheck.filter(item => !uncheck.includes(item));
      $('.btnChoose').click(function () {
        $(positionShow).attr('value', removeDuplicates(new_arr)); // $(btnEdit).addClass('disabled');

        $(inputCheck).removeClass('checked');
      });
    });
  });
}

function toggleCheck(input) {
  $(input).toggleClass('checked');
}

function removeDuplicates(arr) {
  var deduper = {};
  arr.forEach(function (item) {
    deduper[item] = null;
  });
  return Object.keys(deduper);
}

function copyLink(linkNeedCopy) {
  var copyText = document.getElementById(linkNeedCopy);
  copyText.select();
  document.execCommand("copy");
}