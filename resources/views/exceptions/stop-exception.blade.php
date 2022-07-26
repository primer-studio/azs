<div class="voucherContainer container">

    <div class="smallPaddingSpace organizer relative">

        <div class="paymentBack mobileVersion">
            <img src="img/voucherBack.svg">
        </div>

        <div class="voucherFix">
            <div class="voucherDesktopWhiteBox">
                <div class="paymentTitle organizer textInCenter voucher">
                    <img src="img/report.svg">
                    <h2 class="font-size-24 boldFont redColor">مشکلی پیش آمد</h2>
                    @if(!empty($message))
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @endif
                </div>

                <div class="voucherActions textInCenter organizer">
                    <div class="paymentButton whiteColor  greenBackColor">
                        <span class="middleContext">
                            <a href="{{ route('dashboard.home') }}">خانه</a>
                        </span>
                        <span class="icon icon-home middleContext"></span>
                    </div>
                    <div class="paymentButton whiteColor blueBack">
                        <span class="middleContext">پیام به کارشناس</span>
                        <span class="icon icon-chat middleContext"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
