<!--begin::search box-->
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                @lang('general.search')
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <form method="GET" action="{{ route('panel.profiles.index') }}">
            <!--begin::search inputs-->
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>@lang('validation.attributes.name')</label>
                        <input name="profile_name" type="text" class="form-control" @isset($search_items->profile_name) value="{{ $search_items->profile_name }}" @endisset>
                    </div>
                </div>

                @can('see_mobile_number')
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>@lang('validation.attributes.mobile')</label>
                            <input name="mobile_number" type="text" class="form-control" @isset($search_items->mobile_number) value="{{ $search_items->mobile_number }}" @endisset>
                        </div>
                    </div>
                @endcan
            </div>
            <div class="row">
                <div class="col-lg-4 d-flex">
                    <div class="form-group mb-0">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <button class="submit-button btn btn-success" type="submit">@lang('general.search') <i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="form-group mb-0 mx-2">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <a href="{{ route('panel.profiles.index') }}" class="submit-button btn btn-info" type="submit">@lang('general.reset') <i class="fa fa-times" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--end::search box-->

<div class="kt-portlet">
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('validation.attributes.name')</th>
                <th>@lang('validation.attributes.mobile')</th>
                <th>@lang('validation.attributes.gender')</th>
                <th>@lang('validation.attributes.date_of_birth')</th>
                <th>@lang('validation.attributes.province')</th>
                <th>@lang('validation.attributes.city')</th>
                <th>@lang('general.affiliation_partner')</th>
                <th>@lang('general.roles')</th>
                <th>@lang('validation.attributes.is_dissatisfied')</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($profiles as $profile)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $profile->name }}</td>
                    <td>
                        @can('see_mobile_number')
                            {{ $profile->user->mobile_number }}
                            @if(!empty($profile->user->mobile_number_verified_at))
                                <small class="text-success">(verified)</small>
                            @endif
                        @endcan
                    </td>
                    <td>{{ $profile->gender }}</td>
                    <td>{{ !empty($profile->date_of_birth) ? jdate($profile->date_of_birth) : "--" }}</td>
                    <td>{{ !empty($profile->province->name) ? $profile->province->name : "" }}</td>
                    <td>{{ $profile->city }}</td>
                    <td>
                        @if(!empty($profile->user->affiliationPartner))
                            <a href="{{ route('panel.affiliation-partners.edit' , ['affiliation_partner' =>  $profile->user->affiliationPartner->id ]) }}" target="_blank">
                                {{ $profile->user->affiliationPartner->name }}
                            </a>
                        @endif
                    </td>
                    <td>
                        @if(!empty($profile->user->roles))
                            @foreach($profile->user->roles as $role)
                                <span class="text-warning">
                                    {{ $role->name }}
                                </span>
                                @if(!$loop->last)
                                     |
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td class="text-center @if($profile->is_dissatisfied) text-danger @endif">
                        @if($profile->is_dissatisfied)
                            <i class="fa fa-check" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td><a href="{{ route('panel.profiles.edit', ['profile' => $profile->id]) }}">Edit</a></td>
                </tr>
            @empty
                <tr>
                    <th colspan="50" class="text-center">@lang('general.not_found')</th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $profiles->links() }}
        </div>
    </div>
</div>
