<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ClientController extends Controller
{
    public function index()
    {
        return view('clients.index');
    }
    public function add_clients()
    {
        $countries = Country::all();
        $users = User::where("id" , "!=", Auth::user()->id)->get();
        return view('clients.add-client',compact('countries' , 'users'));
    }
    public function edit_clients($id)
    {
        $client = Client::find($id);
        $countries=country::all();
      
        return view('clients.edit-client')->with(compact('client','countries'));
    }
    public function save_clients(Request $request)
    {
      
        $rules = [
            'name'    =>'required',
            'email'   =>'unique:clients,email',
            'country' =>'required',
            'state'   =>'required',
        ];

        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $client = new Client();
            $state = $request->state ==  'Select State' ? " " : $request->state;

            if(Auth::user()->role == "admin"){
                $request->created_by != "none" ?  $created_by = $request->created_by : $created_by = Auth::user()->id;   
            }else{
                $created_by = Auth::user()->id;
            }

            $data = [
                'name'       => $request->name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'country'    => $request->country,
                'state'      => $state,
                'address'    => $request->address,
                'gst_no'     => $request->gst_no,
                'remarks'    => $request->remarks,
                'created_by' =>  $created_by ,
            ];
            $insert = $client->insert($data);
            if ($insert) {
                return response()->json(array('status' => true,  'location' => route('admin.clients'),   'msg' => 'Client created successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }
    public function client_list(Request $request)
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

        $bdmUser = false;
        $bdeUser = false;

        foreach(Auth::user()->roles as $role){
            if($role->slug == "bdm")
            {
                $bdmUser = true;
            }
            if($role->slug == "bde")
            {
                $bdeUser = true;
            }
        }
        $total =  Client::select('clients.*','users.name as username', 'users.status')
        ->join('users', 'clients.created_by', '=', 'users.id')
        ->Where(function ($query) use ($search) {
                $query->orWhere('clients.name', 'like', '%'.$search . '%');
                $query->orWhere('clients.email', 'like', $search . '%');
                $query->orWhere('clients.phone', 'like', $search . '%');
                $query->orWhere('clients.country', 'like', $search . '%');
                $query->orWhere('clients.state', 'like', $search . '%');
                $query->orWhere('clients.address', 'like', $search . '%');
                $query->orWhere('clients.gst_no', 'like', $search . '%');
                $query->orWhere('users.name', 'like', $search . '%');
                $query->orWhere('clients.remarks', 'like', $search . '%');
            });
            if($bdmUser){
                $total = $total->where('clients.created_by', '!=' , 1);
            }
            if($bdeUser){
                $total = $total->where('clients.created_by', Auth::user()->id);
            }
            $total = $total->where('users.status', 'ACTIVE')->count();


        $clients = Client::select('clients.*' , 'users.name as username' , 'users.status')
            ->join('users', 'clients.created_by', '=', 'users.id')
            ->Where(function ($query) use ($search) {
                $query->orWhere('clients.name', 'like', $search . '%');
                $query->orWhere('clients.email', 'like', $search . '%');
                $query->orWhere('clients.phone', 'like', $search . '%');
                $query->orWhere('clients.country', 'like', $search . '%');
                $query->orWhere('clients.state', 'like', $search . '%');
                $query->orWhere('clients.address', 'like', $search . '%');
                $query->orWhere('clients.gst_no', 'like', $search . '%');
                $query->orWhere('users.name', 'like', $search . '%');
                $query->orWhere('clients.remarks', 'like', $search . '%');
            });
            if($bdmUser){
                $clients = $clients->where('clients.created_by', '!=' , 1);
             }
            if($bdeUser){
                $clients = $clients->where('clients.created_by', Auth::user()->id);
             }
             
        $clients = $clients->where('users.status', 'ACTIVE')->orderBy('id',$orderType)->limit($limit)->offset($ofset)
            ->get();

        $i = 1 + $ofset;
        $data = [];

        foreach ($clients as $key => $client) {

            $block = "";
            if($bdmUser){
                $block = $client->created_by != Auth::user()->id ? "d-none" : "";
            }

            $user = User::find($client->created_by);
            $action = '<a href="' . route('admin.edit_clients', $client->id) . '"class=" px-3 py-2 bg-info mb-2 text-white" id="editClient"><i class="fas fa-edit"></i></a>
             <button class="  px-3 py-1 btn-danger DeleteClient '.$block .'" id="DeleteClient" data-id="' . $client->id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            $data[] = array(
                // '<img class="card-img-top" src="' . asset('/public/profile/user/' . $user->profile) .'" alt="Image Not Found">',
                $client->name,
                $client->email,
                $client->phone,
                $client->country,
                $client->state,
                $client->address,
                $client->gst_no,
                $user->name,
                $client->remarks,
                $action,
            );
        }
        $records['recordsTotal'] =$total;
        $records['recordsFiltered'] =$total;
        $records['data'] = $data;
        echo json_encode($records);
    }
    

  public function update_clients(Request $request)
    {
        $rules = [
            'clients_id' => 'required',
        ];

        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $client = Client::find($request->clients_id);
            // $state = $request->state ==  'Select State' ? " " : $request->state;
            $data = [
                'name'    =>$request->name,
                'email'   =>$request->email,
                'phone'   =>$request->phone,
                'country' =>$request->country,
                'state'   =>$request->state,
                'address' =>$request->address,
                'gst_no'  =>$request->gst_no,
            //   'created_by'=>$request->created_by,
                'remarks' =>$request->remarks,
            ];
            // return $data;
            $insert = $client->update($data);
            if ($insert) {
                return response()->json(array('status' => true,  'location' => route('admin.clients'),'msg' => 'Client updated successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }

    public function client_delete(Request $request)
    {
        // return $request->all();
        $delete = Client::where('id', $request->id)->delete();
        if ($delete) {
            return response()->json(['status' => true, 'msg' => "Client Deleted Successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg'=> "Error Occurred, Please try again"]);
            exit;
        }
        // return $delete;
    }

}
