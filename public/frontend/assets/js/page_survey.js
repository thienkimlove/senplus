/*!
 * project_shg
 * 
 * 
 * @author Thuclfc
 * @version 2.0.0
 * Copyright 2020. MIT licensed.
 */$(document).ready(function () {
  $('.btnEdit').click(function () {
    edit($(this));
  });

  if ($('.datepicker').length > 0) {
    $('.datepicker').datetimepicker({
      format:'DD/MM/YYYY HH:mm:ss'
    });
  }
});

function edit(btnEdit) {
  var dataNeedEdit = $(btnEdit).data('edit');
  $(dataNeedEdit).find('*').removeAttr('disabled').removeAttr('readonly');
  $(dataNeedEdit).find('*').removeClass('disabled');
  $(dataNeedEdit).find('#formButton').addClass('showBtn');
  $('.btnCancel').click(function () {
    $(dataNeedEdit).find('*').not('button').attr('disabled', 'disabled');
    $(dataNeedEdit).find('*').addClass('disabled');
    $(dataNeedEdit).find('#formButton').removeClass('showBtn');
  });
}

function copyLink(linkNeedCopy) {
  var copyText = $(linkNeedCopy);
  copyText.attr('value');
  document.execCommand("copy");
}