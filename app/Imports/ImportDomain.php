<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Domain;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;
use Illuminate\Support\Facades\Auth;

class ImportDomain implements ToModel, WithHeadingRow
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
            $row['expiry_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['expiry_date'])->format('Y-m-d');
            $row['registration_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['registration_date'])->format('Y-m-d');        
          }
          catch(\Throwable $e) {
            $row['expiry_date']  =    $row['expiry_date'];
            $row['registration_date']  = $row['registration_date'] ;
          }


        $client = Client::where('email',$row['client_email'])->first(); 
        $created_by = Auth::user()->id;

            if($client->id){
                return new Domain([
                    'client_fk_id'     => $client->id,
                    'expiry_date'      => $row['expiry_date'],
                    'registration_date'=> $row['registration_date'],
                    'domain_name'      => $row['domain_name'],
                    'registrar_details'=> $row['registrar_details'],
                    'currency'         => $row['currency'],
                    'amount'           => $row['amount'],
                    'status'           => $row['status'],
                    'remarks'          => $row['remarks'],
                    'created_by'       => $created_by
                ]);
            }else{
                dd("Client Details Does not Matched with Database !");
            }
    }
}