<?php

namespace App\Http\Controllers\Panel;

use App\Events\RoleStoredEvent;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public $saveRequestInputs = [
        'name',
    ];

    public $rules = [
        'name' => 'required|string|max:255',
    ];

    public function __construct()
    {
        $this->middleware(['can:change_profiles_data']);
    }

    public function create()
    {
        return view('panel.main')->nest('content', 'panel.roles.set');
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return view('panel.main')->nest('content', 'panel.roles.set', compact('role'));
    }

    public function index()
    {
        $roles = Role::where('guard_name', 'web')->with('permissions')->paginate(10);
        return view('panel.main')->nest('content', 'panel.roles.list', compact('roles'));
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
        return setSuccessfulResponse(route('panel.roles.edit', ['role' => $role->id]));
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
        $data['guard_name'] = 'web';
        $role = Role::create($data);
        $permissions = $request->has('permissions') ? $request->input('permissions') : [];
        $role->permissions()->sync($permissions);
        // event(new RoleStoredEvent($role));
        return setSuccessfulResponse(route('panel.roles.edit', ['role' => $role->id]));
    }
}
