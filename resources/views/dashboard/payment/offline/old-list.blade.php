<div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">amount</th>
            <th scope="col">payment_date</th>
            <th scope="col">payment_type</th>
            <th scope="col">tracking_number</th>
            <th scope="col">is_verified</th>
        </tr>
        </thead>
        <tbody>

        @forelse($offline_payments as $offline_payment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $offline_payment->amount }}</td>
                <td>{{ $offline_payment->payment_date }}</td>
                <td>{{ $offline_payment->payment_type }}</td>
                <td>{{ $offline_payment->tracking_number }}</td>
                <td>{{ $offline_payment->is_verified }}</td>
            </tr>
        @empty
            <tr>
                <td>@lang('general.not_found')</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
