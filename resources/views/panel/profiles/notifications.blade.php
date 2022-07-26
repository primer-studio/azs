<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h5 class="kt-portlet__head-title">
                @lang('general.notifications')
            </h5>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('validation.attributes.message')</th>
                <th>@lang('general.date')</th>
            </tr>
            </thead>
            <tbody>

            @forelse($profile->notifications as $notification)
                @php
                    $translated_notification = \Facades\App\Libraries\NotificationHelper::translateNotification($notification, 'panel');
                @endphp
                <tr @if(empty($notification->read_at)) class="font-weight-bold text-danger" @endif >
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ $translated_notification->url }}" target="_blank">
                            {{ $translated_notification->text }}
                        </a>
                    </td>
                    <td>
                        <div class="dir-ltr">
                            {{ jdateComplete($notification->created_at) }}
                        </div>
                    </td>
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

