<div
    class="recommendation recommendation-{{ $day }} border border-dark kt-portlet  kt-portlet--height-fluid" data-day="{{ $day }}">
    <div class="kt-portlet__head kt-portlet__head--noborder">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                @lang('general.recommendation') <small>(@lang('general.day') {{ $day }})</small>
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body pt-1 pb-2 px-3">
        <!--begin::recommendations list-->
        <div class="recommendations-list"></div>
        <!--end::recommendations list-->
        <!--begin::search-->
        <div class="kt-widget7 kt-widget7--skin-light">
            <!--begin::search input-->
            <div>
                <div class="row justify-content-md-center">
                    <div class="col-lg-4">
                        <div class="search-main form-group">
                            <div class="kt-input-icon kt-input-icon--left">
                                <input type="text" class="search-recommendation search-input form-control"
                                       data-day="{{ $day }}"  data-type="recommendation"  placeholder="Search...">
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span class="search-icon">
                                        <i class="la la-search"></i>
                                    </span>
                                </span>
                            </div>
                            <!--begin::search result-->
                            <div class="search-result-container mt-0 p position-absolute bg-white d-none">
                                <table class="search-result-list table table-bordered table-hover">
                                </table>
                            </div>
                            <!--end::search result-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::search input-->
        </div>
        <!--end::search-->

        <!--begin::recommendations-->
        <div class="recommendations-container"></div>
        <!--end::recommendations-->
    </div>
</div>
