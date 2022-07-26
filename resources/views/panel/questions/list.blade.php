<div class="kt-portlet">
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>title</th>
                <th>short name</th>
                <th>type</th>
                <th>status</th>
                <th>sort</th>
                <th>edit</th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($questions as $question)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $question->title }}</td>
                    <td><code>{{ $question->short_name }}</code></td>
                    <td>{{ $question->answer_properties->type }}</td>
                    <td>{{ $question->status }}</td>
                    <td>{{ $question->sort }}</td>
                    <td><a href="{{ route('panel.questions.edit', ['question' => $question->id]) }}">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <th colspan="7">No question</th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $questions->links() }}
        </div>
    </div>
</div>
