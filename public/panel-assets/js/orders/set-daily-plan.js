var search_default_icon = '<i class="la la-search"></i>';
var searching_icon = '<i class="fas fa-circle-notch fa-spin"></i>';
var diet;
document.addEventListener('DOMContentLoaded', function () {
    diet = JSON.parse(diet_encoded);

    // add foods
    $.each(diet.foods, function (day, meals) {
        $.each(meals, function (meal_name, foods) {
            var meal = $('.meal.meal-' + day + '.' + meal_name);
            $.each(foods, function (i, daily_food_food) {
                addSelectedFood(meal, daily_food_food.food, daily_food_food.id, daily_food_food.amount_in_unit, daily_food_food.total_calories, daily_food_food.before_food_comment, daily_food_food.after_food_comment);
            })
            // add section to inputs names based on html sort
            resortMeal(meal);
        })
    })

    // add sports
    $.each(diet.sports, function (day_number, daily_sport_plans) {
        var day = $('.day.day-' + day_number);
        $.each(daily_sport_plans, function (i, daily_sport_plan) {
            addSelectedSport(day, daily_sport_plan.sport, daily_sport_plan.id, daily_sport_plan.amount_in_unit, daily_sport_plan.total_calories, daily_sport_plan.before_sport_comment, daily_sport_plan.after_sport_comment);
        })
        // add section to inputs names based on html sort
        resortSport(day);
    })

    // add recommendations
    $.each(diet.recommendations, function (day_number, daily_recommendation_plans) {
        var day = $('.day.day-' + day_number);
        $.each(daily_recommendation_plans, function (i, daily_recommendation_plan) {
            addSelectedRecommendation(day, daily_recommendation_plan.recommendation, daily_recommendation_plan.id, daily_recommendation_plan.before_recommendation_comment, daily_recommendation_plan.after_recommendation_comment);
        })
        // add section to inputs names based on html sort
        resortRecommendation(day);
    })

    $('.search-input').keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

    $('.search-input').keyup(function (event) {
        // expect up, down, enter, tab
        var search_main_elm = $(this).closest('.search-main');
        var type = $(this).attr("data-type");
        var search_result_container_elm = search_main_elm.find('.search-result-container');
        if (event.keyCode == 38 || event.keyCode == 40 || event.keyCode == 13 || event.keyCode == 9) {
            var current_selected = search_main_elm.find(".selected.search-result");
            if (event.keyCode == 38) {
                // up
                if (current_selected.length) {
                    var perv = current_selected.prev('.search-result');
                    if (perv.length) {
                        // Scroll to the top
                        search_result_container_elm.scrollTop(perv.position().top);
                        current_selected.removeClass('selected');
                        perv.addClass('selected');
                    }
                }
                return false;
            } else if (event.keyCode == 40) {
                // down
                if (current_selected.length) {
                    var next = current_selected.next('.search-result');
                    if (next.length) {
                        // Scroll to the top
                        search_result_container_elm.scrollTop(next.position().top);
                        current_selected.removeClass('selected');
                        next.addClass('selected');
                    }
                } else {
                    search_main_elm.find(".search-result").first().addClass('selected');
                }
                return false;
            } else if (event.keyCode == 13) {
                // enter
                var current_selected = search_main_elm.find(".selected.search-result");
                if (current_selected.length) {
                    if (type == 'food') {
                        var food_data = JSON.parse(current_selected.attr('data-item-data'));
                        var meal = search_main_elm.closest('.meal');
                        addSelectedFood(meal, food_data);
                        // add section to inputs names based on html sort
                        resortMeal(meal);
                    } else if (type == 'sport') {
                        var sport_data = JSON.parse(current_selected.attr('data-item-data'));
                        var day = search_main_elm.closest('.day');
                        addSelectedSport(day, sport_data);
                        // add section to inputs names based on html sort
                        resortSport(day);
                    } else if (type == 'recommendation') {
                        var recommendation_data = JSON.parse(current_selected.attr('data-item-data'));
                        var day = search_main_elm.closest('.day');
                        addSelectedRecommendation(day, recommendation_data);
                        // add section to inputs names based on html sort
                        resortRecommendation(day);
                    }
                }
                event.preventDefault();
                return false;
            } else if (event.keyCode == 9) {
                // tab
                search_main_elm.find('.search-input').val('');
                resetSearchResult($(this));
            }
        }

        search($(this));
    })

    $(document).on('click', function (e) {
        if ($(e.target).closest('.search-main').length === 0) {
            $('.search-main').each(function () {
                resetSearchResult($(this));
            })
        }
    });

    // select food by click
    $(document).on('click', '.food-search-result', function () {
        var meal_elm = $(this).closest('.meal');
        var food_data = JSON.parse($(this).attr('data-item-data'));
        addSelectedFood(meal_elm, food_data);
        // add section to inputs names based on html sort
        resortMeal(meal_elm);
    });

    // select sport by click
    $(document).on('click', '.sport-search-result', function () {
        var sport_data = JSON.parse($(this).attr('data-item-data'));
        var day = $(this).closest('.day');
        addSelectedSport(day, sport_data);
        // add section to inputs names based on html sort
        resortSport(day);
    });

    // select recommendation by click
    $(document).on('click', '.recommendation-search-result', function () {
        var recommendation_data = JSON.parse($(this).attr('data-item-data'));
        var day = $(this).closest('.day');
        addSelectedRecommendation(day, recommendation_data);
        // add section to inputs names based on html sort
        resortRecommendation(day);
    });

    // remove daily_food_plan_id
    $(document).on('click', '.remove-food', function () {
        // if $(this) has daily_food_plan_id attr, we should put it in removed_daily_food_plans
        if ($(this).hasAttr('daily_food_plan_id')) {
            addToRemovedDailyFoodPlans($(this).attr('daily_food_plan_id'));
        }
    })

    // remove daily_sport_plan_id
    $(document).on('click', '.remove-sport', function () {
        // if $(this) has daily_sport_plan_id attr, we should put it in removed_daily_sport_plans
        if ($(this).hasAttr('daily_sport_plan_id')) {
            addToRemovedDailySportPlans($(this).attr('daily_sport_plan_id'));
        }
    })

    // remove daily_recommendation_plan_id
    $(document).on('click', '.remove-recommendation', function () {
        // if $(this) has daily_recommendation_plan_id attr, we should put it in removed_daily_recommendation_plans
        if ($(this).hasAttr('daily_recommendation_plan_id')) {
            addToRemovedDailyRecommendationPlans($(this).attr('daily_recommendation_plan_id'));
        }
    })

    // day-shortcut
    $(document).on('click', '.day-shortcut', function () {
        // scroll to the day
        if ($(this).hasAttr('data-day')) {
            var day = $(this).attr('data-day');
            $('.day-' + day).scrollTOElement();
        }
    })

    // change total_calories by changing amount_in_unit
    $(document).on('change', '.amount_in_unit', function () {
        var amount_in_unit = parseFloat($(this).val());
        var has_calorie_item_elm = $(this).closest('.has-calorie-item'); // .food or .sport
        var calories_per_unit = parseInt(has_calorie_item_elm.find('.calories_per_unit').val());
        var total_calories = amount_in_unit * calories_per_unit;
        has_calorie_item_elm.find('.total_calories').val(total_calories);
    })
})

