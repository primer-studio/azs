<div class="kt-portlet">
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('validation.attributes.name')</th>
                <th>@lang('validation.attributes.email')</th>
                <th>@lang('general.roles')</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($admins as $admin)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $admin->name }}</td>
                    <td>
                        {{ $admin->email }}
                    </td>
                    <td>
                        @if(!empty($admin->roles))
                            @foreach($admin->roles as $role)
                                <span class="text-warning">
                                    {{ $role->name }}
                                </span>
                                @if(!$loop->last)
                                     |
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td><a href="{{ route('panel.admins.edit', ['admin' => $admin->id]) }}">Edit</a></td>
                </tr>
            @empty
                <tr>
                    <th colspan="50" class="text-center">@lang('general.not_found')</th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $admins->links() }}
        </div>
    </div>
</div>
