<input type="text" class="persian-datepicker-input {{ isset($class) ? $class : "" }}" autocomplete="off"
       @isset($name) name="{{ $name }}" @endisset
       @isset($id) id="{{ $id }}" @endisset
       @if(!empty($explicit_old_jdate)) value="{{ $explicit_old_jdate }}" @endif
@isset($attributes)
    @foreach($attributes as $attribute => $value)
        {{ $attribute }}="{{ $value }}"
    @endforeach
@endisset/>

@pushonce('styles:general-persian-datepicker.css')
<link rel="stylesheet" href="{{  asset('/third-party/persian-datepicker/css/persian-datepicker.min.css') }}"/>
@endpushonce

@pushonce('scripts:general-persian-datepicker.min.js')
<script src="{{  asset('/third-party/persian-datepicker/js/persian-date.min.js') }}"></script>
<script src="{{  asset('/third-party/persian-datepicker/js/persian-datepicker.min.js') }}"></script>
@endpushonce

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        var persian_datepicker_input_elm = $('#{{ $id }}');
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

        @if(!empty(trim($slot)) && empty($explicit_old_jdate))
                pd.setDate({{ trim($slot) * 1000 }})
        @endif


        persian_datepicker_input_elm.each(function () {
            persian_datepicker_input_elm.val($(this).val().toEnglishDigit())
        });

        persian_datepicker_input_elm.change(function () {
            $(this).val($(this).val().toEnglishDigit())
        });
    });
</script>