function search(search_elm) {
    var type = search_elm.attr("data-type");
    var title = search_elm.val();
    var search_main_elm = search_elm.closest(".search-main");
    var search_result_list_elm = search_main_elm.find(".search-result-list");
    var search_result_container_elm = search_main_elm.find('.search-result-container');
    search_result_container_elm.outerWidth(search_elm.outerWidth(), true);

    // reset old results
    search_result_list_elm.html('');
    if (title == '') {
        return false;
    }
    if (title.length < 2) {
        return false;
    }

    startSearching(search_main_elm);
    $.ajax({
        url: search_url, // search_food_url is set by script_variables stack
        dataType: 'JSON',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            title: title,
            type: type,
        },
        success: function (data, textStatus, jQxhr) {
            stopSearching(search_main_elm);
            if (data.hasOwnProperty('status')) {
                if (data.status == 'success') {
                    if (jQuery.isEmptyObject(data.data)) {
                        var not_found_elm = $(".not-found-template").clone().removeClass('not-found-template d-none').addClass('food-not-found');
                        search_result_list_elm.html(filterXSS(not_found_elm));
                        search_result_container_elm.addClass('d-none');
                    } else {
                        $.each(data.data, function (i, item) {

                            if (type == 'food') {
                                var search_result_elm = foodPrepareSearchResultItem(item);
                            } else if (type == 'sport') {
                                var search_result_elm = sportPrepareSearchResultItem(item);
                            } else if (type == 'recommendation') {
                                var search_result_elm = recommendationPrepareSearchResultItem(item);
                            }
                            search_result_elm.addClass('search-result');
                            search_result_elm.attr('data-item-data', JSON.stringify(item));
                            search_result_elm.attr('data-type', type);
                            search_result_elm.find('.title').html(filterXSS(item.title))
                            search_result_list_elm.append(search_result_elm);
                        })
                        search_result_container_elm.removeClass('d-none');
                    }
                } else if (data.status == 'failed') {
                    // TODO[front-end]: mange this: show unknown error
                    console.log('failed error')
                } else {
                    // TODO[front-end]: mange this: show unknown error
                    console.log('unknown error')
                }
            } else {
                // TODO[front-end]: mange this: show unknown error
                console.log('unknown error')
            }
        },
        error: function (jqXhr, textStatus, errorThrown) {
            stopSearching(search_main_elm);
            // // TODO[front-end]: mange this: show unknown error
            console.log('unknown error')
        }
    });
}

