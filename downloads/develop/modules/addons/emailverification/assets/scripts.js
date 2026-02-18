$.fn.timedDisable = function (time) {
    if (time == null) {
        time = 60;
    }
    var seconds = Math.ceil(time); // Calculate the number of seconds
    return $(this).each(function () {
        $(this).attr('disabled', 'disabled');
        var disabledElem = $(this);
        var originalText = this.innerHTML; // Remember the original text content

        // append the number of seconds to the text
        disabledElem.text(originalText + ' (' + seconds + ')');

        // do a set interval, using an interval of 1000 milliseconds
        //     and clear it after the number of seconds counts down to 0
        var interval = setInterval(function () {
            seconds = seconds - 1;
            // decrement the seconds and update the text
            disabledElem.text(originalText + ' (' + seconds + ')');
            if (seconds === 0) { // once seconds is 0...
                disabledElem.removeAttr('disabled')
                        .text(originalText); //reset to original text
                clearInterval(interval); // clear interval
            }
        }, 1000);
    });
};
$(document).ready(function () {
    $('#haveaccount').click(function () {
        window.location.href = 'index.php?m=emailverification&login=account';
    });
    $('.input-group input[required]').on('keyup change', function () {
        var $form = $(this).closest('form'),
                $group = $(this).closest('.input-group'),
                $addon = $group.find('.input-group-addon'),
                $icon = $addon.find('span'),
                state = false;

        if (!$group.data('validate')) {
            state = $(this).val() ? true : false;
        } else if ($group.data('validate') == "email") {
            state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())
        }

        if (state) {
            $.post("index.php?m=emailverification&verify=email", {
                check_mail: "1",
                email: $('#validate-email').val(),
                token: $('[name="token"]').val(),
            }, function (data, status) {
                if (data == 'yes') {
                    $addon.removeClass('danger');
                    $addon.addClass('success');
                    $icon.attr('class', 'glyphicon glyphicon-ok');
                    $form.find('#sendemailnow').prop('disabled', false);
                } else {
                    $form.find('#sendemailnow').prop('disabled', true);
                    $addon.removeClass('success');
                    $addon.addClass('danger');
                    $icon.attr('class', 'glyphicon glyphicon-remove');
                }
            });
        } else {
            $addon.removeClass('success');
            $addon.addClass('danger');
            $icon.attr('class', 'glyphicon glyphicon-remove');
        }

        if ($form.find('.input-group-addon.danger').length == 0) {
            $form.find('#sendemailnow').prop('disabled', false);
        } else {
            $form.find('#sendemailnow').prop('disabled', true);
        }
    });

    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').trigger('change');
    var tcli = 1;
    $('#sendemailnow').click(function () {
        if (tcli == 1) {
            $.post("index.php?m=emailverification&verify=email", {
                send_secode: "1",
                email: $('#validate-email').val(),
                token: $('[name="token"]').val(),
            }, function (data, status) {
                if (data == 'success') {
                    $('#resmessage > .alert-info').css('display', 'block');
                    $('#myModal').modal('show');
                    $('#btnSendAgain').timedDisable(120);
                } else {
                    $('#myModal2').modal('show');
                }
            });
        } else {
            $('#myModal').modal('show');
        }
        tcli = 2;
    });
    $('#btnSendAgain').click(function () {
        $('#resmessage > .alert').css('display', 'none');
        $.post("index.php?m=emailverification&verify=email", {
            send_secode: "1",
            email: $('#validate-email').val(),
            token: $('[name="token"]').val(),
        }, function (data, status) {
            if (data == 'success') {
                $('#resmessage > .alert-info').css('display', 'block');
                $('#btnSendAgain').timedDisable(120);
            } else {
                $('#myModal2').modal('show');
            }
        });
    });
    $("#securticode").on('propertychange change click keyup input paste blur', function () {
        var secode = $("#securticode").val();
        if (secode.length != 6) {
            $("#loccat").attr("disabled", "disabled");
        } else {
            $("#loccat").removeAttr("disabled");
        }
    });
    $('#loccat').click(function () {
        $.post("index.php?m=emailverification&verify=email", {
            check_secode: "1",
            code: $('#securticode').val()
        }, function (data, status) {
            if (status == 'success') {
                if (data == 'verified') {
                    $('#resmessage > .alert').css('display', 'none');
                    $('#resmessage > .alert-success').css('display', 'block');
                    setTimeout(function () {
                        window.location.href = callbackurl;
                    }, 2000);   // Time in milliseconds                    
                } else {
                    $('#resmessage > .alert').css('display', 'none');
                    $('#resmessage > .alert-danger').css('display', 'block');
                }
            } else {
                $('#myModal').modal('hide');
                $('#myModal2').modal('show');
            }
        });
    });
});