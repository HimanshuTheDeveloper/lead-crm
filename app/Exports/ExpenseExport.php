<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExpenseExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'type',
            'date',
            'currency',
            'amount',
            'created_at',
        ];
    } 
    public function collection()
    {
        return Expense::select('type','date','currency','amount','created_at')->get();
    }
}
