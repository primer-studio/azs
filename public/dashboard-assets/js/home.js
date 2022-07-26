var register_form_elm, set_verification_code_form_elm, login_form_elm, send_again_elm, send_again_counter_elm,
    progress_send_again,
    verification_code_requested = 0, timer, time_left;
document.addEventListener('DOMContentLoaded', function () {
    register_form_elm = $('.register-form');
    set_verification_code_form_elm = $('.set-verification-code');
    login_form_elm = $('.verification-code-login');
    send_again_elm = $('.send-again');
    send_again_elm.addClass('d-flex align-items-center w-100');

    send_again_counter_elm = $('.send-again-counter');

    // send_again_elm.append('<progress class="d-none progress-send-again" max="60" value="0"></progress>');
    progress_send_again = $('.progress-send-again');
    set_verification_code_form_elm.submit(function (e) {
        e.preventDefault();
        setVerificationCode($(this))
    });
    register_form_elm.submit(function (e) {
        e.preventDefault();
        setVerificationCode($(this))
    });

    $(".verification-code-login").submit(function (e) {
        e.preventDefault();
        addProcessingNotification(please_wait);
        $.ajax({
            url: $(this).attr('action'),
            dataType: 'JSON',
            type: 'POST',
            data: $(this).serialize(),
            success: function (data, textStatus, jQxhr) {
                resetNotifications();
                if (data.hasOwnProperty('status')) {
                    if (data.status == 'success') {
                        redirect(data.redirect_to);
                    } else if (data.status == 'failed') {
                        if (data.hasOwnProperty('error_code')) {
                            if (data.error_code == 100) {
                                // if error is a single string
                                if (typeof data.errors == "string") {
                                    addErrorNotification(data.errors);
                                } else {
                                    $.each(data.errors, function (input_returned_name, errors) {
                                        $.each(errors, function (i, error) {
                                            addErrorNotification(error);
                                        })
                                    })
                                }
                            }
                        } else {
                            addErrorNotification(there_was_a_problem);
                            console.log('unknown error')
                        }
                    } else {
                        addErrorNotification(there_was_a_problem);
                        console.log('unknown error')
                    }
                } else {
                    addErrorNotification(there_was_a_problem);
                    console.log('unknown error')
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                resetNotifications();
                addErrorNotification(there_was_a_problem);
                console.log('unknown error')
            }
        });
    });

    $('.show-set-verification-code').click(function () {
        set_verification_code_form_elm.removeClass('d-none');
        register_form_elm.addClass('d-none');
        login_form_elm.addClass('d-none');
    })

    $('.show-register-box').click(function () {
        set_verification_code_form_elm.addClass('d-none');
        login_form_elm.addClass('d-none');
        register_form_elm.removeClass('d-none');
    })

    send_again_elm.click(function () {
        if (time_left > 0) {
            return false;
        }
        set_verification_code_form_elm.submit();
    })
})

function showLoginBox(mobile_number) {
    register_form_elm.addClass('d-none');
    set_verification_code_form_elm.addClass('d-none');
    login_form_elm.find('.mobile_number').val(mobile_number);
    login_form_elm.removeClass('d-none');
}

function setVerificationCode(form_elm) {
    if (verification_code_requested) {
        return false;
    }
    startGettingVerificationCodeProcess(form_elm);
    $.ajax({
        url: form_elm.attr('action'),
        dataType: 'JSON',
        type: 'POST',
        data: form_elm.serialize(),
        success: function (data, textStatus, jQxhr) {
            stopGettingVerificationCodeProcess(form_elm);
            if (data.hasOwnProperty('status')) {
                if (data.status == 'success') {
                    addSuccessNotification(code_generated);
                    var mobile_number = form_elm.find('.mobile_number').val();
                    showLoginBox(mobile_number);
                } else if (data.status == 'failed') {
                    if (data.hasOwnProperty('error_code')) {
                        // if error is a single string
                        if (typeof data.errors == "string") {
                            addErrorNotification(data.errors);
                        } else {
                            $.each(data.errors, function (input_returned_name, errors) {
                                $.each(errors, function (i, error) {
                                    addErrorNotification(error);
                                })
                            })
                        }
                    } else {
                        addErrorNotification(there_was_a_problem);
                    }
                } else {
                    addErrorNotification(there_was_a_problem);
                }
            } else {
                addErrorNotification(there_was_a_problem);
            }
        },
        error: function (jqXhr, textStatus, errorThrown) {
            stopGettingVerificationCodeProcess(form_elm);
            addErrorNotification(there_was_a_problem);
            // TODO[front-end]: mange this: show unknown error
            console.log('unknown error')
        }
    });
}

function startGettingVerificationCodeProcess(form_elm) {
    verification_code_requested = 1;
    send_again_counter_elm.removeClass("d-none");
    progress_send_again.removeClass("d-none");
    send_again_counter_elm.addClass("d-flex");
    progress_send_again.addClass("d-flex");

    if (form_elm.hasClass('register-form')) {
        var mobile_number = form_elm.find('.mobile_number').val();
        set_verification_code_form_elm.find('.mobile_number').val(mobile_number);
    }

    send_again_elm.removeClass('d-none');
    var submit_button_title_elm = form_elm.find('.submit-button-title');
    submit_button_title_elm.html(sending);
    addInfoNotification(sending);
    clearInterval(timer);
    time_left = 59;
    progress_val = 0;
    timer = setInterval(function () {
        time_left--;
        progress_val++;
        var second = time_left < 10 ? "0" + time_left : time_left;
        send_again_counter_elm.text("00:" + second)
        progress_send_again.val(progress_val);
        if (time_left <= 0) {
            send_again_counter_elm.addClass("d-none");
            progress_send_again.addClass("d-none");
            send_again_elm.addClass('active');
            clearInterval(timer);
        }
    }, 1000);
}


function stopGettingVerificationCodeProcess(form_elm) {
    resetNotifications();
    verification_code_requested = 0;
    var submit_button_title_elm = form_elm.find('.submit-button-title');
    submit_button_title_elm.html(submit_button_title_elm.attr('data-title'));
}
