@foreach($questions as $question)
    @include("panel.profiles.questions.question", ['question' => $question])
@endforeach

@pushonce('scripts:panel-js/profiles/question.js')
<script src="{{  asset('panel-assets/js/profiles/question.js') }}"></script>
@endpushonce
