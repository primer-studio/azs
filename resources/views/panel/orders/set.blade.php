
<!--begin:: order details-->
<div class="kt-portlet">
    <div class="kt-portlet__body">
        @AjaxForm(['form_id' => 'order-form', 'is_update' => true, 'confirm' =>  __('order.status_change_confirm') ])@endAjaxForm
        <form action="{{ route('panel.orders.update' , ['order' => $order->id]) }}"   id="order-form" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                            <label>@lang('validation.attributes.status')</label>
                            <select name="status" class="form-control">
                                <option value="{{ \App\Constants\GeneralConstants::ORDER_STATUS_CREATED }}"
                                        @if( $order->status == \App\Constants\GeneralConstants::ORDER_STATUS_CREATED ) selected @endif  >
                                    @lang('order.ORDER_STATUS_CREATED')
                                </option>
                                <option value="{{ \App\Constants\GeneralConstants::ORDER_STATUS_COMPLETED }}"
                                        @if( $order->status == \App\Constants\GeneralConstants::ORDER_STATUS_COMPLETED ) selected @endif  >
                                @lang('order.ORDER_STATUS_COMPLETED')</option>
                            </select>
                        </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="date_of_birth">start date</label>
                        @PersianDatepicker([
                        "name" => 'start_date',
                        "class" => 'form-control',
                        "id" => 'start_date',
                        ])
                        {{ $order->start_date }}
                        @endPersianDatepicker
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <button class="submit-button btn btn-success" type="button">@lang('general.submit') <i class="la la-floppy-o p-0"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-lg-4">
                <!--begin::upload file-->
                <form action="{{ route('panel.orders.upload-diet-file' , ['order' => $order->id]) }}"  method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <form>
                                <div class="form-group">
                                    <label for="diet_file">
                                        @lang('general.upload')
                                        @lang('general.file')
                                        @lang('general.diet')
                                    </label>
                                    <input name="diet_file" type="file" class="form-control-file" id="diet_file">
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <button class="submit-button btn btn-success" type="submit">@lang('general.upload')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::upload file-->
            </div>
            <div class="col-lg-4">
                <!--begin::old file-->
                @if(!empty($order->file))
                    <div class="row">
                        <div class="col-lg-12">
                            @lang('general.file')
                            @lang('general.diet'):
                            <a href="{{ url($order->file) }}" target="_blank">
                                @lang('general.download')
                            </a>
                        </div>
                        <div class="col-lg-12">
                            @AjaxForm(['form_id' => 'delete-diet-file-form', 'is_update' => false, 'confirm' =>  __('general.confirm_delete_file') ])@endAjaxForm
                            <form id="delete-diet-file-form" action="{{ route('panel.orders.delete-diet-file' , ['order' => $order->id]) }}"  method="post">
                                @csrf
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <button class="submit-button btn btn-danger" type="button">@lang('general.delete')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                <!--end::old file-->
            </div>
        </div>


    </div>
</div>
<!--end:: order details-->

<div class="kt-portlet p0">
    <div class="kt-portlet__body" style="padding: 1px">
       <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
           @php
               $foods = App\Food::all();
               $sports = App\Sport::all();
               $recommendations = App\Recommendation::all();
           @endphp
           <!-- dev include panel.orders.JSONplan -->
               @if(count($diet->days) && !is_null($order->start_date))
                   @include('panel.orders.standalone.JSONplan')
               @else
                   <p style="font-size: 16px; font-weight: 700" class="text-danger">ابتدا روز شروع رژیم را مشخص نمایید، پس از ثبت می‌توانید برنامه را وارد کنید.</p>
               @endif
           <!-- dev include panel.orders.JSONplan -->
       </div>
    </div>
</div>
