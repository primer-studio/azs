function createMassage(massage, status) {
    let count = $('body').find('.massage-full').length;
    let height = $(window).height() / 55;
    if (count != 0) {
        height = $(window).height() / ($(`.massage-full${count - 1}`).height() + 24);
        console.log($(`.massage-full`).height());
    }
    let top = count * (Math.floor(100 / Math.floor(height))) + 3;
    if (top > 75) {
        $('body').find('.massage-full').remove();
        top = 3;
    }
    let el = `<div class="pos-fixed d-flex align-items-center massage-full massage-full${count} ${status} px-2 py-3">
            <p> ${massage} </p>
            <span class="close close-massage-full cursor-pointer" aria-hidden="true">×</span>
        </div>`;


    $(el).appendTo('body')
        .delay(8000).queue(function () { $(this).remove(); });

    console.log(($(`.massage-full${count - 1}`).height() + 24));
    $(`.massage-full${count}`).css({
        'cssText': `top: ${top}%;`,
    });
}
function clearNotifications() {
    $(".massage-full").each(function () {
        $(this).remove();
    })
}

var sb = {
    song: null,
    init: function () {
      sb.song = new Audio();
      sb.listeners();
    },
    listeners: function () {
      $("button").click(sb.play);
    },
    play: function (e) {
      sb.song.src = e.target.value;
      sb.song.play();
    }
};
  

