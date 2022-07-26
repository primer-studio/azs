@cannot('change_profiles_data')
    <div class="alert alert-warning">
        @lang('general.just_see_access_not_change')
    </div>
@endcannot

<div class="row">
    <!--begin::profile data-->
    <div class="col-lg-5">
        <div class="alert alert-danger">
            @lang('general.profile_form_alert')
        </div>
        <!--begin:: basic information-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h5 class="kt-portlet__head-title">
                        @lang('general.basic_information')
                    </h5>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form action="{{  route('panel.profiles.update', ['profile' => $profile->id]) }}"
                      id="profile-form" method="post">
                    @csrf

                    <div class="form-group">
                        @if(!empty($profile->user->affiliationPartner))
                            <label for="name">@lang('general.affiliation_partner'): </label>
                            <a href="{{ route('panel.affiliation-partners.edit' , ['affiliation_partner' =>  $profile->user->affiliationPartner->id ]) }}"
                               target="_blank">
                                {{ $profile->user->affiliationPartner->name }}
                            </a>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="form-group">
                                <label for="name">@lang('validation.attributes.mobile')</label>

                                <input type="text" disabled class="form-control" @can('see_mobile_number') value="{{ $profile->user->mobile_number }}" @endcan>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="name">@lang('validation.attributes.id')</label>
                                <input type="text" disabled class="form-control" value="{{ $profile->id }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-1">
                                <label class="kt-checkbox kt-checkbox--success">
                                    <input name="is_dissatisfied" type="checkbox"
                                           @if($profile->is_dissatisfied) checked @endif >
                                    @lang('validation.attributes.is_dissatisfied')
                                    <span></span>
                                </label>
                                <small class="form-text text-muted">@lang('general.this_case_does_not_have_old_value')</small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-1">
                                <label class="kt-checkbox kt-checkbox--success">
                                    <input name="in_progress" type="checkbox"
                                           @if($profile->in_progress) checked @endif >
                                            @lang('validation.attributes.in_progress')
                                            @if(!empty($profile->inProgressBy))
                                                (@lang('general.by')  {{ $profile->inProgressBy->name }})
                                            @endif
                                    <span></span>
                                </label>
                                <small class="form-text text-muted">@lang('general.this_case_does_not_have_old_value')</small>
                            </div>
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="name">@lang('validation.attributes.name')</label>
                        <input name="name" type="text" class="form-control" id="name"
                               value="{{ old('name', $profile->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="note">@lang('validation.attributes.note') @lang('general.operator')</label>
                        <textarea name="note" rows="8" type="text" class="form-control" id="note"  >{{ old('note', $profile->note) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="gender">@lang('validation.attributes.gender')</label>
                        <select name="gender" class="form-control" id="gender">
                            <option @if( old('gender', $profile->gender) == 'male' ) selected
                                    @endif value="male">@lang('general.male')</option>
                            <option @if( old('gender', $profile->gender) == 'female' ) selected
                                    @endif value="female">@lang('general.female')</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">@lang('validation.attributes.date_of_birth')</label>
                        @PersianDatepicker([
                        "name" => 'date_of_birth',
                        "class" => 'form-control',
                        "id" => 'date_of_birth',
                        "explicit_old_jdate" => old('date_of_birth'),
                        ])
                        {{ $profile->date_of_birth }}
                        @endPersianDatepicker
                    </div>

                    <!--begin::height-->
                    <div class="form-group">
                        <label for="height">@lang('validation.attributes.height') </label>
                        <input name="height" type="number" class="form-control" id="height"
                               value="{{ old('height', $profile->height) }}">
                    </div>
                    <!--end::height-->

                    <!--begin::marital_status-->
                    <div class="form-group">
                        <label for="marital_status">@lang('validation.attributes.marital_status') </label>
                        <select name="marital_status" class="form-control" id="marital_status">
                            <option @if( old('marital_status', $profile->marital_status) == 'single' ) selected @endif value="single">مجرد
                            </option>
                            <option @if( old('marital_status', $profile->marital_status) == 'married' ) selected @endif value="married">متاهل
                            </option>
                        </select>
                    </div>
                    <!--end::marital_status-->

                    <!--begin::blood_type-->
                    <div class="form-group">
                        <label for="blood_type">@lang('validation.attributes.blood_type') </label>
                        <input name="blood_type" type="text" class="form-control" id="blood_type"
                               value="{{ old('blood_type', $profile->blood_type ) }}">
                    </div>
                    <!--end::blood_type-->

                    <!--begin::illness_history-->
                    <div class="form-group">
                        <label for="illness_history">@lang('validation.attributes.illness_history') </label>
                        <textarea name="illness_history" type="text" class="form-control"
                                  id="illness_history">{{ old('illness_history', $profile->illness_history) }}</textarea>
                    </div>
                    <!--end::illness_history-->

                    <!--begin::favorite_foods-->
                    <div class="form-group">
                        <label for="favorite_foods">@lang('validation.attributes.favorite_foods') </label>
                        <textarea name="favorite_foods" type="text" class="form-control"
                                  id="favorite_foods">{{ old( 'favorite_foods' , $profile->favorite_foods) }}</textarea>
                    </div>
                    <!--end::favorite_foods-->

                    <!--begin::prohibited_foods-->
                    <div class="form-group">
                        <label for="prohibited_foods">@lang('validation.attributes.prohibited_foods') </label>
                        <textarea name="prohibited_foods" type="text" class="form-control"
                                  id="prohibited_foods">{{ old( 'prohibited_foods' , $profile->prohibited_foods) }}</textarea>
                    </div>
                    <!--end::prohibited_foods-->

                    <!--begin::province_id-->
                    <div class="form-group">
                        <label for="province_id">@lang('validation.attributes.province') </label>
                        <select name="province_id" class="form-control" id="province_id">
                            @foreach($provinces as $province)
                                <option @if( $province->id == old( 'province_id', $profile->province_id) ) selected
                                        @endif value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::province_id-->

                    <!--begin::city-->
                    <div class="form-group">
                        <label for="city">@lang('validation.attributes.city') </label>
                        <input name="city" type="text" class="form-control" id="city" value="{{ old('city', $profile->city) }}">
                    </div>
                    <!--end::city-->

                    <div class="form-group">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <button class="btn btn-success" type="submit">@lang('general.submit') <i
                                    class="la la-floppy-o p-0"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!--end:: basic information-->

        <div class="alert alert-danger">
            @lang('general.profile_form_alert')
        </div>

        <!--begin::questions-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h5 class="kt-portlet__head-title">
                        @lang('general.diet_questions')
                    </h5>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form action="{{  route('panel.profiles.update-questions-answers', ['profile' => $profile->id]) }}"
                      id="profile-questions-form" method="post">
                    @csrf

                    @if(!empty($questions))
                        @php
                            $data_comments = !empty($profile->data_comments) ? $profile->data_comments : [];
                        @endphp
                        @include('panel.profiles.questions.questions', ['questions' => $questions, 'data_comments' => $data_comments])
                    @endif

                    <div class="form-group">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <button class="submit-button btn btn-success" type="submit">@lang('general.submit') <i
                                    class="la la-floppy-o p-0"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end::questions-->
    </div>
    <!--end::profile data-->

    <div class="col-lg-7">

        <!--begin::notifications-->
        @include('panel.profiles.notifications')
        <!--end::notifications-->

        <!--begin::Roles-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h5 class="kt-portlet__head-title">
                        @lang('general.roles')
                    </h5>
                </div>
            </div>
            <div class="kt-portlet__body">
                @AjaxForm(['form_id' => 'set-roles', 'is_update' => false ])@endAjaxForm
                <form method="post" id="set-roles"
                      action="{{ route('panel.users.set-roles', ['user' => $profile->user->id]) }}">
                    @csrf
                    <div class="row">
                        @forelse(\Spatie\Permission\Models\Role::where('guard_name', 'web')->get() as $role)
                            <div class="col-lg-4">
                                <label class="kt-checkbox kt-checkbox--success">
                                    <input name="roles[]" value="{{ $role->id }}" type="checkbox"
                                           @if(!empty($profile->user->roles) && $profile->user->roles->pluck('id')->contains($role->id)) checked @endif >
                                    {{ $role->name }}
                                    <span></span>
                                </label>
                            </div>
                        @empty
                            <div class="col-lg-12">
                                @lang('general.not_found')
                            </div>
                        @endif

                        <div class="col-lg-12">
                            <div class="form-group mb-0 mt-2">
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <button class="submit-button btn btn-success"
                                            type="submit">@lang('general.submit')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end::Roles-->

        <!--begin::add_to_cart-->
        @include('panel.profiles.add_to_cart')
        <!--end::add_to_cart-->

        <!--begin::cart-->
        @include('panel.profiles.cart')
        <!--end::cart-->

        <!--begin::last 10 invoices-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h5 class="kt-portlet__head-title">
                        10
                        @lang('general.invoice')
                        @lang('general.last')
                    </h5>
                </div>
            </div>
            <div class="kt-portlet__body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>status</th>
                        <th>date</th>
                        <th>payment_way</th>
                        <th>total_amount</th>
                        <th>edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse  ($profile->invoices as $invoice)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ \Facades\App\Libraries\InvoiceHelper::translateInvoiceStatus($invoice->status) }}</td>
                            <td>{{ jdateComplete( $invoice->created_at) }}</td>
                            <td>{{ \Facades\App\Libraries\InvoiceHelper::translatePaymentWay($invoice->payment_way) }}</td>
                            <td>{{ money($invoice->total_amount) }}</td>
                            <td>
                                <a href="{{ route('panel.invoices.edit', ['invoice' => $invoice->id]) }}">@lang('general.edit')</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th colspan="6">No invoices</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!--end::last 10 invoices-->

        <!--begin::last 10 orders-->
        @include('panel.profiles.orders')
        <!--end::last 10 orders-->

        <!--begin::last query string data-->
        <div class="kt-portlet" style="direction: ltr; text-align: left">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h5 class="kt-portlet__head-title">
                        Last UTM data
                    </h5>
                </div>
            </div>
            <div class="kt-portlet__body">
                @if(!empty($profile->user->last_query_string_data))
                    <!--begin::Timeline 1-->
                        <ul>
                            @foreach($profile->user->last_query_string_data as $key => $value)
                                <li>
                                    <code>{{ $key }}</code>:
                                    <strong>{{ $value }}</strong>
                                </li>
                            @endforeach
                        </ul>
                    <!--end::Timeline 1-->
                @else
                    @lang('general.not_found')
                @endif
            </div>
        </div>
        <!--end::last query string data-->

        <!--begin::profile logs-->
        @include('panel.profiles.logs')
        <!--end::profile logs-->

    </div>


</div>


