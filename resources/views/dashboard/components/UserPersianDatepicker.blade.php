<div class="d-flex flex-wrap inputContainer">
    <label class="organizer">@isset($label){{ $label }}@endisset</label>
    <div class="organizer box-input">
        <input type="text" class="input azshanbeInput persian-datepicker-input {{ isset($class) ? $class : "" }}" autocomplete="off"
               @isset($name) name="{{ $name }}" @endisset
               @isset($id) id="{{ $id }}" @endisset
        @isset($attributes)
            @foreach($attributes as $attribute => $value)
                {{ $attribute }}="{{ $value }}"
            @endforeach
        @endisset/>
    </div>
</div>


@pushonce('styles:general-persian-datepicker.css')
<link rel="stylesheet" href="{{  asset('/third-party/persian-datepicker/css/persian-datepicker.min.css') }}"/>
@endpushonce

@pushonce('scripts:general-persian-datepicker.min.js')
<script src="{{  asset('/third-party/persian-datepicker/js/persian-date.min.js') }}"></script>
<script src="{{  asset('/third-party/persian-datepicker/js/persian-datepicker.min.js') }}"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        var persian_datepicker_input_elm = $('.persian-datepicker-input');
        var pd = persian_datepicker_input_elm.persianDatepicker({
            initialValue: false,
            observer: true,
            format: 'YYYY/MM/DD',
            autoClose: true,
            onSelect: function (unix) {
                var input_elm = $(this)[0]['model']['inputElement'];
                input_elm.value = input_elm.value.toEnglishDigit();
            }
        });

        @if(!empty(trim($slot)))
                pd.setDate({{ trim($slot) * 1000 }})
        @endif


        persian_datepicker_input_elm.each(function () {
            $(this).val($(this).val().toEnglishDigit())
        });

        persian_datepicker_input_elm.change(function () {
            $(this).val($(this).val().toEnglishDigit())
        });
    });
</script>
@endpushonce





