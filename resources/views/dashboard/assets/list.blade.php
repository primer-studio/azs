{{--this module extended from diets\list file. fill free to use templates from.--}}
<style>
    .select-items {
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }
    .filepond--drop-label {
        font-family: 'iranyekan' !important;
    }
    .filepond {
        box-shadow: rgb(30 30 30 / 20%) 0px 8px 24px;
        border: 1px solid #ededed;
        border-radius: 10px;
    }
</style>

<div class="w-100 whiteBackColor w-100 border-radius-10 question-box-pay px-4 pt-4 pb-3 mt-4">
    <header class="w-100 mb-3 d-flex align-items-center">
        <span class="redColor w-25">افزودن فایل</span>
        <div class="line w-75 h-2 mr-3 bg-custom-grey"></div>
    </header>
    <input type="file" class="filepond" style="visibility: hidden" name="asset" id="asset">

    <div class="w-100" style="text-align: right; margin-top: 6%">
        <div style="
                                        background: #ffc700;
                                        /*background: #f1416c;*/
                                        padding: 1.25rem !important;
                                        border-radius: 3px;
                                        color: white;
                                        font-weight: 800;
                                        /*width: 70%;*/
                                        margin-bottom: 2%;
                                    " class="font-size-14 boldFont">
{{--            <span class="icon icon-danger font-size-16 rightFloat" style="margin-left: 3%"></span>--}}
            <p>۱- تنها مجاز به ارسال فیلم و عکس می‌باشید.</p>
            <p>۲- حداکثر حجم مجاز آپلود ۱۰ مگ می‌باشد.</p>
            <p>۳- سطح دسترسی فایل‌ها بصورت خودکار بر روی مخفی تنظیم شده است، به این معنی که هیچ کس جز خود شما دسترسی به آن ندارد.</p>
            <p>۴- سطح دسترسی محافظت شده تنها برای پشتیبان رژیم شما نمایان خواهد شد.</p>
            <p>۵- سطح دسترسی عمومی به تمام افرادی که رژیم منتسب شده به فایل را ثبت‌نام کرده باشند، نمایش داده خواهد شد.</p>
        </div>

    </div>
</div>


@if(count($assets))
    @foreach($assets as $asset)
        @if(!isset($asset->getInfo()->deleted))
            @php
                $prefix = time();
            @endphp
            <div class="d-flex align-items-center flex-wrap w-100 justify-content-between {{--div-alert-diets-support--}} whiteBackColor w-100 border-radius-10 question-box-pay px-4 pt-4 pb-3 mt-4">
                <div class="d-flex align-items-center justify-content-center align-content-center flex-wrap position-relative">
                    @if(strpos($asset->getType(), 'video') !== false)
                        <video style="border-radius: 10px; max-width: 320px; height: 240px" controls>
                            <source src="{{ $asset->getURL() }}" type="video/ogg">
                            <source src="{{ $asset->getURL() }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @elseif(strpos($asset->getType(), 'image') !== false)
                        <div style="border-radius: 10px; height: 240px; width: 320px; background: url('{{ $asset->getURL() }}'); background-position: center; background-repeat: no-repeat; background-size: cover">
                        </div>
                    @else

                    @endif
                </div>
                <div class="w-50">
                    <div class="mainQuestionBox organizer" style="margin-bottom: unset !important;">
                        <div class="questionInner d-flex">انتساب به رژیم</div>
                        <div class="answerContainer box-input custom-select custom-select-gender">
                            <select form="{{ $prefix.$asset->id }}" name="order" id="order" class="fullWidth input azshanbeInput">
                                {{--                        <option value="false">هیچ‌کدام</option>--}}
                                @foreach($orders as $order)
                                    <option value="{{ $order->id }}" @if($order->id == $asset->order_id) selected @endif>
                                        {{ $order->invoiceItem->diet_registered_data->title }} - {{ jdate($order->created_at, true, "F Y") }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="questionInner d-flex">سطح دسترسی</div>
                        <div class="answerContainer box-input custom-select custom-select-gender">
                            <select form="{{ $prefix.$asset->id }}" name="asset_visibility" id="asset_visibility" class="fullWidth input azshanbeInput">
                                <option value="private" @if($asset->asset_visibility == 'private') selected  @endif>مخفی</option>
                                <option value="protected" @if($asset->asset_visibility == 'protected') selected  @endif>محافظت شده</option>
                                <option value="public" @if($asset->asset_visibility == 'public') selected  @endif>عمومی</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="w-100" style="margin-top: 2%;">
                    <a onclick="confirmRemove(this, '{{ $prefix.$asset->id }}')" style="background: #f1416c;width: 45%; display: inline-block; margin: 0 5px; float: right; cursor: pointer; border-radius: 10px" class="d-flex align-items-center justify-content-center a-checkout">حذف</a>
                    <a onclick="doUpdate('{{ $prefix.$asset->id }}')" style="width: 45%; display: inline-block; margin: 0 5px; float: left; cursor: pointer; border-radius: 10px" class="d-flex align-items-center justify-content-center a-checkout">ذخیره</a>
                    <form action="{{ route('dashboard.assets', ['action' => 'update', 'id' => $asset->id]) }}" style="visibility: hidden" method="post" name="{{ $prefix.$asset->id }}" id="{{ $prefix.$asset->id }}">
                        @csrf
                        <input type="hidden" name="asset" value="{{ $asset->id }}">
                    </form>
                    <form action="{{ route('dashboard.assets', ['action' => 'delete', 'id' => $asset->id]) }}" style="visibility: hidden" method="post" name="d{{ $prefix.$asset->id }}" id="d{{ $prefix.$asset->id }}">
                        @csrf
                        <input type="hidden" name="asset" value="{{ $asset->id }}">
                    </form>
                </div>
            </div>
        @endif
    @endforeach
@else
    <div class="d-flex align-items-center flex-wrap w-100 justify-content-between {{--div-alert-diets-support--}} whiteBackColor w-100 border-radius-10 question-box-pay px-4 pt-4 pb-3 mt-4">
        <span class="span-alert w-100">
            فایلی یافت نشد.
        </span>
    </div>
@endif

<script>
    function doUpdate(id) {
        document.getElementById(id).submit();
    }
    function confirmRemove(item, id) {
        item.innerText = 'حذف فایل را تایید می‌کنید؟';
        item.setAttribute('onclick',"doRemove('d"+id+"')");
    }
    function doRemove(id) {

        document.getElementById(id).submit();
    }
</script>
