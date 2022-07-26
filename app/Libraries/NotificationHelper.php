<?php


namespace App\Libraries;


class NotificationHelper
{
    public function translateNotification($notification, $area = 'dashboard')
    {
        switch ($notification->type) {
            case 'App\Notifications\OrderCompleted':
                $route = ($area == 'dashboard') ? "dashboard.orders.show" : "panel.orders.edit";
                $url = route($route, ['order' => $notification->data['order_id']]);
                $text = __('notification.order_completed', [
                    'diet' => $notification->data['diet_title'],
                    'period' => $notification->data['selected_period']['period'],
                ]);
                break;
            case 'App\Notifications\OrderCreated':
                $route = ($area == 'dashboard') ? "dashboard.orders.show" : "panel.orders.edit";
                $url = route($route, ['order' => $notification->data['order_id']]);
                $text = __('notification.order_created', [
                    'diet' => $notification->data['diet_title'],
                    'period' => $notification->data['selected_period']['period'],
                ]);
                break;
            case 'App\Notifications\OfflinePaymentVerified':
                $route = ($area == 'dashboard') ? "dashboard.invoices.show" : "panel.invoices.edit";
                $url = route($route, ['invoice' => $notification->data['invoice_id']]);
                $text = __('notification.offline_payment_verified');
                break;
            case 'App\Notifications\PendingInvoiceItem':
                $route = ($area == 'dashboard') ? "dashboard.invoices.show" : "panel.invoices.edit";
                $url = route($route, ['invoice' => $notification->data['invoice_id']]);
                $text = __('notification.pending_invoice_item');
                break;
            case 'App\Notifications\InvoicePaid':
                $route = ($area == 'dashboard') ? "dashboard.invoices.show" : "panel.invoices.edit";
                $url = route($route, ['invoice' => $notification->data['invoice_id']]);
                $text = __('notification.invoice_paid');
                break;
            default:
                $url = "";
                $text = $area == 'dashboard' ? "" : __($notification->type);
        }
        return (object)[
            'url' => $url,
            'text' => $text,
        ];
    }
}
