
<script>
    document.addEventListener("DOMContentLoaded", function () {
        $('#{{$form_id}}').ajaxForm({{ empty($is_update) ? 'false' : 'true'  }}, '{{ isset($confirm) ? $confirm : "" }}')
    })
</script>

@pushonce('scripts:panel-ajax-form.js')
<script src="{{  asset('/panel-assets/js/ajax-form.js?v=1.06') }}"></script>
@endpushonce
