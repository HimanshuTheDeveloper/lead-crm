<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'Cilent_fk_id',
        'job_description',
        // 'service_name',
        // 'currency',
        // 'amount',
        'remarks',
        'payment_date',
        'invoice_date',
        'created_by',
        'currency',
        'total_amount',
        'payment_status',

    ];
}
