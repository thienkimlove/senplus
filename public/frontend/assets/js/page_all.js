/*!
 * project_shg
 * 
 * 
 * @author Thuclfc
 * @version 2.0.0
 * Copyright 2020. MIT licensed.
 */
$(document).ready(function () {
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

    // js page home user
    let popup = '';
    $('.titleCampaign').hover(function () {
        popup = $(this).data('popup');
        $('.popupCampaign').removeClass('showPopup');
        $(popup).addClass('showPopup').mouseover(function () {
            $(this).addClass('showPopup');
        }).mouseout(function () {
            $(this).removeClass('showPopup');
        });
    });
    $('.btnEditHomeUser').click(function () {
        editHomeUserPage($(this));
    });
    $('#inputSearchDemo').mousedown(function () {
        $('#searchUserBlock').addClass('showSearchUserBlock').mouseleave(function () {
            $(this).removeClass('showSearchUserBlock');
        });
    });

    // page survey js

    $('.btnEditSurvey').click(function () {
        editSurveyType($(this));
    });

    if ($('.datepicker').length > 0) {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY HH:mm:ss'
        });
    }

    $('#showMenuGuide').click(function () {
        $('#menuQuestion').toggleClass('showMenu').mouseleave(function () {
            $(this).removeClass('showMenu');
        });
    });

    let hasIconEdit = $('.hasIconEdit');

    if (hasIconEdit.length > 0) {
        hasIconEdit.click(function () {
            showPopup($(this));
        });
    }


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

});

function showPopup(btnClick) {
    let popup = $(btnClick).data('popup');
    $(popup).addClass('showPopup');
    $(popup).mouseleave(function () {
        $(this).removeClass('showPopup');
    });
}

function showPopupGuiding(popup) {
    $(popup).siblings().removeClass('showPopup');
    $(popup).addClass('showPopup');
    let bgDrop = $('.bg_drop');
    bgDrop.fadeIn();
    $('.closePopup').click(function () {
        bgDrop.fadeOut();
        $(popup).removeClass('showPopup');
    });
    bgDrop.click(function () {
        $(this).fadeOut();
        $(popup).removeClass('showPopup');
    });
}

function showPopupNotify(popup) {
    $(popup).addClass('showPopup');

    let bgDrop = $('.bg_drop');

    bgDrop.fadeIn();
    $('.closePopup').click(function () {
        bgDrop.fadeOut();
        $(popup).removeClass('showPopup');
    });
    bgDrop.click(function () {
        $(this).fadeOut();
        $(popup).removeClass('showPopup');
    });
}

function editHomeUserPage(btnEdit) {
    let dataNeedEdit = $(btnEdit).data('edit');
    $(dataNeedEdit).find('*').removeAttr('disabled').removeAttr('readonly');
    $(dataNeedEdit).find('*').removeClass('disabled');
    $('.form-group:last-child').addClass('showBtn');
    $('.btnSave').click(function () {
        $(dataNeedEdit).find('*').not('button').attr('disabled', 'disabled');
        $(dataNeedEdit).find('*').addClass('disabled');
        $('.form-group:last-child').removeClass('showBtn');
    });
}

function editSurveyType(btnEdit) {
    let dataNeedEdit = $(btnEdit).data('edit');
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
    let copyText = $(linkNeedCopy);
    copyText.attr('value');
    document.execCommand("copy");
}

function showPopupNotifyWithParams(surveyId) {
    let popup = '#popupDelSurveyWithParam';
    let dropElement = $('.bg_drop');
    $(popup).addClass('showPopup');
    dropElement.fadeIn();
    $('.closePopup').click(function () {
        $('.bg_drop').fadeOut();
        $(popup).removeClass('showPopup');
    });
    dropElement.click(function () {
        $(this).fadeOut();
        $(popup).removeClass('showPopup');
    });

    $('#popup_button_del_survey').click(function(){

        let token = $('#popup_token').val();
        $.ajax({
            url: '/handleDelSurvey',
            type: 'POST',
            data: {
                _token: token,
                survey_id: surveyId
            },
            success: function (data) {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.error);
                }
            }
        });

    });
}

function drawArrow(context, fromx, fromy, tox, toy) {
    let headlen = 10;
    let dx = tox - fromx;
    let dy = toy - fromy;
    let angle = Math.atan2(dy, dx);
    context.moveTo(fromx, fromy);
    context.lineTo(tox, toy);
    context.lineTo(tox - headlen * Math.cos(angle - Math.PI / 6), toy - headlen * Math.sin(angle - Math.PI / 6));
    context.moveTo(tox, toy);
    context.lineTo(tox - headlen * Math.cos(angle + Math.PI / 6), toy - headlen * Math.sin(angle + Math.PI / 6));
}

function makeChart(ctx, mapOption, mapRound, eResult) {

    let chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'radar',

        // The data for our dataset
        data: {
            labels: [
                'Linh hoạt',
                mapOption["option2"],
                'Hướng ngoại',
                mapOption["option3"],
                'Ổn định',
                mapOption["option4"],
                'Hướng nội',
                mapOption["option1"]
            ],
            datasets: [
                {
                    label: mapRound[1],
                    //backgroundColor: 'green',
                    borderColor: 'green',
                    data: [null, eResult[1]['option2'], null, eResult[1]['option3'], null, eResult[1]['option4'], null, eResult[1]['option1']]
                },
                {
                    label: mapRound[2],
                    //backgroundColor: 'pink',
                    borderColor: 'red',
                    data: [null, eResult[2]['option2'], null, eResult[2]['option3'], null, eResult[2]['option4'], null, eResult[2]['option1']]
                }
            ],
        },

        // Configuration options go here
        options: {
            responsive: true,
            legend: {
                position: 'top'
            },
            spanGaps: true,
        },
        plugins: [{
            beforeDraw: function(chart, options) {
                let ctx = chart.chart.ctx;
                let yaxis = chart.scales['scale'];
                let paddingX = 0;
                let paddingY = 0;

                ctx.save();
                ctx.beginPath();
                ctx.strokeStyle = '#000000';
                ctx.lineWidth = 1.75;

                drawArrow(ctx, yaxis.xCenter, yaxis.yCenter, yaxis.xCenter - yaxis.drawingArea - paddingX, yaxis.yCenter);
                drawArrow(ctx, yaxis.xCenter, yaxis.yCenter, yaxis.xCenter + yaxis.drawingArea + paddingX, yaxis.yCenter);
                drawArrow(ctx, yaxis.xCenter, yaxis.yCenter, yaxis.xCenter, yaxis.yCenter - yaxis.drawingArea - paddingY);
                drawArrow(ctx, yaxis.xCenter, yaxis.yCenter, yaxis.xCenter, yaxis.yCenter + yaxis.drawingArea + paddingY);

                ctx.stroke();
                ctx.restore();
            }
        }]

    });
}