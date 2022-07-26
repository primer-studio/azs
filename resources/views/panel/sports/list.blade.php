<div class="kt-portlet">
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>title</th>
                <th>unit</th>
                <th>status</th>
                <th>sort</th>
                <th>edit</th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($sports as $sport)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $sport->title }}</td>
                    <td>
                    <span class="text-danger text-hover-danger">
                        {{ $sport->unit }}
                    </span>
                    </td>
                    <td>{{ $sport->status }}</td>
                    <td>{{ $sport->sort }}</td>
                    <td><a href="{{ route('panel.sports.edit', ['sport' => $sport->id]) }}">Edit</a></td>
                </tr>
            @empty
                <tr>
                    <th colspan="6">No sports</th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $sports->links() }}
        </div>
    </div>
</div>

