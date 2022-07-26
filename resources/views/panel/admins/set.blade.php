<div class="kt-portlet">
    <div class="kt-portlet__body">

        @AjaxForm(['form_id' => 'admin-form', 'is_update' => isset($admin) ])@endAjaxForm

        <form action="{{ isset($admin) ? route('panel.admins.update', ['admin' => $admin->id]) : route('panel.admins.store') }}"
              id="admin-form" method="post">
            @csrf

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name">@lang('validation.attributes.email')</label>
                        <input type="text" name="email" class="form-control text-left dir-ltr" @isset($admin->email) value="{{ $admin->email }}" @endisset>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name">@lang('validation.attributes.name')</label>
                        <input name="name" type="text" class="form-control" id="name" @isset($admin->name) value="{{ $admin->name }}" @endisset>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name">@lang('validation.attributes.password')</label>
                        <input type="text" name="password" class="form-control text-left dir-ltr">
                    </div>
                </div>
            </div>

            <!--begin::Roles-->
            <h6 class="mt-2 mb-4">
                @lang('general.roles')
            </h6>
            <div class="row mb-3">
                @forelse(\Spatie\Permission\Models\Role::where("guard_name", 'admin')->get() as $role)
                    <div class="col-lg-2">
                        <label class="kt-checkbox kt-checkbox--success">
                            <input name="roles[]" value="{{ $role->id }}" type="checkbox"
                                   @if(!empty($admin->roles) && $admin->roles->pluck('id')->contains($role->id)) checked @endif >
                            {{ $role->name }}
                            <span></span>
                        </label>
                    </div>
                @empty
                    <div class="col-lg-12">
                        @lang('general.not_found')
                    </div>
                @endif
            </div>
            <!--end::Roles-->

            <div class="form-group">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button class="submit-button btn btn-success" type="button">@lang('general.submit') <i
                            class="la la-floppy-o p-0"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
