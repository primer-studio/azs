<?php

use App\Constants\ErrorResponse;
use \App\Mail\ReportMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Carbon\Carbon;

if (!function_exists('generateRandomCode')) {

    function generateRandomCode()
    {
//        return rand(1000, 9999);
        $adapter = new \App\Http\Controllers\ThirdParty\SmsController();
        return $adapter->GenerateOTP();
    }
}

if (!function_exists('setSuccessfulResponse')) {
    function setSuccessfulResponse($redirect_to = '', $set_session_message = true, $message = '', $status = Response::HTTP_OK)
    {
        if ($set_session_message) {
            flashSuccessMessage((!empty($message) ? $message : xssClean(__('general.data_saved_successfully'))));
        }
        // TODO[back-end]: make this better
        return new JsonResponse([
            "status" => "success",
            "redirect_to" => $redirect_to,
            "message" => $message,
        ], $status);
    }
}

if (!function_exists('successfulDataResponse')) {
    function successfulDataResponse($data, $message = '', $status = Response::HTTP_OK)
    {
        // TODO[back-end]: make this better
        return new JsonResponse([
            "status" => "success",
            "data" => $data,
            "message" => $message,
        ], $status);
    }
}

if (!function_exists('setErrorResponse')) {
    function setErrorResponse($messages, $error_code = ErrorResponse::VALIDATION, $status = Response::HTTP_OK)
    {
        // TODO[back-end]: make this better
        return new JsonResponse([
            "status" => "failed",
            "error_code" => $error_code,
            "errors" => $messages,
        ], $status);
    }
}

if (!function_exists('flashError')) {
    function flashError($message)
    {
        $data = session()->has('flash_errors') ? session()->get('flash_errors') : [];
        $data[] = xssClean($message);
        session()->flash('flash_errors', $data);
    }
}


if (!function_exists('flashSuccessMessage')) {
    function flashSuccessMessage($message)
    {
        session()->flash('success', $message);
    }
}


use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

if (!function_exists('jdate')) {
    function jdate($input, $persian_numbers = true, $format = 'Y/m/d')
    {

        if (is_string($input)) {
            $input = Carbon::create($input);
        }
        $input = is_object($input) ? intval(strtotime($input->toDateTimeString())) : intval($input);
        $v = verta($input);
        $output = $v->format($format);
        if ($persian_numbers) {
            $output = toPersianDigit($output);
        }
        return $output;
    }
}

if (!function_exists('jdateComplete')) {
    function jdateComplete($input, $persian_numbers = true)
    {
        return jdate($input, $persian_numbers, "Y/m/d H:i");
    }
}

if (!function_exists('dateDiff')) {
    function dateDiff($input, $persian_numbers = true)
    {
        $input = is_object($input) ? $input : Carbon::createFromTimestamp(intval($input));
        $output = $input->diffForHumans();
        return $persian_numbers ? toPersianDigit($output) : $output;
    }
}

if (!function_exists('jdateToTimestamp')) {
    /**
     * you should validate $jalali_date before passing it to this function
     * @param $jalali_date
     * @param string $delimiter
     * @return string
     */
    function jdateToTimestamp($jalali_date, $delimiter = '/')
    {
        $exploded = explode($delimiter, $jalali_date);
        $v = verta();
        $v = $v->setDate($exploded[0], $exploded[1], $exploded[2]);
        return $v->timestamp;
    }
}

if (!function_exists('generateJalaliDateFromArray')) {
    /**
     * get jalali year, month, day in an array and stick them together and override request
     * @param $request
     * @param $name
     * @return null
     */
    function generateJalaliDateFromArray(&$request, $name)
    {
        $jalali_date_string = null;
        $validator = Validator::make($request->all(), [
            $name => "required|array",
            "$name.year" => "required|numeric",
            "$name.month" => "required|numeric",
            "$name.day" => "required|numeric"
        ]);

        if ($validator->fails()) {
            $request->merge([$name => $jalali_date_string]);
            return;
        }

        $jalali_date_array = $request->input($name);
        if (is_array($jalali_date_array)) {
            $jalali_date_string = $jalali_date_array['year'] . "/" . $jalali_date_array['month'] . "/" . $jalali_date_array['day'];
        }
        $request->merge([$name => $jalali_date_string]);
    }
}

if (!function_exists('toEnglishDigit')) {
    function toEnglishDigit($string)
    {
        $en_num = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $fa_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return str_replace($fa_num, $en_num, $string);
    }
}

if (!function_exists('toPersianDigit')) {
    function toPersianDigit($string)
    {
        $en_num = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $fa_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return str_replace($en_num, $fa_num, $string);
    }
}

if (!function_exists('convertArabicStringToPersian')) {
    function convertArabicStringToPersian($string)
    {
        $arabic = array('ي', 'ك', 'ة');
        $farsi = array('ی', 'ک', 'ه');
        return str_replace($arabic, $farsi, $string);
    }
}

if (!function_exists('hiReport')) {
    function hiReport($message, $exception = null)
    {
        $exception_message = !is_null($exception) ? $exception->getMessage() : "";
        $log_id = time() . uniqid();
        $request_uri = url()->current();
        Log::emergency('report', [
            'type' => 'report',
            'log_id' => $log_id,
            'report_message' => $message,
            'exception_message' => $exception_message,
            'request_uri' => $request_uri,
        ]);
        if ($exception instanceof \Exception) {
            // use laravel default report to save stacktrace
            report($exception);
        }
        Mail::send(new ReportMail($message, $exception_message, $log_id, $request_uri));
    }
}

if (!function_exists('money')) {
    function money($money, $convert_to_toman = true, $fa_chars = false)
    {
        $en = explode('-', '1-2-3-4-5-6-7-8-9-0');
        $fa = explode('-', '۱-۲-۳-۴-۵-۶-۷-۸-۹-۰');
        if ($convert_to_toman) {
            $money = $money / 10;
        }
//        return number_format($money, 0);
        $output = number_format($money, 0);
        return ($fa_chars) ? str_replace($en, $fa, $output) : $output ;
    }
}

if (!function_exists('xssClean')) {
    /*
     * XSS filter
     *
     * This was built from numerous sources
     * (thanks all, sorry I didn't track to credit you)
     *
     * It was tested against *most* exploits here: http://ha.ckers.org/xss.html
     * WARNING: Some weren't tested!!!
     * Those include the Actionscript and SSI samples, or any newer than Jan 2011
     *
     *
     * TO-DO: compare to SymphonyCMS filter:
     * https://github.com/symphonycms/xssfilter/blob/master/extension.driver.php
     * (Symphony's is probably faster than my hack)
     */

    function xssClean($data)
    {
        // Fix &entity\n;
        $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);

        // we are done...
        return $data;
    }
}

if (!function_exists('StripHtmlEntities')) {
    function StripHtmlEntities($data)
    {
        // Fix html entities like &nbsp;
        $should_remove = [
            '&nbsp;'
        ];
        $data = str_replace($should_remove, '', $data);
        $data = trim($data, ' ');
        return $data;
    }

}
