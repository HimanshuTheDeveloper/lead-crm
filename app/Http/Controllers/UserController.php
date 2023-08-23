<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }
    public function add_users()
    {
        $roles = Role::all();
        return view('users.add-user')->with(compact('roles'));
    }
    public function edit_users($id)
    {
        $roles = Role::all();
        $user_role = DB::table('users_roles')->where('user_id',$id)->first();
        $role= Role::find($user_role->role_id);
        $user = User::find($id);
        $user['role'] = $role;
        return view('users.edit-user')->with(compact('user','roles'));
    }
    public function save_users(Request $request)
    {
        // return "hello";
        $rules = [
            'name'            => 'required',
            'email'           => 'required',
            'phone'           => 'required',
            'status'          => 'required',
            'profile_image'   => 'required',
            'role'            => 'required',
        ];

        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $user = new User();
            if ($request->hasFile('profile_image')) {
                $destinationPath = public_path() . '/images/users/';
                $filename = $request->file('profile_image')->getClientOriginalName();
                $request->file('profile_image')->move($destinationPath, $filename);
            } 

            $user_role = Role::find($request->role);
    
            $data = [
                'name'          =>      $request->name,
                'email'         =>      $request->email,
                'phone'         =>      $request->phone,
                'profile_image' =>      $filename,
                'status'        =>      $request->status,
                'role'        =>        $user_role->slug, 
                'password'      =>      bcrypt($request->password),
            ];
            $insert = $user->insert($data);
            $lastInsertedData = User::orderBy('id','desc')->first(); 
            DB::table('users_roles')->insert(
                ['user_id' => $lastInsertedData->id, 'role_id' => $request->role]
            );
            if ($insert) {
                return response()->json(array('status' => true,  'location' => route('admin.users'),   'msg' => 'User created successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }

    public function user_list(Request $request)
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

        $total = User::select('users.*')
        ->Where(function ($query) use ($search) {
            $query->orWhere('users.name', 'like', $search . '%');
            $query->orWhere('users.email', 'like', $search . '%');
            $query->orWhere('users.phone', 'like', $search . '%');
            $query->orWhere('users.role', 'like', $search . '%');
            $query->orWhere('users.status', 'like', $search . '%');
        });
        
        $total= $total->count();

        $users = User::select('users.*')
            ->Where(function ($query) use ($search) {
                $query->orWhere('users.name', 'like', $search . '%');
                $query->orWhere('users.email', 'like', $search . '%');
                $query->orWhere('users.phone', 'like', $search . '%');
                $query->orWhere('users.role', 'like', $search . '%');
                $query->orWhere('users.status', 'like', $search . '%');
            });
        $users = $users->orderBy('id', $orderType )->limit($limit)->offset($ofset)
            ->get();

        $i = 1 + $ofset;
        $data = [];

        foreach ($users as $key => $user) {

            $user_role = DB::table('users_roles')->where('user_id',$user->id)->first();
            if($user_role){
                $role= Role::find($user_role->role_id);
            }
          
            $action = '<a href="' . route('admin.edit_users', $user->id) . '" class="px-3 py-2 rounded btn-sm bg-info mb-2 text-white" id="editUser"><i class="fas fa-edit"></i></a> <button class="px-3 py-1 rounded btn-sm  btn-danger DeleteUser" id="DeleteUser" data-id="' . $user->id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            $data[] = array(
                '<img class=" rounded-circle text-center" style="height:60px; width:60px;" src="' . asset('/public/images/users/' . $user->profile_image) . '" alt="No image">',
                $user->name,
                $user->email,
                $user->phone,
                $role ? $role->name : "",
                $user->status,
                $action,
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function update_users(Request $request)
    {
        $rules = [
            'user_id' => 'required',
        ];

        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $user = User::find($request->user_id);
            if ($request->hasFile('profile_image')) {
                $destinationPath = public_path() . '/images/users/';
                $filename = $request->file('profile_image')->getClientOriginalName();
                $request->file('profile_image')->move($destinationPath, $filename);
            } 
            else {
                $filename = $user->profile_image;
            }

            $user_role = Role::find($request->role);
           
            $data = [
                'name'          =>      $request->name,
                'email'         =>      $request->email,
                'phone'         =>      $request->phone,
                'profile_image' =>      $filename,
                'role'          =>      $user_role->slug,
                'status'        =>      $request->status,
            ];
            $request->password ? $data['password'] = bcrypt($request->password): "";
            $insert = $user->update($data);
            $roleAssign = DB::table('users_roles')->where('user_id',$request->user_id)->update(array('role_id' => $request->role));;
            if ($insert) {
                return response()->json(array('status' => true,  'location' => route('admin.users'),   'msg' => 'User updated successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }

    public function user_delete(Request $request)
    {
        $data = DB::table('users_roles')->where('user_id',$request->id);
        if($data){
            $data->delete();
        }
        $delete = User::where('id', $request->id)->delete();
        if ($delete) {
            return response()->json(['status' => true, 'msg' => "User Deleted Successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error Occurred, Please try again"]);
            exit;
        }
    }
}
