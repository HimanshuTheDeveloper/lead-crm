<?php

namespace App\Exports;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
  
class ExportLead implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

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

        $leads =  Lead::select('leads.lead_number','leads.lead_date','leads.followup_date','leads.work_description','leads.name','leads.email','leads.alt_email','leads.mobile','leads.alt_mobile',
        'leads.skype','leads.followed','leads.services','leads.country','leads.state','leads.city','leads.address','leads.domain_name','leads.status','leads.reject_reason','leads.comment','users.name as username')
        ->join('users', 'leads.created_by', '=', 'users.id');
        if($bdeUser){
            $leads = $leads->where('created_by', Auth::user()->id);
         }
         if($bdmUser){
            $leads = $leads->where('created_by', Auth::user()->id);
         }
         $leads = $leads->get();

        return $leads;
    }

    public function headings(): array
    {
        return ['Lead_Number','Lead_Date','Followup_Date','Work_Description','Name','Email','Alt_Email','Mobile','Alt_Mobile','Skype',
        'Followed','Services','Country','State','City','Address','Domain_Name','Status','Reject_Reason','Comment','Created_By'];
    }
}