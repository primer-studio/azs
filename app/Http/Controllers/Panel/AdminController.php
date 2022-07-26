<?php

namespace App\Http\Controllers\Panel;

use App\Events\AdminUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Admin;
use App\Rules\StrongPassword;
use Facades\App\Libraries\AdminHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // TODO[back-end]: add the remaining fields
    public $saveRequestInputs = [
        'name',
        'email',
        'password',
    ];


    public function index(Request $request)
    {
        $admins = Admin::orderBy("created_at", "DESC")->paginate(20);
        return view('panel.main')->nest('content', 'panel.admins.list', compact('admins'));
    }

    public function create()
    {
        return view('panel.main')->nest('content', 'panel.admins.set');
    }

    public function edit($admin_id)
    {
        $admin = Admin::findOrFail($admin_id);
        return view('panel.main')->nest('content', 'panel.admins.set', compact('admin'));
    }

    public function update($admin_id, Request $request)
    {
        $admin = Admin::findOrFail($admin_id);
        $rules = [
            'email' => ['email'],
            'name' => ['required', 'max:200', 'min:3'],
            "password" => [
                'nullable',
                new StrongPassword()
            ]
        ];
        if ($request->has("email")) {
            if ($admin->email != $request->input('email')) {
                $rules['email'][] = 'required';
                $rules['email'][] = 'unique:admins';
            }
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        if ($request->has('password') && !empty($request->input('password'))) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $admin->update($data);

        // set roles
        $roles = $request->has('roles') ? $request->input('roles') : [];
        $admin->roles()->sync($roles);

        $redirect_url = route('panel.admins.edit', ['admin' => $admin->id]);
        return setSuccessfulResponse($redirect_url);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'unique:admins', 'email'],
            'name' => ['required', 'max:200', 'min:3'],
            "password" => [
                'required',
                new StrongPassword()
            ]
        ]);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        $admin = AdminHelper::createAdmin($data);

        // set roles
        $roles = $request->has('roles') ? $request->input('roles') : [];
        $admin->roles()->sync($roles);

        $redirect_url = route('panel.admins.edit', ['admin' => $admin->id]);
        return setSuccessfulResponse($redirect_url);
    }
}