function foodPrepareSearchResultItem(item) {
    var search_result_elm = $(".food-search-result-template").clone().removeClass('food-search-result-template d-none').addClass('food-search-result');
    if (item.unit == null) {
        search_result_elm.find('.unit').remove();
    } else {
        search_result_elm.find('.unit').html(filterXSS(item.unit))
    }
    search_result_elm.find('.calories_per_unit').html(filterXSS(item.calories_per_unit));
    return search_result_elm;
}

function sportPrepareSearchResultItem(item) {
    var search_result_elm = $(".sport-search-result-template").clone().removeClass('sport-search-result-template d-none').addClass('sport-search-result');
    if (item.unit == null) {
        search_result_elm.find('.unit').remove();
    } else {
        search_result_elm.find('.unit').html(filterXSS(item.unit))
    }
    search_result_elm.find('.calories_per_unit').html(filterXSS(item.calories_per_unit));
    return search_result_elm;
}

function recommendationPrepareSearchResultItem(item) {
    var search_result_elm = $(".recommendation-search-result-template").clone().removeClass('recommendation-search-result-template d-none').addClass('recommendation-search-result');
    return search_result_elm;
}

function startSearching(parent) {
    var search_icon_elm = parent.find(".search-icon");
    search_icon_elm.html(searching_icon);
}

function stopSearching(parent) {
    var search_icon_elm = parent.find(".search-icon");
    search_icon_elm.html(search_default_icon);
}

function resetSearchResult(parent) {
    var search_result_list_elm = parent.find('.search-result-list');
    search_result_list_elm.empty()
    parent.find('.search-result-container').addClass('d-none');
}

