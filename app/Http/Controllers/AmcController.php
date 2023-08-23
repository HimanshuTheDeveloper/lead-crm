<?php

namespace App\Http\Controllers;

use App\Models\Amc;
use App\Models\Client;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AmcController extends Controller
{
    //
    function generateUniqueCode() {
        // BYTEAMC-  8 char
        $amc_code = Amc::orderBy('amc_id', 'desc')->first();
        if($amc_code){
            $number = substr($amc_code->amc_id,8);
            $number = (int)$number + 1;
            $new_code = "BYTEAMC-". $number;
        }else{
            $new_code = "BYTEAMC-1"; 
        }
        return $new_code;
    }
    function uniqueCodeExists($number) {
        return Amc::where('amc_id',$number)->exists();
    }
    public function index()
    {
        return view('amc.index');
    }
    public function add_amc()
    {
        $amc_id = $this->generateUniqueCode();
        $clients = Client::all();
        $currencies = Currency::all();
        return view('amc.add-amc')->with(compact('clients','amc_id','currencies'));
    }
    public function edit_amc($id)
    {
        $clients = Client::all();
        $currencies = Currency::all();
        $amc = Amc::find($id);
        return view('amc.edit-amc')->with(compact('clients','amc','currencies'));
    }

    public function save_amc(Request $request)
    {
        // return  $request->all();
        $rules = [
            'amc_id'                =>'required',
            'amc_end_date'          =>'required',
            'amc_start_date'        =>'required',
            'amount'                =>'required',
            'client'                =>'required',
            'currency'              =>'required',
            'domain_name'           =>'required',
        ];

        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $amc = new Amc();
       
            $data = [
                'amc_id'                =>          $request->amc_id,
                'amc_end_date'          =>          $request->amc_end_date,
                'amc_start_date'        =>          $request->amc_start_date,
                'amount'                =>          $request->amount,
                'client_fk_id'          =>          $request->client,
                'currency'              =>          $request->currency,
                'domain_name'           =>          $request->domain_name,
                'remarks'               =>         $request->remarks,
                'created_by'            =>         Auth::user()->id,
            ];
            $insert = $amc->insert($data);
            if ($insert) {
                return response()->json(array('status' => true,  'location' => route('admin.amc'),   'msg' => 'AMC created successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }
    public function update_amc(Request $request)
    {
        // return  $request->all();

        $rules = [
            'id'     => 'required',
            'amc_id' =>  'required'
         ];

        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $amc = Amc::find($request->id);
       
            $data = [
                'amc_id'                =>          $request->amc_id,
                'amc_end_date'          =>          $request->amc_end_date,
                'amc_start_date'        =>          $request->amc_start_date,
                'amount'                =>          $request->amount,
                'client_fk_id'          =>          $request->client,
                'currency'              =>          $request->currency,
                'domain_name'           =>          $request->domain_name,
                'remarks'               =>         $request->remarks,
            ];
            $updated = $amc->update($data);
            if ($updated) {
                return response()->json(array('status' => true,  'location' => route('admin.amc'),   'msg' => 'AMC Updated successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }
    
    public function amc_list(Request $request)
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

        $total = Amc::select('amcs.*','currencies.Currency', 'clients.name', 'clients.email' ,'users.name as created_by_name' , 'users.status')
        ->join('currencies', 'currencies.id', '=', 'amcs.currency')
        ->join('clients', 'clients.id', '=', 'amcs.client_fk_id')
        ->join('users', 'amcs.created_by', '=', 'users.id')

        ->Where(function ($query) use ($search) {
            
            $query->orWhere('amcs.amc_id', 'like', '%'.$search . '%');
            $query->orWhere('amcs.domain_name', 'like', $search . '%');
            $query->orWhere('amcs.amc_start_date', 'like', $search . '%');
            $query->orWhere('amcs.amc_end_date', 'like', $search . '%');
            $query->orWhere('amcs.amount', 'like', $search . '%');
            $query->orWhere('amcs.remarks', 'like', $search . '%');
            $query->orWhere('amcs.created_by', 'like', $search . '%');
            $query->orWhere('currencies.Currency','like', $search . '%');
            $query->orWhere('clients.name', 'like', $search . '%');
            $query->orWhere('clients.email', 'like', $search . '%');
            $query->orWhere('users.name', 'like','%'. $search . '%');
        });
        if($bdmUser){
            $total = $total->where('amcs.created_by', '!=' , 1);
        }
        if($bdeUser){
            $total = $total->where('amcs.created_by', Auth::user()->id);
        }
        $total = $total->where('users.status', 'ACTIVE')->count();
        

        $amcs = Amc::select('amcs.*' , 'amcs.id as am_id' ,'currencies.*','clients.name' ,'clients.email' ,'clients.id as client_id' ,'currencies.Currency', 'users.status','users.name as created_by_name')
            ->join('clients', 'clients.id', '=', 'amcs.client_fk_id')
            ->join('currencies', 'currencies.id', '=', 'amcs.currency')
            ->join('users', 'amcs.created_by', '=', 'users.id')
            ->Where(function ($query) use ($search) {
                $query->orWhere('amcs.amc_id', 'like','%'. $search . '%');
                $query->orWhere('amcs.domain_name', 'like', $search . '%');
                $query->orWhere('amcs.amc_start_date', 'like', $search . '%');
                $query->orWhere('amcs.amc_end_date', 'like', $search . '%');
                $query->orWhere('amcs.currency','like', $search . '%');
                $query->orWhere('amcs.amount','like', $search . '%');
                $query->orWhere('amcs.remarks','like', $search . '%');
                $query->orWhere('amcs.created_by','like', $search . '%');
                $query->orWhere('currencies.Currency','like', $search . '%');
                $query->orWhere('clients.name', 'like', $search . '%');
                $query->orWhere('users.name', 'like','%'. $search . '%');
                $query->orWhere('clients.email', 'like', $search . '%');
            });
            
            if($bdmUser){
                $amcs = $amcs->where('amcs.created_by', Auth::user()->id);
             }
            if($bdeUser){
                $amcs = $amcs->where('amcs.created_by', Auth::user()->id);
             }
        $amcs = $amcs->where('users.status', 'ACTIVE')->orderBy($nameOrder,$orderType)->limit($limit)->offset($ofset)->orderBy($nameOrder,$orderType)
            ->get();

        $i = 1 + $ofset;
        $data = [];

        foreach ($amcs as $key => $amc) {
            $user=User::find($amc->created_by);
            $action = '<a href="' . route('admin.edit_amc', $amc->am_id) . '" class="px-3 py-2 btn-sm bg-info mb-2 text-white" id="editClient"><i class="fas fa-edit"></i></a>
             <button class="px-3 btn-sm btn-danger DeleteClient" id="DeleteClient" data-id="' . $amc->am_id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            $anchor = '<a href="' . route('admin.edit_clients', $amc->client_id) . '"> '.$amc->name.' </a><br>';
             $data[] = array(
                $amc->amc_id,
                $anchor. $amc->email,
                $amc->domain_name,
                $amc->amc_start_date,
                $amc->amc_end_date,
                $amc->Currency,
                $amc->amount,
                $amc->remarks,
                $amc->created_by_name,
                $action,
            );
        }
        $records['recordsTotal'] =$total;
        $records['recordsFiltered'] =$total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function amc_delete(Request $request)
    {

        $delete = Amc::where('id', $request->id)->delete();
        if ($delete) {
            return response()->json(['status' => true, 'msg' => "AMC Deleted Successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg'=> "Error Occurred, Please try again"]);
            exit;
        }
    }
    

}
