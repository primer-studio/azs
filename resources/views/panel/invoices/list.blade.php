<div class="kt-portlet">
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>profile</th>
                <th>status</th>
                <th>date</th>
                <th>payment_way</th>
                <th>total_amount</th>
                <th>edit</th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($invoices as $invoice)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>
                        @if(!empty($invoice->profile))
                            <a href="{{ route('panel.profiles.edit', ['profile' => $invoice->profile->id]) }}">{{ $invoice->profile->name }}</a>
                        @endif
                    </td>
                    <td>{{ $invoice->status }}</td>
                    <td>{{ jdateComplete( $invoice->created_at) }}</td>
                    <td>{{ $invoice->payment_way }}</td>
                    <td>{{ money($invoice->total_amount) }}</td>
                    <td><a href="{{ route('panel.invoices.edit', ['invoice' => $invoice->id]) }}">Edit</a></td>
                </tr>
            @empty
                <tr>
                    <th colspan="6">No invoices</th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
