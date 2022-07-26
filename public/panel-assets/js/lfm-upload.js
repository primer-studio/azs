// replace "./" with "/" EX: "./upload/photos/" to "/upload/photos/"
function removeFirstDot(input) {
    var regex = "/^(.\\/)(.*)/";
    var output = input.replace(regex, '/$2');
    return output;
}

document.addEventListener("DOMContentLoaded", function () {
    $(".lfm-upload-btn").click(function () {
        var base_url = window.location.origin;
        var lfm_upload_container_elm = $(this).closest('.lfm-upload-container');
        var file_type = $(this).attr("data-file-type");
        window.open(base_url + '/panel/laravel-filemanager?type=' + file_type, 'FileManager', 'width=900,height=600;centerscreen=yes');
        window.SetUrl = function (items) {
            // this code does not support multiple select and we just get the first selected file
            var file_path = removeFirstDot(items[0].url);
            if (file_type == 'image' && items[0].thumb_url) {
                lfm_upload_container_elm.find('.lfm-thumb').attr('src', base_url + removeFirstDot(items[0].thumb_url)).removeClass("d-none");
            }

            // set the value of the desired input to image url
            lfm_upload_container_elm.find('.lfm-upload-path').val(file_path);
        };
    })
})
