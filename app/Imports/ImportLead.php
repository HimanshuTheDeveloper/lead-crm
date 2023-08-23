<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Lead;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;
use Illuminate\Support\Facades\Auth;

class ImportLead implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        if(!array_filter($row)) {
            return null;
        } 

        try {
            $row['lead_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['lead_date'])->format('Y-m-d');
            $row['followup_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['followup_date'])->format('Y-m-d H:i:s');          
          }
          catch(\Throwable $e) {
            $row['lead_date']  =    $row['lead_date'];
            $row['followup_date']  = $row['followup_date'] ;
          }


        $lead =  Lead::where('lead_number',$row['lead_number'])->first();
        if($lead){
            $lead->lead_number = $row['lead_number'];
            $lead->lead_date =$row['lead_date'];
            $lead->followup_date = $row['followup_date'];
            $lead->work_description = $row['work_description'];
            $lead->name = $row['name'];
            $lead->email = $row['email'];
            $lead->alt_email = $row['alt_email'];
            $lead->mobile = $row['mobile'];
            $lead->alt_mobile = $row['alt_mobile'];
            $lead->skype = $row['skype'];
            $lead->followed =  Auth::user()->name;
            $lead->services = $row['services'];
            $lead->country = $row['country'];
            $lead->state = $row['state'];
            $lead->city = $row['city'];
            $lead->address = $row['address'];
            $lead->domain_name = $row['domain_name'];
            $lead->status = $row['status'];
            $lead->reject_reason = $row['reject_reason'];
            $lead->comment = $row['comment'];
             $insert = $lead->save();
             return $lead;
        }else{
            return new Lead([
                'lead_number'     => $row['lead_number'],
                'lead_date'       => $row['lead_date'] ,
                'followup_date'   => $row['followup_date'],
                'work_description'=> $row['work_description'],
                'name'            => $row['name'],
                'email'           => $row['email'],
                'alt_email'       => $row['alt_email'],
                'mobile'          => $row['mobile'],
                'alt_mobile'      => $row['alt_mobile'],
                'skype'           => $row['skype'],
                'followed'        => Auth::user()->name,
                'services'        => $row['services'],
                'country'         => ucwords($row['country']),
                'state'           => ucwords($row['state']),
                'city'            => $row['city'],
                'address'         => $row['address'],
                'domain_name'     => $row['domain_name'],
                'status'          => $row['status'],
                'reject_reason'   => $row['reject_reason'],
                'comment'         => $row['comment'],
                'created_by'      => Auth::user()->id,
            ]);

        }
        
       
    }
}