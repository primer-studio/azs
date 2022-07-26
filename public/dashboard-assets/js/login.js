document.addEventListener('DOMContentLoaded', function () {
    let time_left, progress_val, timer, send_again_counter_and_progress_container_elm, send_again_btn_elm
        , set_verification_code_form_elm;
    set_verification_code_form_elm = $('#set-verification-code');
    send_again_btn_elm = $('.send-again-btn');
    let send_again_elm = $('.send-again');
    send_again_counter_and_progress_container_elm = $('.send-again-counter-and-progress-container');
    send_again_elm.addClass('d-flex align-items-center w-100');

    let send_again_counter_elm = $('.send-again-counter');

    // send_again_elm.append('<progress class="d-none progress-send-again" max="60" value="0"></progress>');
    let progress_send_again = $('.progress-send-again');

    send_again_elm.removeClass('d-none');

    time_left = 59;
    progress_val = 0;
    timer = setInterval(function () {
        time_left--;
        progress_val++;
        let second = time_left < 10 ? "0" + time_left : time_left;
        send_again_counter_elm.text("00:" + second)
        progress_send_again.val(progress_val);
        if (time_left <= 0) {
            send_again_counter_and_progress_container_elm.removeClass('d-flex').addClass("d-none");
            send_again_elm.addClass('active');
            clearInterval(timer);
        }
    }, 1000);

    // click on send-again-btn, check if time_left is 0, then submit the hidden form (#set-verification-code)
    send_again_btn_elm.click(function () {
        if (time_left) {
            // timer must be 0
            return false;
        }
        set_verification_code_form_elm.submit();
    })
})
