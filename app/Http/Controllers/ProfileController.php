<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('profile.index');
    }

    public function update_profiles(Request $request, User $user)
    {
        $rules = [
            'user_id' => 'required',
        ];

        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $user = User::findorFail($request->user_id);
            // $user = User::findorFail($request->id);
            if ($request->hasFile('profile_image')) {
                $destinationPath = public_path() . '/images/users/';
                $filename = $request->file('profile_image')->getClientOriginalName();
                $request->file('profile_image')->move($destinationPath, $filename);
            } 
            else {
                $filename = $user->profile;
            }
            $data = [
                'name'          =>      $request->name,
                'email'         =>      $request->email,
                'password'      =>      bcrypt($request->password),
                'phone'         =>      $request->phone,
                'profile_image' =>      $filename,
                'status'        =>      $request->status,
            ];
            $insert = $user->update($data);
            if ($insert) {
                return response()->json(array('status' => true,  'location' => route('user.dashboard'),   'msg' => 'Profile updated successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }
}
