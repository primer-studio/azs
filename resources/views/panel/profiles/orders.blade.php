<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h5 class="kt-portlet__head-title">
                10
                @lang('general.order')
                @lang('general.last')
            </h5>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('validation.attributes.status')</th>
                <th>
                    @lang('general.date')
                    @lang('general.start')
                </th>
                <th>
                    @lang('general.date')
                    @lang('general.end')
                </th>
                <td>
                    @lang('general.file')
                </td>
                <th>
                    @lang('general.updated_at')
                </th>
                <th>
                    @lang('general.edit')
                </th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($profile->orders as $order)
                <tr @if(!$order->seen) class="font-weight-bold" @endif>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $order->status }}</td>
                    <td>{{ !empty($order->start_date) ? jdateComplete($order->start_date) : "" }}</td>
                    <td>{{ !empty($order->end_date) ? jdateComplete($order->end_date) : "" }}</td>
                    <td class="text-center">
                        @if(!empty($order->file))
                            <a href="{{ url($order->file) }}" target="_blank">
                                @lang('general.download')
                            </a>
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td>{{ jdateComplete($order->updated_at) }}</td>
                    <td><a href="{{ route('panel.orders.edit', ['order' => $order->id]) }}">@lang('general.edit')</a></td>
                </tr>
            @empty
                <tr>
                    <th colspan="50">@lang('general.not_found')</th>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
