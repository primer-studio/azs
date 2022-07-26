var select_question_container_elm, search_input_elm, processing_elm, questions_list_elm, selected_questions_list_elm,
    selected_questions_input_elm, init_selected_questions = true;

document.addEventListener('DOMContentLoaded', function () {
    select_question_container_elm = $('.select-question-container');
    search_input_elm = select_question_container_elm.find('.search-input');
    processing_elm = select_question_container_elm.find('.processing');
    questions_list_elm = select_question_container_elm.find('.questions-list');
    selected_questions_list_elm = select_question_container_elm.find('.selected-questions-list');
    selected_questions_input_elm = select_question_container_elm.find('.selected-questions');

    search_input_elm.keyup(function () {
        getQuestions();
    })

    getQuestions();


    selected_questions_list_elm.sortable({
        update: function (event, ui) {
            // reset old sort
            resetSelectedQuestions();
            var selected_questions_order = $(this).sortable('toArray', {attribute: 'data-question-id'});
            // convert string to int
            $.each(selected_questions_order, function (i, question_id) {
                addSelectedQuestionsIds(question_id);
            })
        }
    });

})

$(document).on('click', '.selectable-question ', function () {
    var selected_question_id = $(this).attr('data-question-id');
    if (addSelectedQuestionsIds(selected_question_id)) {
        addSelectedElement($(this), selected_question_id);
    }
});

$(document).on('click', '.remove-selected-question', function () {
    var selected_question_id = $(this).attr('data-selected-question-id');
    $(".selected-question-" + selected_question_id).closest('.selected-question-container').remove();
    removeSelectedQuestion(selected_question_id);
});

function addSelectedElement(elm) {
    var question = {
        id: elm.attr('data-question-id'),
        content: elm.html(),
    }
    var selected_elm = $('<div class="selected-question-container d-flex mb-1" data-question-id="' + question.id + '"><div type="button" class="selected-question bg-info text-white selected-question-' + question.id + ' w-100 list-group-item list-group-item-action" data-question-id="' + question.id + '">' + question.content + '</div><button class="remove-selected-question btn btn-danger mr-1" data-selected-question-id="' + question.id + '" type="button">' + remove + '</button></div>');
    selected_questions_list_elm.append(selected_elm)
}

function getQuestions() {
    var search_input = search_input_elm.val();
    starProcessing();
    $.ajax({
        url: get_all_questions_url, // get_all_questions_url is set by script_variables stack
        dataType: 'JSON',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            search_input: search_input
        },
        success: function (data, textStatus, jQxhr) {
            stopProcessing();
            if (data.hasOwnProperty('status')) {
                if (data.status == 'success') {
                    showQuestions(data.data);
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
            stopProcessing();
            // // TODO[front-end]: mange this: show unknown error
            console.log('unknown error')
        }
    });
}

function showQuestions(data) {
    questions_list_elm.html('');
    $.each(data.questions, function (i, question) {
        var item_elm = $('<div class="d-flex mb-1"><button type="button" class="selectable-question question-' + question.id + ' w-100 list-group-item list-group-item-action" data-question-id="' + question.id + '">' + filterXSS(question.title) + '</button></div>');
        questions_list_elm.append(item_elm)
    });
    if (!data.questions.length) {
        var item_elm = '<li class="list-group-item text-center">' + not_found + '</li>';
        questions_list_elm.append(item_elm)
    }

    if (init_selected_questions) {
        $.each(getSelectedQuestions(), function (i, question_id) {
            if (questionIsSelected(question_id)) {
                addSelectedElement($('.selectable-question.question-' + question_id));
            }
        })
        init_selected_questions = false;
    }


}

function starProcessing() {
    processing_elm.removeClass('d-none');
}

function stopProcessing() {
    processing_elm.addClass('d-none');
}

function getSelectedQuestions() {
    var json = selected_questions_input_elm.val();
    var questions = [];
    if (json.length) {
        var questions = JSON.parse(json);
    }
    return questions;
}

function questionIsSelected(question_id) {
    question_id = parseInt(question_id);
    var questions = getSelectedQuestions();
    // check if question already exists, do not add it again
    if (jQuery.inArray(question_id, questions) !== -1) {
        return true;
    }
    return false;
}

function addSelectedQuestionsIds(question_id) {
    var questions = getSelectedQuestions();
    // check if question already exists, do not add it again
    if (questionIsSelected(question_id)) {
        return false;
    }
    questions.push(parseInt(question_id));
    putInInput(questions);
    return true;
}

function removeSelectedQuestion(question_id) {
    var questions = getSelectedQuestions();
    var new_questions = questions.filter(function (elem) {
        return elem != question_id;
    });
    putInInput(new_questions);
}

function resetSelectedQuestions() {
    putInInput([]);
}

function putInInput(questions) {
    selected_questions_input_elm.val(JSON.stringify(questions));
}
