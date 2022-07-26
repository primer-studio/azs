Pending Invoice Item

invoice item ID: {{ $invoice_item->id }} <br>
@foreach($invoice_item->pending_questions as $question => $date)
    question: {{ $question }} <br>
@endforeach
