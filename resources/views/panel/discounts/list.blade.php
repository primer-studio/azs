<div class="kt-portlet">
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>عنوان</th>
                <th>کد تخفیف</th>
                <th>نوع</th>
                <th>وضعیت</th>
                <th>یکبار مصرف</th>
                <th>ویرایش</th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($discounts as $discount)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>
                        <a href="{{ route('panel.discounts.edit', ['id' => $discount->id]) }}">{{ $discount->title }}</a>
                    </td>
                    <td>{{ $discount->hash }}</td>
                    <td>@lang("general.{$discount->type}")</td>
                    <td>@if($discount->is_active) فعال @else غیرفعال @endif</td>
                        <td>@if($discount->is_otu) &#10003; @else &#215; @endif</td>
                    <td><a href="{{ route('panel.discounts.edit', ['id' => $discount->id]) }}">ویرایش</a></td>
                </tr>
            @empty
                <tr>
                    <th colspan="6">No Discounts</th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $discounts->links() }}
        </div>
    </div>
</div>
