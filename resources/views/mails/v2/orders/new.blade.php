<?php
$invoice = \App\Invoice::findOrFail($backpack['invoice_id']);
$prefix = ($backpack['is_test']) ? 'تست توسعه - ' : null;
$backpack = [
    'type' => $invoice->invoiceItems[0]->diet->title,
    'user' => $invoice->profile->name,
    'order' => $invoice->profile->orders->take(1)->first(),
    'user_info_link' => route('panel.orders.edit', $invoice->profile->orders->take(1)->first()->id),
    'user_order_link' => route('panel.orders.index'),
]
?>
<html dir="rtl">
<head>
    <title>new order has been arrived.</title>
    <style>
        body {
            /*background-image: url(https://arbazargani.ir/assets/images/background.svg);*/
            /*background-repeat: no-repeat;*/
            /*background-position: right;*/
            /*background-size: cover;*/
            width: auto;
        }

        #main {
            /*width: 50%;*/
            max-width: 700px;
            margin: 1% auto;
            /*border: 1px solid gray;*/
            height: min-content;
            border-radius: 5px;
            /*box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 2px, rgba(0, 0, 0, 0.07) 0px 2px 4px, rgba(0, 0, 0, 0.07) 0px 4px 8px, rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 16px 32px, rgba(0, 0, 0, 0.07) 0px 32px 64px;*/
        }

        .card {
            background: white;
            border-radius: 5px;
            box-shadow: rgba(17, 17, 26, 0.1) 0px 4px 16px, rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px;
        }

        #head {
            /*background-image: url(https://arbazargani.ir/assets/images/background.svg);*/
            /*background-repeat: no-repeat;*/
            /*background-position: right;*/
            /*background-size: cover;*/
            background: #D1345B;
            color: white;
            margin: auto;
            padding: 3%;
            text-align: center;
            border-radius: 5px 5px 0px 0px;
            font-family: system-ui;
        }

        #head .under-title {
            color: lightblue;
            font-size: 12px;
            font-weight: 900;
            font-family: monospace;
        }

        p.order-details {
            font-weight: 700;
            font-size: 20px;
            color: #161616;
        }

        .order-details .order-detail-variable, a {
            /*font-weight: 900;*/
            color: #323377 !important;
        }

        #order-contents {
            padding: 2%;
        }

        #action-button-wrapper {
            width: 100%;
            margin: 50px auto 1%;
            text-align: center;
        }

        .action-button {
            width: 30%;
            font-size: 20px;
            font-weight: 900;
            color: white !important;
            background: #2ecc71;
            padding: 10px 13px;
            border-radius: 3px;
            text-decoration: unset;
            cursor: pointer;
            border: 1px solid #E8E8E8;

        }

        #time {
            margin: 2% auto;
            color: white;
            font-weight: 800;
            text-align: center;
            background: #1e2b37;
            padding: 2%;
            direction: ltr;
            font-family: Roboto;
            border-radius: 5px;
        }
    </style>
</head>

<body id="main">
<div class="card">
    <div id="head">
        <h2>{{ $prefix }} New Order - AZSHANBE.ME</h2>
        <p class="under-title">Admin Notification</p>
    </div>
    <div id="order-contents">
        <p class="order-details">نوع: <span class='order-detail-variable'> {{ $backpack['type'] }} </span></p>
        <p class="order-details">کاربر: <span class='order-detail-variable'> {{ $backpack['user'] }} </span></p>
        <p class="order-details">اطلاعات کاربر: <span class='order-detail-variable'> <a
                    href="{{ $backpack['user_info_link'] }}">{{ $backpack['user_info_link'] }}</a> </span></p>
        <div id="action-button-wrapper">
            <a href="{{ $backpack['user_order_link'] }}" target="_blank">
                <button class="action-button">مشاهده</button>
            </a>
        </div>
    </div>
</div>
<div id="time">
    <pre>{{ jdate(time(), false) }} - send by system</pre>
</div>
</div>
</body>
</html>
