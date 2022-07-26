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
            @forelse  ($foods as $food)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $food->title }}</td>
                    <td>
                    <span class="text-danger text-hover-danger">
                        {{ $food->unit }}
                    </span>
                    </td>
                    <td>{{ $food->status }}</td>
                    <td>{{ $food->sort }}</td>
                    <td><a href="{{ route('panel.foods.edit', ['food' => $food->id]) }}">Edit</a></td>
                </tr>
            @empty
                <tr>
                    <th colspan="6">No foods</th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $foods->links() }}
        </div>
    </div>
</div>