function addSelectedFood(meal, food_default_data, daily_food_plan_id = null, amount_in_unit = 1, total_calories = null, before_food_comment = null, after_food_comment = null) {
    var food = $('.food-template').clone().removeClass('food-template d-none').addClass('food');
    food.find('.food_id').val(food_default_data.id);
    food.find('.amount_in_unit').val(parseFloat(amount_in_unit));
    if (daily_food_plan_id != null) {
        food.find('.daily_food_plan_id').val(daily_food_plan_id);
        food.find('.remove-food').attr('daily_food_plan_id', daily_food_plan_id);
    }
    if (before_food_comment != null) {
        food.find('.before_food_comment').val(before_food_comment);
    }
    if (after_food_comment != null) {
        food.find('.after_food_comment').val(after_food_comment);
    }
    if (total_calories == null) {
        total_calories = food_default_data.calories_per_unit;
    }

    food.find('.calories_per_unit ').val(food_default_data.calories_per_unit);
    food.find('.total_calories ').val(total_calories);
    food.find('.title').html(filterXSS(food_default_data.title));
    food.find('.unit').html(filterXSS(food_default_data.unit));
    var foods_list_elm = meal.find('.foods-list');
    foods_list_elm.append(food);
    // make foods_list_elm sortable and resort after each change
    foods_list_elm.sortable({
        update: function (event, ui) {
            resortMeal(meal);
            // var selected_questions_order = $(this).sortable('toArray', {attribute: 'data-question-id'});
        }
    });
}

function addSelectedSport(day, sport_default_data, daily_sport_plan_id = null, amount_in_unit = 1, total_calories = null, before_sport_comment = null, after_sport_comment = null) {
    var sport = $('.sport-template').clone().removeClass('sport-template d-none').addClass('sport');
    sport.find('.sport_id').val(sport_default_data.id);
    sport.find('.amount_in_unit').val(parseFloat(amount_in_unit));
    if (daily_sport_plan_id != null) {
        sport.find('.daily_sport_plan_id').val(daily_sport_plan_id);
        sport.find('.remove-sport').attr('daily_sport_plan_id', daily_sport_plan_id);
    }
    if (before_sport_comment != null) {
        sport.find('.before_sport_comment').val(before_sport_comment);
    }
    if (after_sport_comment != null) {
        sport.find('.after_sport_comment').val(after_sport_comment);
    }

    if (total_calories == null) {
        total_calories = sport_default_data.calories_per_unit;
    }
    sport.find('.calories_per_unit ').val(sport_default_data.calories_per_unit);
    sport.find('.total_calories ').val(total_calories);
    sport.find('.title').html(filterXSS(sport_default_data.title));
    sport.find('.unit').html(filterXSS(sport_default_data.unit));
    var sports_list_elm = day.find('.sports-list');
    sports_list_elm.append(sport);
    // make sports_list_elm sortable and resort after each change
    sports_list_elm.sortable({
        update: function (event, ui) {
            resortSport(day);
            // var selected_questions_order = $(this).sortable('toArray', {attribute: 'data-question-id'});
        }
    });
}

function addSelectedRecommendation(day, recommendation_default_data, daily_recommendation_plan_id = null, before_recommendation_comment = null, after_recommendation_comment = null) {
    var recommendation = $('.recommendation-template').clone().removeClass('recommendation-template d-none').addClass('recommendation');
    recommendation.find('.recommendation_id').val(recommendation_default_data.id);
    if (daily_recommendation_plan_id != null) {
        recommendation.find('.daily_recommendation_plan_id').val(daily_recommendation_plan_id);
        recommendation.find('.remove-recommendation').attr('daily_recommendation_plan_id', daily_recommendation_plan_id);
    }
    if (before_recommendation_comment != null) {
        recommendation.find('.before_recommendation_comment').val(before_recommendation_comment);
    }
    if (after_recommendation_comment != null) {
        recommendation.find('.after_recommendation_comment').val(after_recommendation_comment);
    }

    recommendation.find('.title').html(filterXSS(recommendation_default_data.title));
    var recommendations_list_elm = day.find('.recommendations-list');
    recommendations_list_elm.append(recommendation);
    // make recommendations_list_elm sortable and resort after each change
    recommendations_list_elm.sortable({
        update: function (event, ui) {
            resortRecommendation(day);
            // var selected_questions_order = $(this).sortable('toArray', {attribute: 'data-question-id'});
        }
    });
}

/**
 * resort the foods in meal
 * @param meal
 */
