<div class="kt-portlet">
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>title</th>
                <th>duration</th>
                <th>status</th>
                <th>sort</th>
                <th>edit</th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($steps as $step)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $step->title }}</td>
                    <td>{{ $step->duration }}</td>
                    <td>{{ $step->status }}</td>
                    <td>{{ $step->sort }}</td>
                    <td><a href="{{ route('panel.steps.edit', ['step' => $step->id]) }}">Edit</a></td>
                </tr>
            @empty
                <tr>
                    <th colspan="6">No steps</th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $steps->links() }}
        </div>
    </div>
</div>
