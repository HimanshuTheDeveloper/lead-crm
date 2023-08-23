<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentExport implements FromCollection ,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'client',
            'job_description',
            'remarks',
            'payment_date',
            'invoice_date',
            'invoice_type',
            'currency',
            'total_amount',
        ];
    } 
    public function collection()
    {
        return Payment::select('client','job_description','remarks','payment_date','invoice_date','invoice_type','currency','total_amount')->get();
    }
}
