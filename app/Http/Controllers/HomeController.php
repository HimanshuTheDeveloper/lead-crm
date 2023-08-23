<?php

namespace App\Http\Controllers;

use App\Models\Amc;
use App\Models\Followup;
use App\Models\Hosting;
use App\Models\Lead;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //

    public function dashboard()
    {

        $user = Auth::user();
        return view('dashboard');
    }
    public function hotLeads()
    {

        $leads = Lead::count();
        return view('dashboard.hotleads', compact('leads'));
    }

    public function followup()
    {
        return view('dashboard.followup');
    }

    public function missingup()
    {
        return view('dashboard.missingup');
    }

    public function hot_lead_list(Request $request)
    {
        // return $request->data['status'];

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

        $todaywithouttime = date('Y-m-d');
        $tomorrow = date('Y-m-d H:i:s', strtotime("+1 days"));

        foreach (Auth::user()->roles as $role) {
            if ($role->slug == "bdm") {
                $bdmUser = true;
            }
            if ($role->slug == "bde") {
                $bdeUser = true;
            }
        }

        $total = Lead::select('leads.*', 'leads.id as lead_id', 'users.*', 'leads.status as leadStatus' , 'users.status')
            ->join('users', 'leads.created_by', '=', 'users.id')
            // ->join('currencies', 'currencies.id', '=', 'amcs.currency')
            ->Where(function ($query) use ($search) {
                $query->orWhere('leads.lead_number',  $search);
                $query->orWhere('leads.followup_date', 'like', $search . '%');
                $query->orWhere('leads.work_description', 'like', $search . '%');
                $query->orWhere('leads.email', 'like', '%' . $search . '%');
                $query->orWhere('leads.lead_date', 'like', $search . '%');
                $query->orWhere('leads.email', 'like', $search . '%');
                $query->orWhere('leads.alt_email', 'like', $search . '%');
                $query->orWhere('leads.name', 'like', $search . '%');
                $query->orWhere('leads.mobile', 'like', $search . '%');
                $query->orWhere('leads.alt_mobile', 'like', $search . '%');
                $query->orWhere('leads.skype', 'like', $search . '%');
                $query->orWhere('leads.lead_date', 'like', $search . '%');
                $query->orWhere('leads.followup_date', 'like', $search . '%');
                $query->orWhere('leads.followed', 'like', $search . '%');
                $query->orWhere('leads.services', 'like', $search . '%');
                $query->orWhere('leads.country', 'like', $search . '%');
                $query->orWhere('leads.state', 'like', $search . '%');
                $query->orWhere('leads.city', 'like', $search . '%');
                $query->orWhere('leads.status', 'like', $search . '%');
                $query->orWhere('leads.reject_reason', 'like', $search . '%');
                $query->orWhere('leads.converted_amount', 'like', $search . '%');
                $query->orWhere('leads.comment', 'like', $search . '%');
                $query->orWhere('users.name', 'like', '%' . $search . '%');
                $query->orWhere('leads.domain_name', 'like', '%' . $search . '%');
            });

        if ($bdmUser) {
            $total = $total->where('created_by', '!=', 1);
        }
        if ($bdeUser) {
            $total = $total->where('created_by', Auth::user()->id);
        }
        // $total = $total->whereBetween("followup_date", [$todaywithouttime, $tomorrow])
        $total = $total->where('users.status', 'ACTIVE')->whereDate("followup_date",$todaywithouttime)
            ->where('leads.status', '!=', 'denied')
            ->where('leads.status', '!=', 'converted')->count();


        $leads = Lead::select('leads.*', 'leads.id as lead_id', 'leads.name as client_name', 'leads.email as client_email', 'users.*', 'users.name as username', 'leads.status as leadStatus')
            ->join('users', 'leads.created_by', '=', 'users.id')
            // ->join('currencies', 'currencies.id', '=', 'amcs.currency')
            ->Where(function ($query) use ($search) {
                $query->orWhere('leads.lead_number',  $search);
                $query->orWhere('leads.followup_date', 'like', $search . '%');
                $query->orWhere('leads.work_description', 'like', $search . '%');
                $query->orWhere('leads.email', 'like', '%' . $search . '%');
                $query->orWhere('leads.lead_date', 'like', $search . '%');
                $query->orWhere('leads.email', 'like', $search . '%');
                $query->orWhere('leads.alt_email', 'like', $search . '%');
                $query->orWhere('leads.name', 'like', $search . '%');
                $query->orWhere('leads.mobile', 'like', $search . '%');
                $query->orWhere('leads.alt_mobile', 'like', $search . '%');
                $query->orWhere('leads.skype', 'like', $search . '%');
                $query->orWhere('leads.lead_date', 'like', $search . '%');
                $query->orWhere('leads.followup_date', 'like', $search . '%');
                $query->orWhere('leads.followed', 'like', $search . '%');
                $query->orWhere('leads.services', 'like', $search . '%');
                $query->orWhere('leads.country', 'like', $search . '%');
                $query->orWhere('leads.state', 'like', $search . '%');
                $query->orWhere('leads.city', 'like', $search . '%');
                $query->orWhere('leads.status', 'like', $search . '%');
                $query->orWhere('leads.reject_reason', 'like', $search . '%');
                $query->orWhere('leads.converted_amount', 'like', $search . '%');
                $query->orWhere('leads.comment', 'like', $search . '%');
                $query->orWhere('users.name', 'like', '%' . $search . '%');
                $query->orWhere('leads.domain_name', 'like', '%' . $search . '%');
            });

        if ($bdmUser) {
            $leads = $leads->where('created_by', '!=', 1);
        }
        if ($bdeUser) {
            $leads = $leads->where('created_by', Auth::user()->id);
        }





        $leads = $leads->where('users.status', 'ACTIVE')->whereBetween("leads.followup_date", [$todaywithouttime, $tomorrow])
            ->where('leads.status', '!=', 'denied')
            ->where('leads.status', '!=', 'converted')->limit($limit)->offset($ofset)->orderBy($nameOrder, $orderType)->get();



        $i = 1 + $ofset;
        $data = [];

        $bdmUser = false;
        $bdeUser = false;

        foreach (Auth::user()->roles as $role) {
            if ($role->slug == "bdm" || $role->slug == "bde") {
                $bdmUser = true;
            }
        }


        foreach ($leads as $key => $lead) {
            $created_by = User::find($lead->created_by);
            $followupsCount = Followup::where('lead_fk_id', $lead->lead_id)->where('client_resonse', '!=', null)->count();

            $followupsCount  =   $followupsCount + 1;

            $block = "";
            if ($bdmUser) {
                $block = $lead->created_by != Auth::user()->id ? "d-none" : "";
            }

            $action = '
            <a href="' . route("admin.followup", $lead->lead_id) . '" type="button" class="btn btn-primary">
              Follow Up  &nbsp;<span class="bg-white text-dark rounded-circle px-2 py-1">' . $followupsCount . '</span>
            </a>
            <a href="' . route('admin.edit_lead', $lead->lead_id) . '" class="btn btn-sm bg-info mb-2 text-white " id="editClient" ><i class="fas fa-edit"></i></a>
             <button class="btn btn-sm btn-danger DeleteClient ' . $block . '" id="DeleteClient" data-id="' . $lead->lead_id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            $data[] = array(
                $lead->lead_number,
                date("d-m-Y", strtotime($lead->lead_date)),
                date("d-m-Y H:i", strtotime($lead->followup_date)),
                substr($lead->work_description, 0, 20000),
                $lead->client_name,
                $lead->client_email,
                $lead->alt_email,
                $lead->mobile,
                $lead->alt_mobile,
                $lead->skype,
                $lead->followed,
                $lead->services,
                $lead->country,
                $lead->state,
                $lead->city,
                $lead->address,
                $lead->leadStatus,
                $lead->domain_name,
                // $lead->converted_amount,
                substr($lead->comment, 0, 180),
                $lead->username,
                $action,
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function missingup_list(Request $request)
    {
        // return $request->data['status'];

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

        $from = date('Y-m-d H:i:s');

        // $to = date("Y-m-d", strtotime("+1 day"));

        foreach (Auth::user()->roles as $role) {
            if ($role->slug == "bdm") {
                $bdmUser = true;
            }
            if ($role->slug == "bde") {
                $bdeUser = true;
            }
        }

        $total = Lead::select('leads.*', 'leads.id as lead_id', 'users.*', 'leads.status as leadStatus')
            ->join('users', 'leads.created_by', '=', 'users.id')
            // ->join('currencies', 'currencies.id', '=', 'amcs.currency')
            ->Where(function ($query) use ($search) {
                $query->orWhere('leads.lead_number',  $search);
                $query->orWhere('leads.followup_date', 'like', $search . '%');
                $query->orWhere('leads.work_description', 'like', $search . '%');
                $query->orWhere('leads.email', 'like', '%' . $search . '%');
                $query->orWhere('leads.lead_date', 'like', $search . '%');
                $query->orWhere('leads.email', 'like', $search . '%');
                $query->orWhere('leads.alt_email', 'like', $search . '%');
                $query->orWhere('leads.name', 'like', $search . '%');
                $query->orWhere('leads.mobile', 'like', $search . '%');
                $query->orWhere('leads.alt_mobile', 'like', $search . '%');
                $query->orWhere('leads.skype', 'like', $search . '%');
                $query->orWhere('leads.lead_date', 'like', $search . '%');
                $query->orWhere('leads.followup_date', 'like', $search . '%');
                $query->orWhere('leads.followed', 'like', $search . '%');
                $query->orWhere('leads.services', 'like', $search . '%');
                $query->orWhere('leads.country', 'like', $search . '%');
                $query->orWhere('leads.state', 'like', $search . '%');
                $query->orWhere('leads.city', 'like', $search . '%');
                $query->orWhere('leads.status', 'like', $search . '%');
                $query->orWhere('leads.reject_reason', 'like', $search . '%');
                $query->orWhere('leads.converted_amount', 'like', $search . '%');
                $query->orWhere('leads.comment', 'like', $search . '%');
                $query->orWhere('users.name', 'like', '%' . $search . '%');
                $query->orWhere('leads.domain_name', 'like', '%' . $search . '%');
            });

        if ($bdmUser) {
            $total = $total->where('created_by', '!=', 1);
        }
        if ($bdeUser) {
            $total = $total->where('created_by', Auth::user()->id);
        }
        $total = $total->where('users.status', 'ACTIVE')->where('leads.followup_date', '<', $from)
            ->where('leads.status', '!=', 'denied')
            ->where('leads.status', '!=', 'converted')->count();


        $leads = Lead::select('leads.*', 'leads.id as lead_id', 'leads.name as client_name', 'leads.email as client_email', 'users.*', 'users.name as username', 'leads.status as leadStatus')
            ->join('users', 'leads.created_by', '=', 'users.id')
            // ->join('currencies', 'currencies.id', '=', 'amcs.currency')
            ->Where(function ($query) use ($search) {
                $query->orWhere('leads.lead_number', $search);
                $query->orWhere('leads.followup_date', 'like', $search . '%');
                $query->orWhere('leads.work_description', 'like', $search . '%');
                $query->orWhere('leads.email', 'like', '%' . $search . '%');
                $query->orWhere('leads.lead_date', 'like', $search . '%');
                $query->orWhere('leads.email', 'like', $search . '%');
                $query->orWhere('leads.alt_email', 'like', $search . '%');
                $query->orWhere('leads.name', 'like', $search . '%');
                $query->orWhere('leads.mobile', 'like', $search . '%');
                $query->orWhere('leads.alt_mobile', 'like', $search . '%');
                $query->orWhere('leads.skype', 'like', $search . '%');
                $query->orWhere('leads.lead_date', 'like', $search . '%');
                $query->orWhere('leads.followup_date', 'like', $search . '%');
                $query->orWhere('leads.followed', 'like', $search . '%');
                $query->orWhere('leads.services', 'like', $search . '%');
                $query->orWhere('leads.country', 'like', $search . '%');
                $query->orWhere('leads.state', 'like', $search . '%');
                $query->orWhere('leads.city', 'like', $search . '%');
                $query->orWhere('leads.status', 'like', $search . '%');
                $query->orWhere('leads.reject_reason', 'like', $search . '%');
                $query->orWhere('leads.converted_amount', 'like', $search . '%');
                $query->orWhere('leads.comment', 'like', $search . '%');
                $query->orWhere('users.name', 'like', '%' . $search . '%');
                $query->orWhere('leads.domain_name', 'like', '%' . $search . '%');
            });

        if ($bdmUser) {
            $leads = $leads->where('created_by', '!=', 1);
        }
        if ($bdeUser) {
            $leads = $leads->where('created_by', Auth::user()->id);
        }


        $leads = $leads->where('users.status', 'ACTIVE')->where('leads.followup_date', '<', $from)
            ->where('leads.status', '!=', 'denied')
            ->where('leads.status', '!=', 'converted')
            ->limit($limit)->offset($ofset)->orderBy('leads.id', $orderType)->get();

        $i = 1 + $ofset;
        $data = [];

        $bdmUser = false;
        $bdeUser = false;

        foreach (Auth::user()->roles as $role) {
            if ($role->slug == "bdm" || $role->slug == "bde") {
                $bdmUser = true;
            }
        }

        foreach ($leads as $key => $lead) {
            $created_by = User::find($lead->created_by);
            $followupsCount = Followup::where('lead_fk_id', $lead->lead_id)->where('client_resonse', '!=', null)->count();

            $followupsCount  =   $followupsCount + 1;

            $block = "";
            if ($bdmUser) {
                $block = $lead->created_by != Auth::user()->id ? "d-none" : "";
            }

            $action = '
            <a href="' . route("admin.followup", $lead->lead_id) . '" type="button" class="btn btn-primary">
              Follow Up  &nbsp;<span class="bg-white text-dark rounded-circle px-2 py-1">' . $followupsCount . '</span>
            </a>
            <a href="' . route('admin.edit_lead', $lead->lead_id) . '" class="btn btn-sm bg-info mb-2 text-white " id="editClient" ><i class="fas fa-edit"></i></a>
             <button class="btn btn-sm btn-danger DeleteClient ' . $block . '" id="DeleteClient" data-id="' . $lead->lead_id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            $data[] = array(
                $lead->lead_number,
                date("d-m-Y", strtotime($lead->lead_date)),
                date("d-m-Y H:i", strtotime($lead->followup_date)),
                substr($lead->work_description, 0, 20000),
                $lead->client_name,
                $lead->client_email,
                $lead->alt_email,
                $lead->mobile,
                $lead->alt_mobile,
                $lead->skype,
                $lead->followed,
                $lead->services,
                $lead->country,
                $lead->state,
                $lead->city,
                $lead->address,
                $lead->leadStatus,
                $lead->domain_name,
                // $lead->converted_amount,
                substr($lead->comment, 0, 180),
                $lead->username,
                $action,
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }



    public function followup_list(Request $request)
    {
        // return $request->data['status'];
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

        $yesterday = date('Y-m-d H:i:s', strtotime("-1 days"));
        $next30day = date('Y-m-d H:i:s', strtotime("+30 days"));

        foreach (Auth::user()->roles as $role) {
            if ($role->slug == "bdm") {
                $bdmUser = true;
            }
            if ($role->slug == "bde") {
                $bdeUser = true;
            }
        }

        $total = Lead::select('leads.*', 'leads.id as lead_id', 'users.*', 'leads.status as leadStatus')
            ->join('users', 'leads.created_by', '=', 'users.id')
            // ->join('currencies', 'currencies.id', '=', 'amcs.currency')
            ->Where(function ($query) use ($search) {
                $query->orWhere('leads.lead_number',  $search);
                $query->orWhere('leads.followup_date', 'like', $search . '%');
                $query->orWhere('leads.work_description', 'like', $search . '%');
                $query->orWhere('leads.email', 'like', '%' . $search . '%');
                $query->orWhere('leads.lead_date', 'like', $search . '%');
                $query->orWhere('leads.email', 'like', $search . '%');
                $query->orWhere('leads.alt_email', 'like', $search . '%');
                $query->orWhere('leads.name', 'like', $search . '%');
                $query->orWhere('leads.mobile', 'like', $search . '%');
                $query->orWhere('leads.alt_mobile', 'like', $search . '%');
                $query->orWhere('leads.skype', 'like', $search . '%');
                $query->orWhere('leads.lead_date', 'like', $search . '%');
                $query->orWhere('leads.followup_date', 'like', $search . '%');
                $query->orWhere('leads.followed', 'like', $search . '%');
                $query->orWhere('leads.services', 'like', $search . '%');
                $query->orWhere('leads.country', 'like', $search . '%');
                $query->orWhere('leads.state', 'like', $search . '%');
                $query->orWhere('leads.city', 'like', $search . '%');
                $query->orWhere('leads.status', 'like', $search . '%');
                $query->orWhere('leads.reject_reason', 'like', $search . '%');
                $query->orWhere('leads.converted_amount', 'like', $search . '%');
                $query->orWhere('leads.comment', 'like', $search . '%');
                $query->orWhere('users.name', 'like', '%' . $search . '%');
                $query->orWhere('leads.domain_name', 'like', '%' . $search . '%');
            });

        if ($bdmUser) {
            $total = $total->where('created_by', '!=', 1);
        }
        if ($bdeUser) {
            $total = $total->where('created_by', Auth::user()->id);
        }
        $total = $total->where('users.status', 'ACTIVE')->whereBetween("followup_date", [$yesterday, $next30day])
            ->where('leads.status', '!=', 'denied')
            ->where('leads.status', '!=', 'converted')->count();


        $leads = Lead::select('leads.*', 'leads.id as lead_id', 'leads.name as client_name', 'leads.email as client_email', 'users.*', 'leads.status as leadStatus')
            ->join('users', 'leads.created_by', '=', 'users.id')
            // ->join('currencies', 'currencies.id', '=', 'amcs.currency')
            ->Where(function ($query) use ($search) {
                $query->orWhere('leads.lead_number', $search);
                $query->orWhere('leads.followup_date', 'like', $search . '%');
                $query->orWhere('leads.work_description', 'like', $search . '%');
                $query->orWhere('leads.email', 'like', '%' . $search . '%');
                $query->orWhere('leads.lead_date', 'like', $search . '%');
                $query->orWhere('leads.email', 'like', $search . '%');
                $query->orWhere('leads.alt_email', 'like', $search . '%');
                $query->orWhere('leads.name', 'like', $search . '%');
                $query->orWhere('leads.mobile', 'like', $search . '%');
                $query->orWhere('leads.alt_mobile', 'like', $search . '%');
                $query->orWhere('leads.skype', 'like', $search . '%');
                $query->orWhere('leads.lead_date', 'like', $search . '%');
                $query->orWhere('leads.followup_date', 'like', $search . '%');
                $query->orWhere('leads.followed', 'like', $search . '%');
                $query->orWhere('leads.services', 'like', $search . '%');
                $query->orWhere('leads.country', 'like', $search . '%');
                $query->orWhere('leads.state', 'like', $search . '%');
                $query->orWhere('leads.city', 'like', $search . '%');
                $query->orWhere('leads.status', 'like', $search . '%');
                $query->orWhere('leads.reject_reason', 'like', $search . '%');
                $query->orWhere('leads.converted_amount', 'like', $search . '%');
                $query->orWhere('leads.comment', 'like', $search . '%');
                $query->orWhere('users.name', 'like', '%' . $search . '%');
                $query->orWhere('leads.domain_name', 'like', '%' . $search . '%');
            });

        if ($bdmUser) {
            $leads = $leads->where('created_by', '!=', 1);
        }
        if ($bdeUser) {
            $leads = $leads->where('created_by', Auth::user()->id);
        }

     

        $leads = $leads->where('users.status', 'ACTIVE')->whereBetween("followup_date", [$yesterday, $next30day])
            ->where('leads.status', '!=', 'denied')
            ->where('leads.status', '!=', 'converted')
            ->orderBy('leads.id', $orderType)
            ->limit($limit)->offset($ofset)->get();

        $i = 1 + $ofset;
        $data = [];

        $bdmUser = false;
        $bdeUser = false;

        foreach (Auth::user()->roles as $role) {
            if ($role->slug == "bdm" || $role->slug == "bde") {
                $bdmUser = true;
            }
        }


        foreach ($leads as $key => $lead) {
            $created_by = User::find($lead->created_by);
            $followupsCount = Followup::where('lead_fk_id', $lead->lead_id)->where('client_resonse', '!=', null)->count();

            $followupsCount  =   $followupsCount + 1;

            $block = "";
            if ($bdmUser) {
                $block = $lead->created_by != Auth::user()->id ? "d-none" : "";
            }

            $action = '
            <a href="' . route("admin.followup", $lead->lead_id) . '" type="button" class="btn btn-primary">
              Follow Up  &nbsp;<span class="bg-white text-dark rounded-circle px-2 py-1">' . $followupsCount . '</span>
            </a>
            <a href="' . route('admin.edit_lead', $lead->lead_id) . '" class="btn btn-sm bg-info mb-2 text-white " id="editClient" ><i class="fas fa-edit"></i></a>
             <button class="btn btn-sm btn-danger DeleteClient ' . $block . '" id="DeleteClient" data-id="' . $lead->lead_id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            $data[] = array(
                $lead->lead_number,
                date("d-m-Y", strtotime($lead->lead_date)),
                date("d-m-Y H:i", strtotime($lead->followup_date)),
                substr($lead->work_description, 0, 200000),
                $lead->client_name,
                $lead->client_email,
                $lead->alt_email,
                $lead->mobile,
                $lead->alt_mobile,
                $lead->skype,
                $lead->followed,
                $lead->services,
                $lead->country,
                $lead->state,
                $lead->city,
                $lead->address,
                $lead->leadStatus,
                $lead->domain_name,
                // $lead->converted_amount,
                $lead->comment,
                $created_by->name,
                $action,
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }




    public function hostings_lookup()
    {
        return view('dashboard.hosting-lookup');    
    }

  


    public function hostings_lookup_list(Request $request)
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

        $todaywithouttime =  date('Y-m-d H:i:s', strtotime("-30 days"));
        $tomorrow = date('Y-m-d H:i:s', strtotime("+30 days"));

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
        $total = $total->whereBetween("hostings.created_at", [$todaywithouttime, $tomorrow])->where('users.status', 'ACTIVE')->count();

        $hostings = Hosting::select('hostings.*', 'clients.*', 'hostings.id as host_id', 'hostings.created_at as hosting_created_at','clients.name', 'clients.id as client_id', 'clients.email', 'users.status', 'users.name as created_by_name')
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
                $query->orWhere('hostings.comment', 'like', $search . '%');
                $query->orWhere('users.name', 'like', $search . '%');
            });

        if ($bdmUser) {
            $hostings = $hostings->where('hostings.created_by', Auth::user()->id);
        }
        $hostings = $hostings->whereBetween("hostings.created_at", [$todaywithouttime, $tomorrow])->where('users.status', 'ACTIVE')->orderBy('hostings.id', $orderType)->limit($limit)->offset($ofset)->get();

        $i = 1 + $ofset;
        $data = [];

        foreach ($hostings as $key => $hosting) {
            $user = User::find($hosting->created_by);
            // $action = '<a href="' . route('admin.edit_hosting', $hosting->host_id) . '" class="px-3 py-2 rounded btn-sm bg-info mb-2 text-white" id="editClient"><i class="fas fa-edit"></i></a>
            // <button class="px-3 py-1 rounded btn-sm btn-danger deleteHosting" id="" data-id="' . $hosting->host_id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            
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
                date("d-m-Y", strtotime($hosting->hosting_created_at))
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }



    public function expired_hostings_lookup()
    {
        return view('dashboard.expired-hosting');    
    }


    
    public function expired_hostings_lookup_list(Request $request)
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

        $todaywithouttime =  date('Y-m-d H:i:s', strtotime("-30 days"));
        $tomorrow = date('Y-m-d H:i:s', strtotime("+30 days"));

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

            });
        $total = $total->whereNotBetween("hostings.created_at", [$todaywithouttime, $tomorrow])->where('users.status', 'ACTIVE')->count();

        $hostings = Hosting::select('hostings.*', 'clients.*', 'hostings.id as host_id', 'hostings.created_at as hosting_created_at',  'clients.name', 'clients.id as client_id', 'clients.email', 'users.status', 'users.name as created_by_name')
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
                $query->orWhere('clients.email', 'like', $search . '%');
                $query->orWhere('hostings.currency', 'like', $search . '%');
                $query->orWhere('hostings.comment', 'like', $search . '%');
                $query->orWhere('users.name', 'like', $search . '%');
            });

        if ($bdmUser) {
            $hostings = $hostings->where('hostings.created_by', Auth::user()->id);
        }
        $hostings = $hostings->whereNotBetween("hostings.created_at", [$todaywithouttime, $tomorrow])->where('users.status', 'ACTIVE')->orderBy('hostings.id', $orderType)->limit($limit)->offset($ofset)->get();

        $i = 1 + $ofset;
        $data = [];

        foreach ($hostings as $key => $hosting) {
            $user = User::find($hosting->created_by);
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
                date("d-m-Y", strtotime($hosting->hosting_created_at))
                
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }



    public function amc_lookup()
    {
        return view('dashboard.amc-lookup'); 
    }


    public function amc_lookup_list(Request $request)
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


        $todaywithouttime =  date('Y-m-d H:i:s', strtotime("-30 days"));
        $tomorrow = date('Y-m-d H:i:s', strtotime("+30 days"));

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
        $total = $total->whereBetween("amcs.created_at", [$todaywithouttime, $tomorrow])->where('users.status', 'ACTIVE')->count();
        

        $amcs = Amc::select('amcs.*' , 'amcs.id as am_id' , 'amcs.created_at as amc_created_at' ,'currencies.*','clients.name' ,'clients.email' ,'clients.id as client_id' ,'currencies.Currency', 'users.status','users.name as created_by_name')
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
        $amcs = $amcs->whereBetween("amcs.created_at", [$todaywithouttime, $tomorrow])->where('users.status', 'ACTIVE')->orderBy($nameOrder,$orderType)->limit($limit)->offset($ofset)->orderBy($nameOrder,$orderType)
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
               
                date("d-m-Y", strtotime( $amc->amc_created_at))
            );
        }
        $records['recordsTotal'] =$total;
        $records['recordsFiltered'] =$total;
        $records['data'] = $data;
        echo json_encode($records);
    }
    public function expired_amc_lookup()
    {
        return view('dashboard.expired-amc'); 
    }


    public function expired_amc_lookup_list(Request $request)
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

        
        $todaywithouttime =  date('Y-m-d H:i:s', strtotime("-30 days"));
        $tomorrow = date('Y-m-d H:i:s', strtotime("+30 days"));

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
        $total = $total->whereNotBetween("amcs.created_at", [$todaywithouttime, $tomorrow])->where('users.status', 'ACTIVE')->count();
        

        $amcs = Amc::select('amcs.*' , 'amcs.id as am_id' , 'amcs.created_at as amc_created_at' ,'currencies.*','clients.name' ,'clients.email' ,'clients.id as client_id' ,'currencies.Currency', 'users.status','users.name as created_by_name')
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
        $amcs = $amcs->whereNotBetween("amcs.created_at", [$todaywithouttime, $tomorrow])->where('users.status', 'ACTIVE')->orderBy($nameOrder,$orderType)->limit($limit)->offset($ofset)->orderBy($nameOrder,$orderType)
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
               
                date("d-m-Y", strtotime( $amc->amc_created_at))
            );
        }
        $records['recordsTotal'] =$total;
        $records['recordsFiltered'] =$total;
        $records['data'] = $data;
        echo json_encode($records);
    }




}
