<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    //
    public function index()
    {
        // $roles = Role::orderby('name', 'asc')->get();
        return view('roles.index');
    }

    public function add_role()
    {
        return view('roles.add-role');
    }
    public function edit_role($id)
    {
        $role = Role::find($id);
        return view('roles.edit-role')->with(compact('role'));
    }

    public function save_role(Request $request)
    {

        $rules = [
            'name' => 'c',
            'slug' => 'required',
        ];
        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $role = new Role();
            $role->name =   $request->name;
            $role->slug =   $request->slug;
            $inserted = $role->save();
            if ($inserted) {
                return response()->json(array('status' => true,  'location' => route('admin.roles'), 'msg' => 'Role created successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }

    public function update_role(Request $request)
    {
        $rules = [
           'id' => 'required',
        ];
        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $role = Role::find($request->id);
            $role->name =   $request->name;
            $role->name =   $request->slug;
            $updated = $role->update();
            if ($updated) {
                return response()->json(array('status' => true, 'location' => route('admin.roles'), 'msg' => 'Role updated successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }
    
    public function roles_list(Request $request)
    {
        if (isset($request->search['value'])) {
            $search = $request->search['value'];
        } else {
            $search = '';
        }
        if (isset($request->length)) {
            $limit = $request->length;
        } else {
            $limit = 10;
        }
        if (isset($request->start)) {
            $ofset = $request->start;
        } else {
            $ofset = 0;
        }
        $orderType = $request->order[0]['dir'];
        $nameOrder = $request->columns[$request->order[0]['column']]['name'];

        $total = Role::all()->count();

        $roles = Role::select('roles.*')
        ->Where(function ($query) use ($search) {
            $query->orWhere('roles.name', 'like', $search . '%');
            $query->orWhere('roles.slug', 'like', $search . '%');
        }
    );
            $roles = $roles->orderBy('roles.id',$orderType)->limit($limit)->offset($ofset)
            ->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($roles as $key => $role) {

            $action = '<a href="' . route('admin.edit_role', $role->id) . '" class="px-3 py-2 rounded btn-sm bg-info mb-2 text-white" id="editUser"><i class="fas fa-edit"></i></a> <button class="px-3 py-1 rounded btn-danger" id="DeleteRole" data-id="' . $role->id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            $data[] = array(
                $role->name,
                $role->slug, // $category->parent_name->category_name,
                $action,
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }


    public function role_delete(Request $request)
    {
        $delete = Role::where('id', $request->id)->delete();
        if ($delete) {
            return response()->json(['status' => true, 'msg' => "Role Deleted Successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error Occurred, Please try again"]);
            exit;
        }
    }


 
}
