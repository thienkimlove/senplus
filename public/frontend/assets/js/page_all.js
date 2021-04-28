$(document).ready(function () {
    //...................js all page----------------------
    $('.manyTags .rightTitle').click(function () {
        $('.manyTags .fixCen2').toggleClass('active');
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
        $('#popupProfile .closePopup').click(function () {
            $('#popupProfile').removeClass('showPopProfile');
        });
        $('#popupProfile').mouseleave(function () {
            $(this).removeClass('showPopProfile');
        });
    });
    $('#btnShowMainMenu').click(function () {
        showMainMenu($(this));
    });
    $('#inputSearchDemo').mousedown(function () {
        $('#filterDataBox').addClass('showSearchUserBlock');
        $('#filterDataBox .btnView').click(function () {
            $('#filterDataBox').removeClass('showSearchUserBlock');
        });
        $('#searchUserBlock').addClass('showSearchUserBlock').mouseleave(function () {
            $(this).removeClass('showSearchUserBlock');
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

    $('.btnEdit').click(function () {
        edit($(this));
    });

    // page survey js

    if ($('.datepicker').length > 0) {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY HH:mm:ss'
        });
    }

    $('#showMenuGuide,#showMenuGuideMb').click(function () {
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

    //..................js result page --------------//

    if($('.multiSeclect').length){
        $('.multiSeclect').val(0);
        $('.multiSeclect').selectpicker('refresh')
    }

});
function showMainMenu(btnClick) {
    $('#popupCorporateCulture').toggleClass('showPopCorCul');
    $('#popupCorporateCulture .closePopup').click(function () {
        $('#popupCorporateCulture').removeClass('showPopCorCul');
    });
    $('#popupCorporateCulture').mouseleave(function () {
        $(this).removeClass('showPopCorCul');
    });
}
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

function copyLink(linkNeedCopy) {
    let copyText = $(linkNeedCopy);
    copyText.attr('value');
    document.execCommand("copy");
}

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
                    borderColor: '#c1ad79',
                    data: [null, eResult[1]['option2'], null, eResult[1]['option3'], null, eResult[1]['option4'], null, eResult[1]['option1']]
                },
                {
                    label: mapRound[2],
                    //backgroundColor: 'pink',
                    borderColor: '#3aadbb',
                    data: [null, eResult[2]['option2'], null, eResult[2]['option3'], null, eResult[2]['option4'], null, eResult[2]['option1']]
                }
            ],
        },

        // Configuration options go here
        options: {
            responsive: true,
            aspectRatio: 1.5,
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            legend: {
                position: 'bottom'
            },
            spanGaps: true,
            scale: {
                angleLines: {
                    display: false
                },
                ticks: {
                    suggestedMin: 0
                }
            }
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