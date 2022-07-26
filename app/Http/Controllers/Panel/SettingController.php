<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Setting;
use Facades\App\Libraries\SettingHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SettingHelper::getSettings();
        return view('panel.main')->nest('content', 'panel.settings', compact('settings'));
    }

    public function save(Request $request)
    {
        // TODO[back-end]: validate fields, this is temporary
        $validator = Validator::make($request->all(), [
            'site_title' => 'string',
            'site_short_title' => 'string',
            'vat_percentage' => 'numeric',
        ]);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only([
            'site_title',
            'site_short_title',
            'vat_percentage',
        ]);

        $data['register_temp_user'] = $request->has('register_temp_user');
        $data['user_can_skip_profile_questions'] = $request->has('user_can_skip_profile_questions');
        $data['user_must_pay_without_answering_diet_required_questions'] = $request->has('user_must_pay_without_answering_diet_required_questions');
        $data['user_can_pay_without_answering_diet_required_questions'] = $request->has('user_can_pay_without_answering_diet_required_questions');
        $data['vat_visibility_is_invoice'] = $request->has('vat_visibility_is_invoice');
        $save = Setting::first()->update($data);
        // update settings cache
        SettingHelper::getSettings(true);
        return setSuccessfulResponse(route('panel.settings.show'));
    }
}
