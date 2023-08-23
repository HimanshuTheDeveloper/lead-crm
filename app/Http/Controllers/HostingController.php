<?php

namespace App\Http\Controllers;

use App\Exports\ExportHosting;
use App\Imports\ImportHosting;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Domain;
use App\Models\Hosting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class HostingController extends Controller
{
    public function index()
    {
        return view('hosting.index');
    }

    public function add_hosting()
    {
        $bdmUser = false;
        foreach (Auth::user()->roles as $role) {
            if ($role->slug == "bdm") {
                $bdmUser = true;
            }
        }
        $clients = Client::query();
        if ($bdmUser) {
            $clients = $clients->where('created_by', '!=', 1);
        }
        $clients =   $clients->get();
        $currencies = Currency::all();
        return view('hosting.add-hosting')->with(compact("clients", "currencies"));
    }
    public function save_hosting(Request $request)
    {
        // return $request->all();
        $rules = [
            'expiry_date'             =>        'required',
            'registration_date'       =>        'required',
            'domain'                  =>        'required',
            'server_data'             =>        'required',
            'amount'                  =>        'required',
            'client'                  =>        'required',
            'status'                  =>        'required',
        ];
        $val = Validator::make($request->all(), $rules);

        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $data = [
                'expiry_date'           =>       $request->expiry_date,
                'registration_date'     =>       $request->registration_date,
                'domain_fk_id'          =>       $request->domain,
                'server_data'           =>       $request->server_data,
                'client_fk_id'          =>       $request->client,
                'currency'              =>       $request->currency,
                'amount'                =>       $request->amount,
                'status'                =>       $request->status,
                'comment'               =>       $request->comment,
                'created_by'            =>       Auth::user()->id,
            ];
            // return $request->server;
            $insert = Hosting::insert($data);
            if ($insert) {
                return response()->json(array('status' => true,  'location' => route('admin.hosting'), 'msg' => 'Hosting created successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }

    public function hosting_list(Request $request)
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

        foreach (Auth::user()->roles as $role) {
            if ($role->slug == "bdm") {
                $bdmUser = true;
            }
        }


        $total = Hosting::select('hostings.*', 'clients.name', 'clients.email', 'users.status', 'users.name as created_by_name')
            ->join('clients', 'clients.id', '=', 'hostings.client_fk_id')
            ->join('users', 'hostings.created_by', '=', 'users.id')
            ->Where(function ($query) use ($search) {
                $query->orWhere('hostings.expiry_date', 'like', $search . '%');
                $query->orWhere('hostings.registration_date', 'like', $search . '%');
                $query->orWhere('hostings.server_data', 'like', $search . '%');
                $query->orWhere('hostings.amount', 'like', $search . '%');
                $query->orWhere('hostings.status', 'like', $search . '%');
                $query->orWhere('hostings.comment', 'like', $search . '%');
                $query->orWhere('clients.name', 'like', $search . '%');
                $query->orWhere('users.name', 'like', $search . '%');
                $query->orWhere('clients.email', 'like', $search . '%');
                $query->orWhere('hostings.currency', 'like', $search . '%');
                // $query->orWhere('domains.domain_name', 'like', $search . '%');

            });
        $total = $total->where('users.status', 'ACTIVE')->count();

        $hostings = Hosting::select('hostings.*', 'clients.*', 'hostings.id as host_id', 'clients.name', 'clients.id as client_id', 'clients.email', 'users.status', 'users.name as created_by_name')
            ->join('clients', 'clients.id', '=', 'hostings.client_fk_id')
            // ->join('domains', 'domains.id', '=', 'hostings.domain_fk_id')
            ->join('users', 'hostings.created_by', '=', 'users.id')
            ->Where(function ($query) use ($search) {
                $query->orWhere('hostings.expiry_date', 'like', $search . '%');
                $query->orWhere('hostings.registration_date', 'like', $search . '%');
                $query->orWhere('hostings.server_data', 'like', $search . '%');
                $query->orWhere('hostings.amount', 'like', $search . '%');
                $query->orWhere('hostings.status', 'like', $search . '%');
                $query->orWhere('hostings.comment', 'like', $search . '%');
                $query->orWhere('clients.name', 'like', $search . '%');
                $query->orWhere('clients.email', 'like', $search . '%');
                $query->orWhere('hostings.currency', 'like', $search . '%');
                // $query->orWhere('domains.domain_name', 'like', $search . '%');
                $query->orWhere('hostings.comment', 'like', $search . '%');
                $query->orWhere('users.name', 'like', $search . '%');
                // $query->orWhere('hostings.client_fk_id', 'like', $search . '%');
            });

        if ($bdmUser) {
            $hostings = $hostings->where('hostings.created_by', Auth::user()->id);
        }
        $hostings = $hostings->where('users.status', 'ACTIVE')->orderBy('hostings.id', $orderType)->limit($limit)->offset($ofset)->get();




        $i = 1 + $ofset;
        $data = [];

        foreach ($hostings as $key => $hosting) {
            $user = User::find($hosting->created_by);
            $action = '<a href="' . route('admin.edit_hosting', $hosting->host_id) . '" class="px-3 py-2 rounded btn-sm bg-info mb-2 text-white" id="editClient"><i class="fas fa-edit"></i></a>
            <button class="px-3 py-1 rounded btn-sm btn-danger deleteHosting" id="" data-id="' . $hosting->host_id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            $anchor = '<a href="' . route('admin.edit_clients', $hosting->client_id) . '"> ' . $hosting->name . ' </a><br>';
            $data[] = array(
                $anchor . $hosting->email,
                date("d-m-Y", strtotime($hosting->expiry_date)),
                date("d-m-Y", strtotime($hosting->registration_date)),
                $hosting->domain_fk_id,
                $hosting->server_data,
                $hosting->currency,
                $hosting->amount,
                $hosting->status,
                $hosting->comment,
                $hosting->created_by_name,
                $action,
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function edit_hosting($id)
    {
        $clients = Client::all();
        $hosting = Hosting::find($id);
        return view('hosting.edit-hosting')->with(compact('clients', 'hosting'));
    }

    public function update_hosting(Request $request)
    {
        $rules = [
            'id'  => 'required',
        ];
        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $hosting = Hosting::find($request->id);
            $data = [
                'expiry_date'           =>       $request->expiry_date,
                'registration_date'     =>       $request->registration_date,
                'domain_fk_id'          =>       $request->domain,
                'server_data'           =>       $request->server_data,
                'client_fk_id'          =>       $request->client,
                'currency'                =>     $request->currency,
                'amount'                =>       $request->amount,
                'status'                =>       $request->status,
                'comment'               =>       $request->comment,
            ];
            $updated = $hosting->update($data);
            if ($updated) {
                return response()->json(array('status' => true,  'location' => route('admin.hosting'),   'msg' => 'Hosting Updated successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }

    public function hosting_delete(Request $request)
    {
        $delete = Hosting::where('id', $request->id)->delete();
        if ($delete) {
            return response()->json(['status' => true, 'msg' => "Hosting Deleted Successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error Occurred, Please try again"]);
            exit;
        }
    }

    public function hostingView(Request $request)
    {
        return view('hosting.index');
    }

    public function importhostings(Request $request)
    {
        Excel::import(new ImportHosting, $request->file('file')->store('files'));
        return redirect()->back();
    }

    public function exportHosting(Request $request)
    {
        return Excel::download(new ExportHosting(), 'exportHosting.xlsx');
    }
}
