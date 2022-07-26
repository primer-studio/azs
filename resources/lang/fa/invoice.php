<?php
// TODO[fix-label]: fix label/message
return [
    /*
    |--------------------------------------------------------------------------
    | Invoice Messages
    |--------------------------------------------------------------------------
    |
    | The following language lines are the invoice messages which will be used
    | in whole project
    |
    */

    // statuses
    "TRANSACTION_STARTED" => "ایجاد شده",
    "TRANSACTION_WEB_GATE" => "هدایت شده به درگاه پرداخت",
    "TRANSACTION_CALLBACK" => "بازگشته از درگاه بانکی - در انتظار تایید",
    "TRANSACTION_VERIFIED" => "پرداخت موفق",
    "TRANSACTION_AMOUNT_MISMATCH_ON_VERIFY" => "مغایرت مبلغ پرداخت شده با مبلغ فاکتور",
    "TRANSACTION_VERIFY_DATA_NOT_CORRECT" => "خطا هنگام تایید تراکنش",
    "TRANSACTION_CALLBACK_DATA_NOT_CORRECT" => "اطلاعات برگشتی نادرست از درگاه بانک",

    // messages
    "status_change_confirm" => "در صورتی که وضعیت را به پرداخت موفق تغییر دهید، یک سفارش جدید ثبت می شود و تحت هیچ شرایطی امکان تغییر وضعیت وجود نخواهد داشت.",
    "invoice_item_pending_profile_information" => "در انتظار تکمیل پروفایل: :pending_questions",
    "invoice_item_pending_check_status" => "در انتظار تکمیل پروفایل: :pending_questions",
    "order_as_been_registered_before" => "سفارش قبلا ثبت شده است",
    "order_registered" => "سفارش ثبت شد",
    "invoice_is_not_paid" => "صورتحساب پرداخت نشده است",
    "offline_payment_info" => "اطلاعات پرداخت آفلاین",
    "online_payment_info" => "اطلاعات پرداخت آنلاین",
    "payment_type" => "روش پرداخت",
    "ipg" => "پرداخت آنلاین",
    "offline" => "پرداخت آفلاین",
    "manual_by_admin" => "تایید دستی ادمین",
    "payment_code" => "کد پرداخت",

];
