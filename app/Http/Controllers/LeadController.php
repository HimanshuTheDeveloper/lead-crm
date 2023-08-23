<?php

namespace App\Http\Controllers;

use App\Exports\ExportLead;
use App\Imports\ImportLead;
use App\Models\Client;
use App\Models\Country;
use App\Models\Followup;
use App\Models\Lead;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class LeadController extends Controller
{
        // BYTEAMC-  8 char
    function generateUniqueCode() {
        $lead_code = Lead::orderBy('id', 'desc')->first();
        if($lead_code){
            $number = substr($lead_code->lead_number,9);
            $number = (int)$number + 1;
            $new_code = "BYTE-".date("y").date("m").$number;
        }else{
            $new_code = "BYTE-".date("y").date("m")."-1"; 
        }
        return $new_code;
    }
    public function index()
    {
    
        // return $bdeArray->push(1);
        $users= User::all();
        return view('leads.index',compact('users'));
    }
    public function addleads()
    {
        $countries = Country::all();
        $lead_number= $this->generateUniqueCode();
        return view('leads.add-lead')->with(compact('countries','lead_number'));
    }
    public function edit_lead($id)
    {
        $lead = Lead::find($id);
        $countries = Country::all();
        return view('leads.edit-lead')->with(compact('countries','lead'));
    }

    public function save_lead(Request $request)
    {
        $rules = [
            'lead_number'      =>'required',
            'lead_date'        =>'required',
            'followup_date'    =>'required',
            'work_description' =>'required',
            'name'             =>'required',
        ];

        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $lead = new Lead();
            $lead->lead_number     = $request->input('lead_number');
            $lead->lead_date       = $request->input('lead_date');
            $lead->followup_date   = $request->input('followup_date');
            $lead->work_description= $request->input('work_description');
            $lead->name            = $request->input('name');
            $lead->email           = $request->input('email');
            $lead->alt_email       = $request->input('alt_email');
            $lead->mobile          = $request->input('mobile');
            $lead->alt_mobile      = $request->input('alt_mobile');
            $lead->skype           = $request->input('skype');
            $lead->followed        = $request->input('followed');
            $lead->services        = $request->input('services');
            $lead->country         = $request->input('country');
            $lead->state           = $request->input('state');
            $lead->city            = $request->input('city');
            $lead->address         = $request->input('address');
            $lead->domain_name     = $request->input('domain_name');
            $lead->status          = $request->input('status');
            $lead->reject_reason   = $request->input('reject_reason');
            $lead->currency        = $request->input('currency');
            $lead->converted_amount = $request->input('converted_amount');
            $lead->comment         = $request->input('comment');
            $lead->created_by      = Auth::user()->id;
            $insert = $lead->save();
            
            $clientCount = Client::where("email",$request->input('email'))->count();
            if($request->input('status') =="converted" && $clientCount< 1)
            {
                $client = new Client();
                $data = [
                    'name'       => $request->input('name'),
                    'email'      => $request->input('email'),
                    'phone'      => $request->input('mobile'),
                    'country'    => $request->input('country'),
                    'state'      => $request->input('state'),
                    'address'    => $request->input('address'),
                    'created_by' => Auth::user()->id,
                ];
                $insert = $client->insert($data);
                
            }
            if ($insert) {
                return response()->json(array('status' => true,  'location' => route('admin.leads'),   'msg' => 'Leads created successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }
   
    public function update_lead(Request $request)
    {
        $rules = [
            'id'         =>     'required',
            'status'     =>     'required',
        ];
        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $lead =  Lead::find($request->id);
            $lead->lead_number = $request->input('lead_number');
            $lead->lead_date =$request->input('lead_date');
            $lead->followup_date = $request->input('followup_date');
            $lead->work_description = $request->input('work_description');
            $lead->name = $request->input('name');
            $lead->email = $request->input('email');
            $lead->alt_email = $request->input('alt_email');
            $lead->mobile = $request->input('mobile');
            $lead->alt_mobile = $request->input('alt_mobile');
            $lead->skype = $request->input('skype');
            $lead->followed = $request->input('followed');
            $lead->services = $request->input('services');
            $lead->country = $request->input('country');
            $lead->state = $request->input('state');
            $lead->city = $request->input('city');
            $lead->address = $request->input('address');
            $lead->domain_name = $request->input('domain_name');
            $lead->status = $request->input('status');
            $lead->reject_reason = $request->input('reject_reason');
            $lead->currency = $request->input('currency');
            $lead->converted_amount = $request->input('converted_amount');
            $lead->comment = $request->input('comment');
            $insert = $lead->save();

            $clientCount = Client::where("email",$request->input('email'))->count();
            if($request->input('status') =="converted" && $clientCount< 1)
            {
                $client = new Client();
                $data = [
                    'name'       => $request->input('name'),
                    'email'      => $request->input('email'),
                    'phone'      => $request->input('mobile'),
                    'country'    => $request->input('country'),
                    'state'      => $request->input('state'),
                    'address'    => $request->input('address'),
                    'created_by' => Auth::user()->id,
                ];
                $insert = $client->insert($data);

            }
            if ($insert) {
                return response()->json(array('status' => true,  'location' => route('admin.leads'),   'msg' => 'Leads updated successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }
   
    public function lead_list(Request $request)
    {
        // return $request->all();

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
        if (isset($request->data['status'])) {
            $statusFilter = $request->data['status'];
        } else {
            $statusFilter = null;
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
        $total = Lead::select('leads.*' ,'leads.id as lead_id', 'users.*' , 'leads.status as leadStatus')
        ->join('users', 'leads.created_by', '=', 'users.id')
        // ->join('currencies', 'currencies.id', '=', 'amcs.currency')
        ->Where(function ($query) use ($search) {
            $query->orWhere('leads.lead_number', 'like', $search . '%');
            $query->orWhere('leads.followup_date', 'like', $search . '%');
            $query->orWhere('leads.work_description', 'like', $search . '%');
            $query->orWhere('leads.city', 'like', $search . '%');
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
            $query->orWhere('leads.address', 'like', $search . '%');
            $query->orWhere('leads.reject_reason', 'like', $search . '%');
            $query->orWhere('leads.converted_amount', 'like', $search . '%');
            $query->orWhere('leads.comment', 'like', $search . '%');
            $query->orWhere('leads.created_by', 'like', $search . '%');
        });

        if($bdmUser){
            $bdeArray = User::where('role', 'bde')->pluck('id');
            $bdeArray = $bdeArray->push(Auth::user()->id);
            $total = $total->whereIn('leads.created_by',$bdeArray);
         }
        
        if($bdeUser){
            $total = $total->where('created_by', Auth::user()->id);
         }

        if($request->data['user'] != null) {
                $total = $total->where('leads.created_by', '=', $request->data['user']);
        }

        if($statusFilter!=null) {

            if(!in_array('all', $statusFilter))
            {
                $total = $total->whereIn('leads.status', $request->data['status']);
            }

        }

        if ($request->data['lead_from_date'] != null) {
            $total = $total->where('leads.lead_date', '>', $request->data['lead_from_date']);
        }
        if ($request->data['lead_to_date'] != null) {
            $total = $total->where('leads.lead_date', '<', $request->data['lead_to_date']);
        }
        if ($request->data['follow_from_date'] != null) {
            $total = $total->where('leads.followup_date', '>', $request->data['follow_from_date']);
        }
        if ($request->data['follow_to_date'] != null) {
            $total = $total->where('leads.followup_date', '<', $request->data['follow_to_date']);
        }


        $total = $total->where('users.status', 'ACTIVE')->count();

        $leads = Lead::select('leads.*' ,'leads.id as lead_id' ,'leads.followup_date as follow','leads.name as client_name','leads.lead_date as leadd','leads.email as client_email', 'users.*' , 'users.name as username', 'leads.status as leadStatus','leads.alt_email as alts_email' )
            ->join('users', 'leads.created_by', '=', 'users.id')
            // ->join('currencies', 'currencies.id', '=', 'amcs.currency')
           
             ->Where(function ($query) use ($search) {
                $query->orWhere('leads.lead_number', 'like','%'. $search . '%');
                $query->orWhere('leads.followup_date', 'like', $search . '%');
                $query->orWhere('leads.work_description', 'like', $search . '%');
                $query->orWhere('leads.email', 'like','%'. $search . '%');
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
                $query->orWhere('users.name', 'like', $search . '%');
            });

            if($bdmUser){
                $bdeArray = User::where('role', 'bde')->pluck('id');
                $bdeArray = $bdeArray->push(Auth::user()->id);
                $leads = $leads->whereIn('leads.created_by',$bdeArray);
             }


            if($bdmUser){

                    if ($request->data['user'] != null) {
                        $leads = $leads->where('leads.created_by', '=', $request->data['user']);
                    }
                    if($statusFilter!=null) {
                        if(!in_array('all', $statusFilter))
                        {
                            $leads = $leads->whereIn('leads.status', $request->data['status']);
                        }
                    }
                    if ($request->data['lead_from_date'] != null) {
                        $leads = $leads->where('leads.lead_date', '>', $request->data['lead_from_date']);
                    }
                    if ($request->data['lead_to_date'] != null) {
                        $leads = $leads->where('leads.lead_date', '<', $request->data['lead_to_date']);
                    }
                    if ($request->data['follow_from_date'] != null) {
                        $leads = $leads->where('leads.followup_date', '>', $request->data['follow_from_date']);
                    }
                    if ($request->data['follow_to_date'] != null) {
                        $leads = $leads->where('leads.followup_date', '<', $request->data['follow_to_date']);
                    }
                    
                }

           
            if($bdeUser){
                $leads = $leads->where('created_by', Auth::user()->id);
             }


             if(Auth::user()->role == 'admin'){

                if ($request->data['user'] != null) {
                    $leads = $leads->where('leads.created_by', '=', $request->data['user']);
                }
                if($statusFilter!=null) {
                    if(!in_array('all', $statusFilter))
                    {
                        $leads = $leads->whereIn('leads.status', $request->data['status']);
                    }
                }
                if ($request->data['lead_from_date'] != null) {
                    $leads = $leads->where('leads.lead_date', '>', $request->data['lead_from_date']);
                }
                if ($request->data['lead_to_date'] != null) {
                    $leads = $leads->where('leads.lead_date', '<', $request->data['lead_to_date']);
                }
                if ($request->data['follow_from_date'] != null) {
                    $leads = $leads->where('leads.followup_date', '>', $request->data['follow_from_date']);
                }
                if ($request->data['follow_to_date'] != null) {
                    $leads = $leads->where('leads.followup_date', '<', $request->data['follow_to_date']);
                }

             }

           

            $leads = $leads->where('users.status', 'ACTIVE')->orderBy('leads.id',$orderType)->limit($limit)->offset($ofset)->get();

        $i = 1 + $ofset;
        $data = [];

      

        foreach ($leads as $key => $lead) {
           $created_by = User::find( $lead->created_by);
           $followupsCount=Followup::where('lead_fk_id',$lead->lead_id)->where('client_resonse','!=',null)->count();

           $followupsCount  =   $followupsCount +1;

           $block = "";
           if($bdmUser){
               $block = $lead->created_by != Auth::user()->id ? "d-none" : "";
           }

            $action = '<a href="'.route("admin.followup" , $lead->lead_id).'" type="button" class="px-2 py-1 btn-primary">
                Follow Up  &nbsp;<span class="bg-white text-dark rounded-circle px-2 py-1">'.$followupsCount.'</span></a>
                <a href="' . route('admin.edit_lead', $lead->lead_id) . '" class="px-2 py-1 bg-info mb-2 text-white " id="editClient" ><i class="fas fa-edit"></i></a>
                <button class="px-2 py-1 btn-danger DeleteClient '. $block.'" id="DeleteClient" data-id="' . $lead->lead_id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            $data[] = array(
                $lead->lead_number,
                date("d-m-Y", strtotime($lead->lead_date)),
                date("d-m-Y H:i", strtotime($lead->followup_date)),
                substr($lead->work_description,0,2000000),
                $lead->client_name,
                $lead->client_email,
                $lead->mobile,
                $lead->followed,
                $lead->country,
                $lead->state,
                $lead->leadStatus,
                $lead->reject_reason,
                substr($lead->comment,0,100) . '...',
                 $lead->username,
                $action,
            );
        }
        $records['recordsTotal'] =$total;
        $records['recordsFiltered'] =$total;
        $records['data'] = $data;
        echo json_encode($records);
    }


    public function lead_delete(Request $request)
    {
        $delete = Lead::where('id', $request->id)->delete();
        if ($delete) {
            return response()->json(['status' => true, 'msg' => "Lead Deleted Successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg'=> "Error Occurred, Please try again"]);
            exit;
        }
    }

    public function importView(Request $request){
        return view('lead.index');
    }

    public function import(Request $request){
        // $rules = [
        //     'lead_number'      =>'required:unique',
        // ];

        // $val = Validator::make($request->all(), $rules);
        // if ($val->fails()) {
        //     return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
        //     exit;
        // } else {


            try {
                Excel::import(new ImportLead, $request->file('file')->store('files'));
            } catch (Exception $e) {
                return back()->with('message', $e->getMessage());
            }
            return back()->with('success', 'Followup data imported sccuessfully!');

      
        // return redirect()->back();
        // }
    }

    public function exportLeads(Request $request){
        // $leads=Lead::all();
        
        // $bdmUser = false;
        // $bdeUser = false;

        // foreach(Auth::user()->roles as $role){

        //     if($role->slug == "bdm")
        //     {
        //         $bdmUser = true;
        //     }
        //     if($role->slug == "bde")
        //     {
        //         $bdeUser = true;
        //     }
        // }

        // if($bdmUser){
        //     $leads = $leads->where('created_by', Auth::user()->id);
        //  }
        // if($bdeUser){
        //     $leads = $leads->where('created_by', Auth::user()->id);
        //  }

            // $leads =  Lead::select('leads.lead_number','leads.lead_date','leads.followup_date','leads.work_description','leads.name','leads.email','leads.alt_email','leads.mobile','leads.alt_mobile',
            // 'leads.skype','leads.followed','leads.services','leads.country','leads.state','leads.city','leads.address','leads.domain_name','leads.status','leads.reject_reason','leads.comment','users.name')
            // ->join('users', 'leads.created_by', '=', 'users.id')->get();

            // return $leads;

        return Excel::download(new ExportLead, 'lead.xlsx');
    }
    public function followup($id){

        $lead = Lead::find($id);
        $followups=Followup::where('lead_fk_id',$id)->get();
        // return $followups;    
        return view('leads.followup')->with(compact('lead','followups'));
    }

    public function lead_modal(Request $request)
    {
        // return  $request->all();
        $rules = [
            // 'client_resonse'=>'required',
            // 'your_response' =>'required',
            'followup_date' =>'required',
            'lead_fk_id'    =>'required',
        ];

        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json(['status' => false, 'msg' => $val->errors()->first()]);
            exit;
        } else {
            $modal_lead = new Followup();
       
            $data = [
                'lead_fk_id'    => $request->lead_fk_id,
                'client_resonse'=> $request->client_resonse,
                'your_response' => $request->your_response,
                'followup_date' => $request->followup_date,
                'created_by'    => Auth::user()->id,
            ];

            $insert = $modal_lead->insert($data);

            $lead =  Lead::find($request->lead_fk_id);
            $lead->followup_date = $request->followup_date;
            $updated = $lead->save();

            if ($updated) {
                return response()->json(array('status' => true,  'location' => route("admin.followup" , $request->lead_fk_id),   'msg' => 'Followup created successfully!!'));
            } else {
                return response()->json(array('status' => false, 'msg' => 'Something Went Wrong!'));
            }
        }
    }

}