$("document").ready(function () {

    $(".link_change_users_style").click(function () {
        $("html, body").animate({
            scrollTop: $('#change_users_style').offset().top
        }, 1000);
    });
    $(".link_support_free").click(function () {
        $("html, body").animate({
            scrollTop: $('#support_free').offset().top
        }, 1000);
    });

    $(".goto-video").click(function () {
        $("html, body").animate({
            scrollTop: $('iframe').offset().top - 85
        }, 1000);
    });

    $(".goto-reg-btn").click(function () {
        $("html, body").animate({
            scrollTop: $('#SignInBox').offset().top - 85
        }, 1000);
    });
    sb.init;
    // Fixed Register Button on scroll
    $(window).scroll(function() {
        var height = $(window).scrollTop();
    if(height > 500) {
            $('.fixed-reg-btn').css("display","flex");
            $('.fixed-reg-btn a').slideDown();
        } else {
            $('.fixed-reg-btn a').slideUp();
            $('.fixed-reg-btn').css("display","none");
        }
    });



    $(".q-a-box>div").each(function(e) {
        if (e != 0)
            $(this).hide();
    });

    $("#next").click(function(){
        if ($(".q-a-box>div:visible").next().length != 0)
            $(".q-a-box>div:visible").next().show().prev().hide();
        else {
            $(".q-a-box>div:visible").hide();
            $(".q-a-box>div:first").show();
        }
        return false;
    });

    $("#prev").click(function(){
        if ($(".q-a-box>div:visible").prev().length != 0)
            $(".q-a-box>div:visible").prev().show().next().hide();
        else {
            $(".q-a-box>div:visible").hide();
            $(".q-a-box>div:last").show();
        }
        return false;
    });


    $(document).on('click', '.q-a-box .item', function () {
        $('.q-a-box .item').removeClass('active');
        $(this).addClass('active');
    });

    $(document).on('click', '.close-massage-full', function () {
        $(this).parent().remove();
    });


    $('.swiper-wrapper audio').on('playing', function() {
        let cls = $(this).attr('data-class');
        var y = ['aud1', 'aud2', 'aud3', 'aud4', 'aud5']
        var removeItem = cls;
        y = jQuery.grep(y, function(value) {
            return value != removeItem;
        });     
        y.forEach(function (item, index) {
            $('.'+item).get(0).pause()
            console.log(item, index);
        });
    });
    
    // $('.swiper-wrapper audio').on('playing', function() {
    //     let cls = $(this).attr('data-class');
    //     $('.swiper-wrapper audio').each(function(){
    //         $(this).get(0).pause();
    //     });
    //     console.log('.'+cls);
    //     $('.'+cls).get(0).play();
    // });

    $(document).on('click', '.select-diet-dashbord>.select-items>div', function () {
        let val = $(this).parent().find('.same-as-selected').text();
        $(this).parent().parent().find(".azshanbeInput option").removeAttr('selected', 'selected');
        $(this).parent().parent().find(".azshanbeInput option[data-value='"+val+"']").attr('selected', 'selected');
        // alert(val);
    });

    $(".mm-menu-btn").click(function () {
        $('body').toggleClass('overflow-y');
        $('.mm-menu').toggleClass('active');
        $('.main-container').toggleClass('active');
    });

    $(".closebtn-mm ,.mm-menu>.popUpClose ,.close-btn-mm-menu").click(function () {
        $('body').toggleClass('overflow-y');
        $('.mm-menu').toggleClass('active');
        $('.main-container').toggleClass('active');
    });

    $(".login-btn").click(function () {
        $('.sub-title-auth-home').addClass( "login");
        $('.sub-title-auth-home').removeClass( "signin");
        $('.signin-btn-home').addClass("login-btn-home");
        $('.login-btn').removeClass("login-btn-home");
    });

    $(".signin-btn-home").click(function () {
        $('.sub-title-auth-home').addClass( "signin");
        $('.sub-title-auth-home').removeClass( "login");
        $('.signin-btn-home').removeClass("login-btn-home");
        $('.login-btn').addClass("login-btn-home");
    });

    // $(".rightNavigationMenu").click(function () {
    //     $(".topMenu ul").fadeToggle();
    //     $(".rightNavigationMenu span").toggleClass("icon-Menu, icon-close");
    // });

    $(".open-modal").click(function () {
        let target = $(this).attr('data-target');
        $(target).toggleClass('active');
        $('body').css('overflow-y', 'hidden');
    });

    $(".btn-pay-offline").click(function () {
        $('#register-offline-payment').removeClass('d-none');
        $('#register-offline-payment').addClass('d-flex');
    });

    

    $(".close-modal").click(function () {
        let target = $(this).attr('data-target');
        $(target).removeClass('active');
        $('body').css('overflow-y', 'inherit');
    });

    $(".valid-feedback").click(function () {
        $('.valid-feedback').removeClass('valid-feedback');
    });


    if ($('select.azshanbeInput').hasClass('input-valid')) {
        $('select.azshanbeInput').parent().addClass('input-valid');
    } else if ($('select.azshanbeInput').hasClass('input-invalid')) {
        $('select.azshanbeInput').parent().addClass('input-invalid');
    }


    $('.tab-title>li').click(function () {
        if ($(window).width() <= 1023) {
            $('.panel-menu').removeClass('active');
            $('body').css('overflow-y', 'inherit');
        }
        if ($(this).attr('data-tab')) {
            $('.tab-title>li').removeClass('active');
            $(this).addClass('active');
            $('.tabc>div').addClass('tempDisable');
            let className = '.' + $(this).attr('data-tab');
            $(className).removeClass("tempDisable");
        }
    });
    $('.tabHeader>div').click(function () {
        if ($(this).attr('data-tab-c')) {
            $('.tabHeader>div').removeClass('active');
            $(this).addClass('active');
            $('.tabc>div').addClass('tempDisable');
            let className = '.' + $(this).attr('data-tab-c');
            $(className).removeClass("tempDisable");
        }
    });

    $('.close-notif').click(function () {
        $(this).parent().parent().remove();
    });


    var vid = $('.videoBanner').RTOP_VideoPlayer({
        showFullScreen: true,
        showTimer: true,
        showSoundControl: true
    });
    

    /* Circle progress */
    let color = $('.breakfast-1').attr('data-color');
    let progressBarOptions = {
        startAngle: -1.55,
        size: 50,
        value: 0.25,
        fill: {
            color: color
        }
    }


    $('.breakfast-1').circleProgress({
        startAngle: -1.55,
        size: 50,
        value: 0.25,
        fill: {
            color: color
        }
    });

    let color2 = $('.breakfast-2').attr('data-color');

    $('.breakfast-2').circleProgress({
        startAngle: -1.55,
        size: 50,
        value: 0.65,
        fill: {
            color: color2
        }
    });

    let color3 = $('.breakfast-3').attr('data-color');
    $('.breakfast-3').circleProgress({
        startAngle: -1.55,
        size: 50,
        value: 0.95,
        fill: {
            color: color3
        }
    });

    let color4 = $('.breakfast-4').attr('data-color');
    $('.breakfast-4').circleProgress({
        startAngle: -1.55,
        size: 50,
        value: 0.85,
        fill: {
            color: color4
        }
    });

    let color5 = $('.breakfast-5').attr('data-color');
    $('.breakfast-5').circleProgress({
        startAngle: -1.55,
        size: 50,
        value: 0.35,
        fill: {
            color: color5
        }
    });

    let color6 = $('.breakfast-6').attr('data-color');
    $('.breakfast-6').circleProgress({
        startAngle: -1.55,
        size: 50,
        value: 0.55,
        fill: {
            color: color6
        }
    });

    let color7 = $('.breakfast-7').attr('data-color');
    $('.breakfast-7').circleProgress({
        startAngle: -1.55,
        size: 50,
        value: 0.18,
        fill: {
            color: color7
        }
    });




    /* Circle Progress */

    $('.week-slieder>li').click(function () {
        if ($(this).attr('data-tab-b')) {
            $('.week-slieder>li').removeClass('active');
            $(this).addClass('active');
            $('.tabc-week>div').addClass('tempDisable');
            let className = '.' + $(this).attr('data-tab-b');
            $(className).removeClass("tempDisable");
        }
    });

    // $('.invalid-feedback').parent().find('input').addClass('invalid');

    // $('.valid-feedback').parent().find('input').removeClass('invalid');

    // function massageBox (type, massage, parrent) {
    //     $('.box-input').append( '<div class="feedback"></div>' );
    //     if (type == 'valid') {
    //         $('.feedback').addClass('valid-feedback').text(massage).delay(2000).queue(function(next){
    //             $(this).removeClass('valid-feedback');
    //             next();
    //         });
    //     } else if ( type == 'invalid' ) {
    //         $('.feedback').addClass('invalid-feedback').text(massage).delay(2000).queue(function(next){
    //             $(this).removeClass('invalid-feedback');
    //             next();
    //         });
    //     }
    // }

    // massageBox('invalid','redbear')


    var swiper = new Swiper('.swiper-companions', {
        slidesPerView: 3,
        spaceBetween: 25,
        slidesPerGroup: 3,
        loop: true,
        loopFillGroupWithBlank: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.companions-button-prev.companions',
            prevEl: '.companions-button-next.companions',
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 20,
                slidesPerGroup: 1,
            },
            440: {
                slidesPerView: 1,
                spaceBetween: 20,
                slidesPerGroup: 1,
            },
            540: {
                slidesPerView: 1,
                spaceBetween: 20,
                slidesPerGroup: 1,
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 10,
                slidesPerGroup: 2,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10,
                slidesPerGroup: 2,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 25,
                slidesPerGroup: 3,
            },
        }
    });


    var swiper2 = new Swiper('.swiper-audio', {
        slidesPerView: 4,
        spaceBetween: 25,
        slidesPerGroup: 4,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.companions-button-prev.audio',
            prevEl: '.companions-button-next.audio',
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 20,
                slidesPerGroup: 1,
            },
            440: {
                slidesPerView: 1,
                spaceBetween: 20,
                slidesPerGroup: 1,
            },
            540: {
                slidesPerView: 1,
                spaceBetween: 20,
                slidesPerGroup: 1,
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 10,
                slidesPerGroup: 2,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10,
                slidesPerGroup: 2,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 25,
                slidesPerGroup: 4,
            },
        }
    });
});


