var desired_bmi = 19.6;
$.fn.bmiCalculator = function () {
    var container_elm = $(this).closest('.bmi-calculator-container');
    var submit_btn_elm = container_elm.find('.submit');


    submit_btn_elm.click(function () {


        

        $('input:radio[name="gender"]').change(
            function(){
                if ($(this).is(':checked') && $(this).val() == 'male') {
                    desired_bmi = 22 
                } else {
                    desired_bmi = 19.6 
                }
        });    
        var weight = parseInt(container_elm.find(".weight").val());
        var height = parseInt(container_elm.find(".height").val());

        var bmi_number = bmi(weight, height);
        var desired_weight = desiredWeight(height);
        var weight_diff = weight - desired_weight;
        var absolute_weight_diff = Math.abs(weight_diff);
        var type = 'no_overweight'; // default (weight_diff == 0)
        if (weight_diff > 0) {
            var type = 'overweight';
        } else if (weight_diff < 0) {
            var type = 'underweight';
        }

        switch (type) {
            case 'no_overweight':
                $('.p-title-fit>span').text('وزن شما نرمال است');
                $('.p-resulte-value-fit>span').text(0);
                break;
            case 'overweight':
                $('.p-title-fit>span').text('میزان اضافه وزن شما');
                $('.p-resulte-value-fit>span').text(absolute_weight_diff);
                console.log("You are " + absolute_weight_diff + " kg overweight");
                break;
            case 'underweight':
                $('.p-title-fit>span').text('میزان کمبود وزن شما');
                $('.p-resulte-value-fit>span').text(absolute_weight_diff);
                console.log("You are " + absolute_weight_diff + " kg underweight");
                break;
        }
        // 
        $('.box-form-bmi').addClass('d-none');
        $('.box-form-bmi').removeClass('d-flex');
        // 
        $('.p-resulte-value-bmi>span').text(bmi_number);
        $('.p-resulte-value-desired>span').text(desired_weight);
        $('.p-resulte-value-weight>span').text(weight);
        $('.box-res-bmi').addClass('d-flex');
        $('.box-res-bmi').removeClass('d-none');
        
        
        console.log("Your BMI is: " + bmi_number);
        console.log("Your desired weight is: " + desired_weight);
    })
}

$(".re-test-bmi").click(function () {
    $('.box-res-bmi').addClass('d-none');
    $('.box-res-bmi').removeClass('d-flex');
    $('.box-form-bmi').addClass('d-flex');
    $('.box-form-bmi').removeClass('d-none');
    $('#male').removeAttr('checked');
    $('#male').removeAttr('checked','checked');
    $('#female').removeAttr('checked','checked');
    $('#female').removeAttr('checked');
});

function bmi(weight, height) {
    var height_in_meter = height / 100;
    return Math.round(weight / (Math.pow(height_in_meter, 2)));
}

function desiredWeight(height) {
    var height_in_meter = height / 100;
    return Math.round(desired_bmi * Math.pow(height_in_meter, 2));
}
