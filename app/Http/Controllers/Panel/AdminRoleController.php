<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AdminRoleController extends Controller
{
    public $saveRequestInputs = [
        'name',
    ];

    public $rules = [
        'name' => 'required|string|max:255',
    ];



    public function create()
    {
        return view('panel.main')->nest('content', 'panel.admin-roles.set');
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return view('panel.main')->nest('content', 'panel.admin-roles.set', compact('role'));
    }

    public function index()
    {
        $roles = Role::where(['guard_name' => 'admin'])->with('permissions')->paginate(10);
        return view('panel.main')->nest('content', 'panel.admin-roles.list', compact('roles'));
    }

    public function update($role_id, Request $request)
    {
        $role = Role::findOrFail($role_id);
        // TODO[back-end]: validate fields, this is temporary
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }

        $permissions = $request->has('permissions') ? $request->input('permissions') : [];
        $role->permissions()->sync($permissions);

        $data = $request->only($this->saveRequestInputs);
        $role->update($data);
        // event(new RoleStoredEvent($role));
        return setSuccessfulResponse(route('panel.admin-roles.edit', ['admin_role' => $role->id]));
    }

    public function store(Request $request)
    {
        // TODO[back-end]: validate fields, this is temporary
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        $data['guard_name'] = 'admin';
        try {
            $role = Role::create($data);
        } catch (\Spatie\Permission\Exceptions\RoleAlreadyExists $exception) {
            return setErrorResponse(__('role-permission.role_already_exists'));
        } catch (\Exception $exception) {
            return setErrorResponse(__('general.problem_while_saving'));
        }
        $permissions = $request->has('permissions') ? $request->input('permissions') : [];
        $role->permissions()->sync($permissions);
        // event(new RoleStoredEvent($role));
        return setSuccessfulResponse(route('panel.admin-roles.edit', ['admin_role' => $role->id]));
    }
}
