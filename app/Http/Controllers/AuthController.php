<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function login()
    {
        return view('auth.signin');
    }
    
    public function login_submit(Request $request)
    {
        $rules = [
            'email'   => 'required',
            'password' => 'required|min:6'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('result' => false, 'msg' => $validator->errors()->first()));
        }
        $user = User::where('email', $request->email)->first();
        if($user->status == 'ACTIVE'){
            if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return json_encode(['status' => true, 'msg' => "Success, Welcome Back!", 'location' => route('user.dashboard')]);
                exit;
            } else {
                return response()->json(array('status' => false, 'msg' => "Credentials not matched !"));
                exit;
            }
        }
        return response()->json(array('status' => false, 'msg' => "Account is Inactive!"));
        exit;
    }


    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }

    public function reset_password(Request $request)
    {
        $rules = [
            'password' => 'required',
            'new_password' => 'min:6|required_with:new_password|different:password',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('result' => false, 'msg' => $validator->errors()->first()));
        } else {
            if (Hash::check($request->password, Auth::guard('web')->user()->password)) {
                $data = User::find(Auth::guard('web')->user()->id);
                $data->password = Hash::make($request->new_password);
                $result = $data->save();
                $msg = 'Password changed successfully.';
                $status = true;
            } else {
                $result = true;
                $msg = 'Current password does not match';
                $status = false;
            }
            if ($result) {
                return response()->json(array('status' => $status, 'msg' => $msg));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Password does not change.'));
            }
        }
    }
}
