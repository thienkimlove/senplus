$(document).ready(function () {
    var popup ='';
    $('.titleCampaign').hover(function () {
        popup = $(this).data('popup');
        $('.popupCampaign').removeClass('showPopup');
        $(popup).addClass('showPopup');
        $(popup).mouseover(function() {
            $(this).addClass('showPopup');
        }).mouseout(function() {
            $(this).removeClass('showPopup');
        });
    });

    $('.btnEdit').click(function () {
        edit($(this));
    });

    $('#inputSearchDemo').mousedown(function () {
        $('#searchUserBlock').addClass('showSearchUserBlock');
        $('#searchUserBlock').mouseleave(function () {
            $(this).removeClass('showSearchUserBlock');
        });
    });
});

function edit(btnEdit) {
    var dataNeedEdit = $(btnEdit).data('edit');
    $(dataNeedEdit).find('*').removeAttr('disabled').removeAttr('readonly');
    $(dataNeedEdit).find('*').removeClass('disabled');
    $('.form-group:last-child').addClass('showBtn');
    $('.btnSave').click(function () {
        $(dataNeedEdit).find('*').not('button').attr('disabled','disabled');
        $(dataNeedEdit).find('*').addClass('disabled');
        $('.form-group:last-child').removeClass('showBtn');
    })
}

