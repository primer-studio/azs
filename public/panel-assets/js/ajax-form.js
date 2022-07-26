var request_sent = [];
var input_class = "form-control";
var invalid_input_class = "is-invalid";
var invalid_feedback_class = "invalid-feedback";

$.fn.ajaxForm = function (is_update, confirm_message = '') {
    var form_id = $(this).attr('id');
    var submit_button = $(this).find('.submit-button');
    var submit_button_main_text = submit_button.html();

    submit_button.click(function () {
        if (requestAlreadySent(form_id)) {
            return false;
        }
        $(this).submit();
    })

    $(this).keypress(function (e) {
        if (e.which == 13) {
            $(this).submit();
        }
    });

    $(this).submit(function (e) {
        var form_elm = $(this);
        e.preventDefault();
        if (requestAlreadySent(form_id)) {
            return false;
        }


        if (confirm_message != '') {
            var confirmed = confirm(confirm_message);
            if (confirmed == false) {
                return false;
            }
        }
        resetErrors();
        startSending(submit_button, form_id);
        $.ajax({
            url: form_elm.attr('action'),
            dataType: 'JSON',
            type: is_update ? 'PUT' : 'POST',
            data: form_elm.serialize(),
            success: function (data, textStatus, jQxhr) {
                stopSending(submit_button, submit_button_main_text, form_id);
                if (data.hasOwnProperty('status')) {
                    if (data.status == 'success') {
                        if (data.redirect_to == '') {
                            addSuccessNotification(data.message);
                        } else if (data.redirect_to == 'reload') {
                            addInfoNotification(please_wait);
                            // reload page
                            location.reload();
                        } else {
                            addInfoNotification(please_wait);
                            redirect(data.redirect_to);
                        }
                    } else if (data.status == 'failed') {
                        addErrorNotification(there_was_a_problem);
                        if (data.hasOwnProperty('error_code')) {
                            if (data.error_code == 100) {
                                // if error is a single string
                                if (typeof data.errors == "string") {
                                    addErrorNotification(data.errors);
                                } else {
                                    var scroll_target_elm = null; // first input elm to scroll page to its position
                                    $.each(data.errors, function (input_returned_name, errors) {
                                        var input_name = input_returned_name;
                                        if (input_returned_name.indexOf(".") >= 0) {
                                            var parts_array = input_returned_name.split('.');
                                            var sub_parts = parts_array.slice(1);
                                            var name = parts_array.slice(0, 1);
                                            $.each(sub_parts, function (i, sub) {
                                                name = name + "[" + sub + "]";
                                            })
                                            input_name = name;
                                        }

                                        var input_elm = form_elm.find('[name="' + input_name + '"]');
                                        if (input_elm.length && input_elm.is(":visible")) {
                                            if (input_elm.hasClass(input_class)) {
                                                if (scroll_target_elm == null) {
                                                    scroll_target_elm = input_elm;
                                                }
                                                // show errors after the input
                                                input_elm.addClass(invalid_input_class);
                                                $.each(errors, function (i, error) {
                                                    input_elm.after('<div class="feedback invalid-feedback">' + error + '</div>')
                                                })
                                            } else {
                                                // show as individual error if element does not have form-control class
                                                addFieldErrors(errors)
                                            }
                                        } else {
                                            /// show as individual error if element does not found
                                            addFieldErrors(errors)
                                        }
                                    })
                                    if (scroll_target_elm !== null) {
                                        // scroll to first input element which has error
                                        scroll_target_elm.scrollTOElement();
                                    }
                                }
                            }
                        } else {
                            // TODO[front-end]: mange this: show unknown error
                            addErrorNotification(there_was_a_problem);
                            console.log('unknown error')
                        }
                    } else {
                        // TODO[front-end]: mange this: show unknown error
                        addErrorNotification(there_was_a_problem);
                        console.log('unknown error')
                    }
                } else {
                    // TODO[front-end]: mange this: show unknown error
                    addErrorNotification(there_was_a_problem);
                    console.log('unknown error')
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                stopSending(submit_button, submit_button_main_text, form_id);
                // TODO[front-end]: mange this: show unknown error
                addErrorNotification(there_was_a_problem);
                console.log('unknown error')
            }
        });
    })
}

function addFieldErrors(errors) {
    $.each(errors, function (i, error) {
        addErrorNotification(error);
    })
}

function resetErrors() {
    $("." + input_class).each(function (i, element) {
        $(element).removeClass(invalid_input_class);
    })
    $("." + invalid_feedback_class).each(function (i, element) {
        $(element).remove();
    })
    // Remove current toasts using animation
    resetNotifications();
}

function startSending(submit_button, form_id) {
    request_sent.push(form_id);
    // TODO: replace loading icon
    submit_button.html(please_wait);
    addProcessingNotification(please_wait);
}

function stopSending(submit_button, submit_button_main_text, form_id) {
    resetNotifications();
    removeFromRequestSent(form_id)
    submit_button.html(submit_button_main_text);
}

function requestAlreadySent(form_id) {
    return (jQuery.inArray(form_id, request_sent) !== -1);
}

function removeFromRequestSent(form_id) {
    request_sent = $(request_sent).not([form_id]).get();
}
