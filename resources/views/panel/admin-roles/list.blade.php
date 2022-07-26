<div class="kt-portlet">
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('validation.attributes.name')</th>
                <th>@lang('general.permissions')</th>
                <th>edit</th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($roles as $role)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $role->name }}</td>
                    <td>
                        @if(!empty($role->permissions))
                            @foreach($role->permissions->pluck('title') as $permission)
                                <span class="text-danger">
                                    {{ $permission }}
                                </span>
                                @if(!$loop->last)
                                    |
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td><a href="{{ route('panel.admin-roles.edit', ['admin_role' => $role->id]) }}">@lang('general.edit')</a></td>
                </tr>
            @empty
                <tr>
                    <th colspan="50" class="text-center">
                        @lang('general.not_found')
                    </th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $roles->links() }}
        </div>
    </div>
</div>