function resortMeal(meal) {
    var day = meal.attr('data-day');
    var meal_name = meal.attr('data-meal');
    meal.find('.food').each(function (i, food) {
        food = $(food);
        var name_prefix = "foods[days][" + day + "][" + meal_name + "][" + i + "]";
        food.find('.daily_food_plan_id').attr('name', name_prefix + "[id]");
        food.find('.food_id').attr('name', name_prefix + "[food_id]");
        food.find('.before_food_comment').attr('name', name_prefix + "[before_food_comment]");
        food.find('.amount_in_unit').attr('name', name_prefix + "[amount_in_unit]");
        food.find('.after_food_comment').attr('name', name_prefix + "[after_food_comment]");
        food.find('.total_calories ').attr('name', name_prefix + "[total_calories]");
    })
}

/**
 * resort the sports in day
 * @param meal
 */
function resortSport(day) {
    var day_number = day.attr("data-day");
    day.find('.sport').each(function (i, sport) {
        sport = $(sport);
        var name_prefix = "sports[days][" + day_number + "][" + i + "]";
        sport.find('.daily_sport_plan_id').attr('name', name_prefix + "[id]");
        sport.find('.sport_id').attr('name', name_prefix + "[sport_id]");
        sport.find('.before_sport_comment').attr('name', name_prefix + "[before_sport_comment]");
        sport.find('.amount_in_unit').attr('name', name_prefix + "[amount_in_unit]");
        sport.find('.after_sport_comment').attr('name', name_prefix + "[after_sport_comment]");
        sport.find('.total_calories ').attr('name', name_prefix + "[total_calories]");
    })
}

/**
 * resort the recommendations in day
 * @param meal
 */
function resortRecommendation(day) {
    var day_number = day.attr("data-day");
    day.find('.recommendation').each(function (i, recommendation) {
        recommendation = $(recommendation);
        var name_prefix = "recommendations[days][" + day_number + "][" + i + "]";
        recommendation.find('.daily_recommendation_plan_id').attr('name', name_prefix + "[id]");
        recommendation.find('.recommendation_id').attr('name', name_prefix + "[recommendation_id]");
        recommendation.find('.before_recommendation_comment').attr('name', name_prefix + "[before_recommendation_comment]");
        recommendation.find('.amount_in_unit').attr('name', name_prefix + "[amount_in_unit]");
        recommendation.find('.after_recommendation_comment').attr('name', name_prefix + "[after_recommendation_comment]");
        recommendation.find('.total_calories ').attr('name', name_prefix + "[total_calories]");
    })
}

function addToRemovedDailyFoodPlans(daily_food_plan_id) {
    var prev_ids = [];
    var removed_daily_food_plans_elm = $(".removed_daily_food_plans");
    var prev_ids_encoded = removed_daily_food_plans_elm.val();
    if (prev_ids_encoded != '') {
        $.each(JSON.parse(prev_ids_encoded), function (i, id) {
            prev_ids.push(id);
        })
    }
    // add the new one
    prev_ids.push(daily_food_plan_id);
    removed_daily_food_plans_elm.val(JSON.stringify(prev_ids));
}

function addToRemovedDailySportPlans(daily_sport_plan_id) {
    var prev_ids = [];
    var removed_daily_sport_plans_elm = $(".removed_daily_sport_plans");
    var prev_ids_encoded = removed_daily_sport_plans_elm.val();
    if (prev_ids_encoded != '') {
        $.each(JSON.parse(prev_ids_encoded), function (i, id) {
            prev_ids.push(id);
        })
    }
    // add the new one
    prev_ids.push(daily_sport_plan_id);
    removed_daily_sport_plans_elm.val(JSON.stringify(prev_ids));
}

function addToRemovedDailyRecommendationPlans(daily_recommendation_plan_id) {
    var prev_ids = [];
    var removed_daily_recommendation_plans_elm = $(".removed_daily_recommendation_plans");
    var prev_ids_encoded = removed_daily_recommendation_plans_elm.val();
    if (prev_ids_encoded != '') {
        $.each(JSON.parse(prev_ids_encoded), function (i, id) {
            prev_ids.push(id);
        })
    }
    // add the new one
    prev_ids.push(daily_recommendation_plan_id);
    removed_daily_recommendation_plans_elm.val(JSON.stringify(prev_ids));
}
