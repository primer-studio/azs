document.addEventListener("DOMContentLoaded", function () {
    var dynamic_next_page_link_elm = $("#dynamic-next-page-link");
    var select_period = $("#select-period");
    setNextPageUrl()

    select_period.change(function () {
        setNextPageUrl()
    });

    function setNextPageUrl() {
        var selected_url = select_period.find(":selected").val();
        dynamic_next_page_link_elm.attr('href', selected_url);
    }
})
