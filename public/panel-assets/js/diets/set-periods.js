var periods_container_elm, add_period_elm, old_periods_elm, old_periods, periods_number = 0;

document.addEventListener("DOMContentLoaded", function () {
    add_period_elm = $(".add-period");
    periods_container_elm = $(".periods-container");
    old_periods_elm = $(".old-periods");

    generateOldPeriods();
    add_period_elm.click(function () {
        addPeriod();
    })

    function generateOldPeriods() {
        if (old_periods_elm.val()) {
            old_periods = JSON.parse(old_periods_elm.val());
            $.each(old_periods, function (i, period) {
                addPeriod(period.period, period.price, period.duration_in_day, period.status)
            });
        }
    }

    function addPeriod(period = 0, price = '', duration_in_day = '', status = 'active') {
        if (!period) {
            period = parseInt(periods_number) + 1;
        }
        periods_number = period;

        var name_prefix = "periods[" + period + "]";
        var period_elm = $(".period-template").clone().removeClass('period-template d-none').addClass('period');
        period_elm.find('.number').html(period);
        period_elm.find('.period_number').attr('name', name_prefix + "[period]").val(period);
        period_elm.find('.duration_in_day').attr('name', name_prefix + "[duration_in_day]").val(duration_in_day);
        period_elm.find('.price').attr('name', name_prefix + "[price]").val(price);
        period_elm.find('.status').attr('name', name_prefix + "[status]").val(status);
        periods_container_elm.append(period_elm);
    }

})
