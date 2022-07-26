<?php


namespace App\Libraries;


use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Facades\App\Libraries\ProfileHelper;

class TempProfileHelper
{
    protected $_request;

    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    public function shouldBeRedirected()
    {
        // if there is not mtp parameter in URL and user is already logged-in, redirect him to home
        return (!$this->_request->has('mtp') && Auth::check());
    }

    public function redirectToHome()
    {
        return redirect(RouteServiceProvider::HOME);
    }

    public function moveTempProfileIfPossible($user)
    {
        if (Auth::check()) {
            $current_user = Auth::user();

            if (!$current_user->is_temp) {
                return false;
            }

            if ($current_user->id == $user->id) {
                return false;
            }
            if ($this->_request->has('mtp') && !empty($this->_request->input('mtp'))) {
                $mtp = $this->_request->input('mtp');
                $decoded_mtp = json_decode(decrypt(urldecode($mtp)));
                if (!empty($decoded_mtp->profile_id_to_move) || !empty($decoded_mtp->temp_user_id)) {
                    $current_profile = ProfileHelper::getCurrentProfile();
                    // check if the the decoded data corresponds with the current user and current profile
                    if ($decoded_mtp->profile_id_to_move == $current_profile->id && $decoded_mtp->temp_user_id == $current_user->id) {
                        // move the current profile to the logged-in user
                        ProfileHelper::updateCurrrentProfile([
                            'user_id' => $user->id
                        ]);
                        // remove the old temp user
                        User::find($current_user->id)->delete();
                    }
                }
            }
            Auth::logout();
        }
    }

    public function canCompleteCurrentTempProfile()
    {
        return ($this->_request->has('mtp') && Auth::check());
    }
}