/* Custom Select */
var x, i, j, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
for (i = 0; i <= x.length; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    /*for each element, create a new DIV that will act as the selected item:*/
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    if (selElmnt.classList['0'] == 'input-valid') {
        // x[i].setAttribute("class", "input-valid");
        // a.setAttribute("class", "input-valid");
    } else if (selElmnt.classList['0'] == 'input-invalid') {
        // x[i].setAttribute("class", "input-invalid");
        // a.setAttribute("class", "input-invalid");
    }
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    // OPT2.setAttribute('selected', 'selected');
    x[i].appendChild(a);
    /*for each element, create a new DIV that will contain the option list:*/
    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    for (j = 0; j < selElmnt.length; j++) {
        /*for each option in the original select element,
        create a new DIV that will act as an option item:*/
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function (e) {
            /*when an item is clicked, update the original select box,
            and the selected item:*/
            var y, i, k, s, h;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            h = this.parentNode.previousSibling;
            for (i = 0; i < s.length; i++) {
                if (s.options[i].innerHTML == this.innerHTML) {
                    s.selectedIndex = i;
                    h.innerHTML = this.innerHTML;
                    y = this.parentNode.getElementsByClassName("same-as-selected");
                    for (k = 0; k < y.length; k++) {
                        y[k].removeAttribute("class");
                    }
                    this.setAttribute("class", "same-as-selected");
                    break;
                }
            }
            h.click();
        });
        b.appendChild(c);
    }
    x[i].appendChild(b);
    a.addEventListener("click", function (e) {
        /*when the select box is clicked, close any other select boxes,
        and open/close the current select box:*/
        e.stopPropagation();
        closeAllSelect(this);
        this.nextSibling.classList.toggle("select-hide");
        this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
    /*a function that will close all select boxes in the document,
    except the current select box:*/
    var x, y, i, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    for (i = 0; i < y.length; i++) {
        if (elmnt == y[i]) {
            arrNo.push(i)
        } else {
            y[i].classList.remove("select-arrow-active");
        }
    }
    for (i = 0; i < x.length; i++) {
        if (arrNo.indexOf(i)) {
            x[i].classList.add("select-hide");
        }
    }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);
/* Custom Select */
