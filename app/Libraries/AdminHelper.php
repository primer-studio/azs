<?php


namespace App\Libraries;


use App\Admin;
use Illuminate\Support\Facades\Hash;

class AdminHelper
{
    public function createAdmin(array $data)
    {
        // get just each field of these collection which isset
        $data_collection = collect($data)->only([
            'name',
            'email',
            'username',
            'password',
        ]);

        $data_collection['password'] = Hash::make($data_collection['password']);
        $admin = Admin::create($data_collection->toArray());
        return $admin;
    }
}
