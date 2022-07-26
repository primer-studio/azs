@foreach($questions as $question)
    @include("dashboard.questions.question", ['question' => $question])
@endforeach

@pushonce('scripts:dashboard-js/questions/question.js')
<script src="{{  asset('dashboard-assets/js/questions/question.js') }}"></script>
@endpushonce
