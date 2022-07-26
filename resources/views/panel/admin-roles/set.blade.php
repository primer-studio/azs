<div class="kt-portlet">
    <div class="kt-portlet__body">
        @AjaxForm(['form_id' => 'role-form', 'is_update' => isset($role) ])@endAjaxForm

        <form action="{{ isset($role) ? route('panel.admin-roles.update', ['admin_role' => $role->id]) : route('panel.admin-roles.store') }}"
              id="role-form" method="post">
            @csrf

            <div class="form-group">
                <label>@lang('validation.attributes.name')</label>
                <input name="name" type="text" class="form-control" @isset($role->name) value="{{ $role->name }}" @endisset>
            </div>
            <h5>
                @lang('general.permissions')
            </h5>

            <div class="mt-4 mb-3">
                <div class="row">
                    @forelse(\Spatie\Permission\Models\Permission::where('guard_name', 'admin')->get() as $permission)
                        <div class="col-lg-4">
                            <label class="kt-checkbox kt-checkbox--success">
                                <input name="permissions[]" value="{{ $permission->id }}" type="checkbox"
                                       @if(isset($role) && $role->permissions->pluck('id')->contains($permission->id)) checked @endif  >
                                        {{ $permission->title }} <code>({{ $permission->name }})</code>
                                <span></span>
                            </label>
                        </div>
                    @empty
                        <div class="col-lg-12">
                            @lang('general.not_found')
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button class="submit-button btn btn-success" type="submit">@lang('general.submit') <i class="la la-floppy-o p-0"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>


