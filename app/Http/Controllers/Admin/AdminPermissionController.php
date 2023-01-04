<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;

class AdminPermissionController extends Controller
{
    public function createPermissions()
    {
        return view('admin.permission.create');
    }

    public function store(Request $request)
    {
        $permission = Permission::create([
            'name'=>$request->module_parent,
            'display_name'=>$request->module_parent,
            'parent_id'=>0
        ]);

        foreach ($request->module_children as $value)
        {
            Permission::create([
                'name'=>$value,
                'display_name'=>$value,
                'parent_id'=>$permission->id,
                'key_code'=>$request->module_parent.'_'.$value
            ]);
        }
        return redirect()->back();

    }
}
