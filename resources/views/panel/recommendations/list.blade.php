<div class="kt-portlet">
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>title</th>
                <th>status</th>
                <th>sort</th>
                <th>edit</th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($recommendations as $recommendation)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $recommendation->title }}</td>
                    <td>{{ $recommendation->status }}</td>
                    <td>{{ $recommendation->sort }}</td>
                    <td><a href="{{ route('panel.recommendations.edit', ['recommendation' => $recommendation->id]) }}">Edit</a></td>
                </tr>
            @empty
                <tr>
                    <th colspan="6">No recommendations</th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $recommendations->links() }}
        </div>
    </div>
</div>

