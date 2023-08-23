<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Hosting;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;
use Illuminate\Support\Facades\Auth;

class ImportHosting implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        // dd($row);
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

            if($client){
                return new Hosting([
                    'expiry_date'      => $row['expiry_date'],
                    'registration_date'=> $row['registration_date'],
                    'domain_fk_id'     => $row['domain_name'],
                    'server_data'      => $row['server_data'],
                    'client_fk_id'     => $client->id,
                    'amount'           => $row['amount'],
                    'currency'         => $row['currency'],
                    'status'           => $row['status'],
                    'comment'          => $row['comment'],
                    'created_by'       => $created_by
                ]);
            }
       
    }
}