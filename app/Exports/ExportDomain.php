<?php

namespace App\Exports;

use App\Models\Domain;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
  
class ExportDomain implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $domains = Domain::select('clients.email','domains.expiry_date','domains.registration_date','domains.domain_name','domains.registrar_details','domains.currency','domains.amount','domains.status','domains.remarks','users.name')
        ->join('clients', 'clients.id', '=', 'domains.client_fk_id')
        ->join('users', 'domains.created_by', '=', 'users.id')->get();

        return   $domains ;
        
    }

    public function headings(): array
    {
        return ['Client Email','Expiry_Date','Registration_Date','Domain_Name','Registrar_Details','Currency','Amount','Status','Remarks','Created By'];
    }
}