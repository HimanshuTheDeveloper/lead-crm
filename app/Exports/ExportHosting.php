<?php

namespace App\Exports;

use App\Models\Hosting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
  
class ExportHosting implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $hostings   =   Hosting::select('hostings.expiry_date','hostings.registration_date','hostings.domain_fk_id','hostings.server_data','clients.email','hostings.amount', 'hostings.currency','hostings.status','hostings.comment','users.name')
        ->join('clients', 'clients.id', '=', 'hostings.client_fk_id')
        ->join('users', 'hostings.created_by', '=', 'users.id')->get();

        return  $hostings;
        
        // return Hosting::select('expiry_date','registration_date','domain_fk_id','server_data','client_fk_id','amount','status','comment')
        //                 ->get();
    }

    public function headings(): array
    {
        return ['Expiry Date','Registration Date','Domain Name','Server Data','Client Email','Amount', 'Currency' ,'Status','Comment' , 'Created By'];
    }
}