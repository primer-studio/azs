{{-- TODO[check-view]: these codes are temporary to test, re-write UI with proper codes, set validation errors (check controller validate too), set old data, ... --}}
<div class="select-question-container ">
    <div class="row">
        <div class="col-6">
            <div class="selected-questions-list list-group">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <div class="input-group mb-3">
                    <input type="text" class="search-input form-control">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">search</button>
                    </div>
                </div>
                <div class="processing d-none text-center list-group-item">
                    {{ __('general.processing') }}
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </div>
                <div class="questions-list list-group">
                </div>
                <input type="hidden" name="questions_ids" class="selected-questions" @isset($selected_questions_ids) value='{{ json_encode($selected_questions_ids) }}' @endisset>
            </div>
        </div>
    </div>
</div>

@include('panel.includes.include-jquery-ui')

@pushonce('script_variables:panel-steps/get_all_questions_url')
<script>
    var get_all_questions_url = "{{ route('panel.questions.get-all-questions') }}";
</script>
@endpushonce



@pushonce('scripts:panel-steps/select-question.js')
<script src="{{ asset("/panel-assets/js/steps/select-question.js") }}"></script>
@endpushonce
