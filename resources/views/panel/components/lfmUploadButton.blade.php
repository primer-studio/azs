<div class="lfm-upload-container input-group">
    <span class="input-group-btn">
     <a data-preview="holder" class="lfm-upload-btn btn btn-primary text-white"
        data-base-url="{{ url('/') }}"
        data-file-type="{{ isset($file_type) ? $file_type : "file" }}"
     >
        {{-- TODO[fix-label]: fix label/message --}}
       <i class="fa fa-picture-o"></i> {{ isset($button_title) ? $button_title : __('general.choose_file') }}
     </a>
    </span>
    <input class="lfm-upload-path form-control" type="{{ isset($hide_input) && $hide_input  ? "hidden" : "text" }}"
           name="{{ isset($input_name) ? $input_name : "upload" }}"
           value="{{ isset($slot) ? $slot : "" }}"
    >
    @if(isset($file_type) && $file_type == 'image')
        <img src="" class="lfm-thumb d-none">
    @endif
</div>


@pushonce('scripts:panel-lfm-upload.js')
<script src="{{ asset("/panel-assets/js/lfm-upload.js") }}"></script>
@endpushonce

