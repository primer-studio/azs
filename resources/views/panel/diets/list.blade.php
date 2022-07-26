<div class="kt-portlet">
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>title</th>
                <th>duration</th>
                <th>status</th>
                <th>@lang('general.permission')</th>
                <th>sort</th>
                <th>edit</th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($diets as $diet)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $diet->title }}</td>
                    <td>{{ $diet->duration }}</td>
                    <td>{{ $diet->status }}</td>
                    <td>
                        @if($diet->need_permission)
                            <code>
                                {{ \App\Constants\GeneralConstants::DIET_PERMISSION_NAME_PREFIX . $diet->id }}
                            </code>
                        @endif
                    </td>
                    <td>{{ $diet->sort }}</td>
                    <td><a href="{{ route('panel.diets.edit', ['diet' => $diet->id]) }}">Edit</a></td>
                </tr>
            @empty
                <tr>
                    <th colspan="6">No diets</th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $diets->links() }}
        </div>
    </div>
</div>
