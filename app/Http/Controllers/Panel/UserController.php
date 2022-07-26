<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Rules\ValidMobileNumber;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:change_profiles_data'])->only(['setRoles']);
    }

    public function setRoles($user_id, Request $request)
    {
        $user = User::findOrFail($user_id);
        $validator = Validator::make($request->all(), [
            'roles.*' => ['numeric'],
        ]);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $roles = $request->has('roles') ? $request->input('roles') : [];
        $user->roles()->sync($roles);
        return setSuccessfulResponse('reload');
    }
}
