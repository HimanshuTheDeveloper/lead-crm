<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hosting extends Model
{
    use HasFactory;

    protected $fillable = [
        'expiry_date',
        'registration_date',
        'domain_fk_id',
        'server_data', 
        'client_fk_id', 
        'amount',
        'status',
        'comment',
        'currency',
        'created_by'
    ];
}
