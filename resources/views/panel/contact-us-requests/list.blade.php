<div class="kt-portlet">
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('validation.attributes.name')</th>
                <th>@lang('validation.attributes.mobile')</th>
                <th>@lang('validation.attributes.message')</th>
                <th>@lang('validation.attributes.date')</th>
            </tr>
            </thead>
            <tbody>
            @forelse($contact_us_requests as $contact_us_request)
                <tr @if(!$contact_us_request->seen) class="font-weight-bold" @endif>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $contact_us_request->name }}</td>
                    <td>{{ $contact_us_request->mobile_number }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($contact_us_request->message, 60, " ...") }}</td>
                    <td class="dir-ltr">{{ jdateComplete($contact_us_request->created_at) }}</td>
                    <td><a href="{{ route('panel.contact-us-requests.edit', ['contact_us_request' => $contact_us_request->id]) }}">@lang('general.show')</a></td>
                </tr>
            @empty
                <tr class="text-center">
                    <th colspan="50">@lang('general.not_found')</th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $contact_us_requests->links() }}
        </div>
    </div>
</div>

