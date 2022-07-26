
@forelse  ($diets as $diet)
    <div class="kt-portlet">
        <div class="kt-portlet__body pt-2">
            <div class="kt-portlet__head mb-1">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        <a href="{{ route('panel.diets.edit', ['diet' => $diet->id]) }}">{{ $diet->title }}</a>
                    </h3>
                </div>
            </div>
            @forelse($diet->periods_steps_questions as $period_number => $period)
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h4 class="kt-portlet__head-title">
                                @lang('validation.attributes.period') {{ $period_number }}
                            </h4>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        @forelse  ($period as $step)
                            <div class="kt-portlet kt-portlet--bordered">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h4 class="kt-portlet__head-title">
                                            <a href="{{ route('panel.steps.edit', ['step' => $step->id]) }}">{{ $step->title }}</a>
                                        </h4>
                                    </div>
                                </div>
                                <div class="kt-portlet__body">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>title</th>
                                            <th>short name</th>
                                            <th>type</th>
                                            <th>status</th>
                                            <th>required</th>
                                            <th>sort</th>
                                            <th>edit</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse  ($step->questions as $question)
                                            <tr>
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{ $question->title }}</td>
                                                <td><code>{{ $question->short_name }}</code></td>
                                                <td>{{ $question->answer_properties->type }}</td>
                                                <td>
                                                    @if($question->status == "active")
                                                        <span class="kt-badge kt-badge--success kt-badge--inline">active</span>
                                                    @elseif($question->status == "inactive")
                                                        <span class="kt-badge kt-badge--danger kt-badge--inline">inactive</span>
                                                    @else
                                                        <span class="kt-badge kt-badge--brand kt-badge--inline">{{ $question->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($question->is_required_to_receive_diet)
                                                        <span class="kt-badge kt-badge--success kt-badge--inline">yes</span>
                                                    @else
                                                        <span class="kt-badge kt-badge--danger kt-badge--inline">no</span>
                                                    @endif
                                                </td>
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
                                </div>
                            </div>
                        @empty
                            <div class="card">
                                <div class="card-header">
                                    No step
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            @empty
                no period
            @endforelse
        </div>
    </div>
@empty
    <div class="card">
        <div class="card-body">
            no diet
        </div>
    </div>
@endforelse

