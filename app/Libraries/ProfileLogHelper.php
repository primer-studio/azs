<?php


namespace App\Libraries;


use App\Constants\ProfileLogConstants;
use App\ProfileLog;
use Illuminate\Support\Facades\Auth;

class ProfileLogHelper
{
    public function add($profile_id, $type, $model_type, $model_id, $data_type = null, $data = null, $short_message = null)
    {
        $performer_model_type = null;
        $performer_model_id = null;
        if (Auth::guard('admin')->check()) {
            $performer_model_type = "App\Admin";
            $performer_model_id = Auth::guard('admin')->user()->id;
        }
        if (is_null($performer_model_type) && Auth::guard('web')->check()) {
            $performer_model_type = "App\Profile";
            $performer_model_id = \Facades\App\Libraries\ProfileHelper::getCurrentProfile()->id;
        }

        switch ($data_type) {
            case 'array':
                $data = json_encode($data);
                break;
            case 'object':
                $data = json_encode($data);
                break;
            case 'string':
                $data = $data;
                break;
        }

        ProfileLog::create([
            'profile_id' => $profile_id,
            'type' => $type,
            'short_message' => $short_message,
            'model_type' => $model_type,
            'model_id' => $model_id,
            'data_type' => $data_type,
            'data' => $data,
            'performer_model_type' => $performer_model_type,
            'performer_model_id' => $performer_model_id
        ]);
    }

    public function getTranslated($profile_id)
    {
        $logs = ProfileLog::where([
            'profile_id' => $profile_id
        ])
            ->with('performer')
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')->get();
        foreach ($logs as $log) {
            $sentence_parts = [];
            switch ($log->type) {
                case ProfileLogConstants::TYPE_CREATED :
                    $sentence_parts[] = __("general.create");
                    break;
                case ProfileLogConstants::TYPE_UPDATED :
                    $sentence_parts[] = __("general.update");
                    break;
                case ProfileLogConstants::TYPE_UPDATE_REQUESTED :
                    $sentence_parts[] = __("general.request") . " " . __("general.update");
                    break;
                default :
                    $sentence_parts[] = $log->type;
                    break;
            }

            switch ($log->model_type) {
                case "App\Profile":
                    $sentence_parts[] = __("general.profile");
                    break;
                case "App\Invoice":
                    $sentence_parts[] = '<a class="mx-1" href="' . route('panel.invoices.edit', ['invoice' => $log->model_id]) . '" target="_blank">' . __('general.invoice') . '</a>';;
                    break;
                case "App\Order":
                    $sentence_parts[] = '<a class="mx-1" href="' . route('panel.orders.edit', ['order' => $log->model_id]) . '" target="_blank">' . __('general.order') . '</a>';;
                    break;
                case "App\CartItem":
                    $sentence_parts[] = __("general.cart_item");
                    break;
                default:
                    $sentence_parts[] = $log->model_type;
            }
            $sentence_parts[] = __("general.by");

            switch ($log->performer_model_type) {
                case "App\Admin":
                    $sentence_parts[] = '<a class="mx-1" href="' . route('panel.admins.edit', ['admin' => $log->performer_model_id]) . '" target="_blank">' . __('general.admin') . (!empty($log->performer->name) ? " (" . $log->performer->name . ")" : "") . '</a>';
                    break;
                case "App\Profile":
                    $sentence_parts[] = '<a class="mx-1" href="' . route('panel.profiles.edit', ['profile' => $log->performer_model_id]) . '" target="_blank">' . __('general.profile') . '</a>';
                    break;
                case null:
                    $sentence_parts[] = __('general.system');
                    break;
                default:
                    $sentence_parts[] = $log->performer_model_type;
            }
            $log->translated_message = implode(" ", $sentence_parts);
        }
        return $logs;
    }
}
