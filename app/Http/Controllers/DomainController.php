<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Currency;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportDomain;
use App\Imports\ImportDomain;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    //

    public function index()
    {
        return view('domain.index');
    }

    public function add_domain()
    {
        $clients = Client::all();
        $currencies = Currency::all();
        return view('domain.add-domain')->with(compact("clients","currencies"));
    }

    // save_domain

    public function save_domain(Request $request)
    {
        $rules = [
            'expiry_date'             =>        'required',
            'domain_name'             =>        'required',
            'registration_date'       =>        'required',
            'amount'                  =>        'required',
            'client'                  =>        'required',
            'currency'                =>        'required',
            'registrar_details'       =>        'required',
            'remarks'                 =>        'required',
        ];
        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $domain = new Domain();
            $data =[
                'client_fk_id'         =>       $request->client,
                'expiry_date'          =>       $request->expiry_date,
                'registration_date'    =>       $request->registration_date,
                'domain_name'          =>       $request->domain_name,
                'registrar_details'    =>       $request->registrar_details,
                'currency'             =>       $request->currency,
                'amount'               =>       $request->amount,
                'remarks'              =>       $request->remarks,
                'status'               =>       $request->status,
                'created_by'           =>       Auth::user()->id,
            ];
            $insert = $domain->insert($data);
            if ($insert) {
                return response()->json(array('status' => true,  'location' => route('admin.domain'),'msg' => 'Domain created successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }
    
    public function domain_list(Request $request)
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
        $total = Domain::select('domains.*' ,'clients.name', 'clients.email' , 'users.status')
        ->join('clients', 'clients.id', '=', 'domains.client_fk_id')
        ->join('users', 'domains.created_by', '=', 'users.id')
        ->Where(function ($query) use ($search) {
            $query->orWhere('domains.domain_name', 'like', '%'.$search . '%');
            // $query->orWhere('domains.client_fk_id', 'like', $search . '%');
            $query->orWhere('domains.expiry_date', 'like', $search . '%');
            $query->orWhere('domains.registration_date', 'like', $search . '%');
            $query->orWhere('domains.registrar_details', 'like', $search . '%');
            $query->orWhere('domains.currency', 'like', $search . '%');
            $query->orWhere('domains.amount', 'like', $search . '%');
            $query->orWhere('domains.status', 'like', $search . '%');
            $query->orWhere('domains.remarks', 'like', $search . '%');
            $query->orWhere('domains.created_by', 'like', $search . '%');
            $query->orWhere('clients.name', 'like', $search . '%');
            $query->orWhere('clients.email', 'like', $search . '%');
            $query->orWhere('users.name', 'like','%'. $search . '%');

        });
        if($bdmUser){
            $total = $total->where('domains.created_by', Auth::user()->id);
         }
        $total = $total->where('users.status', 'ACTIVE')->count();

        $domains = Domain::select('domains.*' , 'domains.id as domain_id','clients.*','clients.name','clients.id as client_id' ,'clients.email','users.status','users.name as created_by_name', 'domains.remarks as domain_remark')
            ->join('clients', 'clients.id', '=', 'domains.client_fk_id')
            ->join('users', 'domains.created_by', '=', 'users.id')
            ->Where(function ($query) use ($search) {
                $query->orWhere('domains.domain_name', 'like','%'. $search . '%');
                // $query->orWhere('domains.client_fk_id', 'like', $search . '%');
                $query->orWhere('domains.expiry_date', 'like', $search . '%');
                $query->orWhere('domains.registration_date', 'like', $search . '%');
                $query->orWhere('domains.registrar_details', 'like', $search . '%');
                $query->orWhere('domains.currency', 'like', $search . '%');
                $query->orWhere('domains.amount', 'like', $search . '%');
                $query->orWhere('domains.status', 'like', $search . '%');
                $query->orWhere('domains.remarks', 'like', $search . '%');
                $query->orWhere('domains.created_by', 'like', $search . '%');
                $query->orWhere('clients.name', 'like', $search . '%');
                $query->orWhere('clients.email', 'like', $search . '%');
                $query->orWhere('users.name', 'like','%'. $search . '%');
            });

            if($bdmUser){
                $domains = $domains->where('domains.created_by', Auth::user()->id);
             }
        $domains = $domains->where('users.status', 'ACTIVE')->orderBy('domains.id',$orderType)->limit($limit)->offset($ofset)->get();

        // if($bdeUser){
        //     $domains = $domains->where('created_by', Auth::user()->id);
        //  }
        $i = 1 + $ofset;
        $data = [];

        foreach ($domains as $key => $domain) {
            $user=User::find($domain->created_by);
            $action = '<a href="' . route('admin.edit_domain', $domain->domain_id) . '" class="px-3 py-2 rounded btn-sm bg-info mb-2 text-white" id="editClient"><i class="fas fa-edit"></i></a>
            <button class="px-3 py-1 rounded btn-sm btn-danger deleteDomain" id="" data-id="' . $domain->domain_id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            $anchor = '<a href="' . route('admin.edit_clients', $domain->client_id) . '"> '.$domain->name.' </a><br>';
             $data[] = array(
                $anchor. $domain->email,
                date("d-m-Y", strtotime($domain->expiry_date)),
                date("d-m-Y", strtotime( $domain->registration_date)),
                $domain->domain_name,
                $domain->registrar_details	,
                $domain->currency,
                $domain->amount,
                $domain->status,
                $domain->domain_remark,
                $domain->created_by_name,
                $action,
            );
        }
        $records['recordsTotal'] =$total;
        $records['recordsFiltered'] =$total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function edit_domain($id)
    {
        $clients = Client::all();
        $domain = Domain::find($id);
        return view('domain.edit-domain')->with(compact('clients','domain'));
    }

    public function update_domain(Request $request)
    {
        $rules = [
            'id'                =>'required',
        ];
        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $domain = Domain::find($request->id);
       
            $data = [
                'client_fk_id'         =>       $request->client,
                'expiry_date'          =>       $request->expiry_date,
                'registration_date'    =>       $request->registration_date,
                'domain_name'          =>       $request->domain_name,
                'registrar_details'    =>       $request->registrar_details,
                'currency'             =>       $request->currency,
                'amount'               =>       $request->amount,
                'remarks'              =>       $request->remarks,
                'status'              =>        $request->status,
            ];
            $updated = $domain->update($data);
            if ($updated) {
                return response()->json(array('status' => true,  'location' => route('admin.domain'),   'msg' => 'Domain Updated successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }

    public function domain_delete(Request $request)
    {

        $delete = Domain::where('id', $request->id)->delete();
        if ($delete) {
            return response()->json(['status' => true, 'msg' => "Domain Deleted Successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg'=> "Error Occurred, Please try again"]);
            exit;
        }
    }

    public function domainView(Request $request){
        return view('domain.index');
    }

    public function importdomains(Request $request){
        Excel::import(new ImportDomain, $request->file('file')->store('files'));
        return redirect()->back();
    }

    public function exportDomains(Request $request){
        return Excel::download(new ExportDomain, 'Domain.xlsx');
    }

}
