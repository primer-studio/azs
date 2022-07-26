<script>
    document.addEventListener("DOMContentLoaded", function () {
        @php
            if (isset($form_id)) {
                $selector = "#" . $form_id;
            }
        @endphp

        @if(!empty($selector))
            $('{{$selector}}').ajaxForm({{ empty($is_update) ? 'false' : 'true'  }}, '{{ isset($confirm) ? $confirm : "" }}');
        @endif
    })
</script>

@pushonce('scripts:panel-ajax-form.js')
<script src="{{  asset('/dashboard-assets/js/ajax-form.js?v=1.03') }}"></script>
@endpushonce
