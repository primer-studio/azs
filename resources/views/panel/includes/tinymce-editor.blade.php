<script>
    document.addEventListener("DOMContentLoaded", function () {
        $(".hi-tinymce-editor").each(function (i, elm) {
            var textarea_elm = $(elm);
            var target = textarea_elm[0]
            var editor_config = {
                language: textarea_elm.useAttrElse('data-language', 'fa_IR'),
                height: textarea_elm.useAttrElse('data-height', 200),
                directionality: textarea_elm.useAttrElse('data-directionality', 'rtl'),
                target: target,
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                file_browser_callback: function (field_name, url, type, win) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                    var cmsURL = editor_config.path_absolute + '/panel/laravel-filemanager?field_name=' + field_name;
                    if (type == 'image') {
                        cmsURL = cmsURL + "&type=Images";
                    } else {
                        cmsURL = cmsURL + "&type=Files";
                    }

                    tinyMCE.activeEditor.windowManager.open({
                        file: cmsURL,
                        title: 'Filemanager',
                        width: x * 0.8,
                        height: y * 0.8,
                        resizable: "yes",
                        close_previous: "no"
                    });
                },
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    })
                },
                path_absolute: "{{ url('/') }}",
                relative_urls: true,
                document_base_url: "{{ url('/') }}"
            };
            tinymce.init(editor_config);
        })
    })
</script>

@push('scripts')
    <script src="{{ url("/panel-assets/plugins/tinymce/js/tinymce/tinymce.min.js") }}"></script>
@endpush
