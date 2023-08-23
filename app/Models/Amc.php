<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amc extends Model
{
    use HasFactory;

    protected $fillable = [
        'amc_id'        ,
        'amc_end_date'  ,
        'amc_start_date',
        'amount'        ,
        'client'        ,
        'currency'      ,
        'domain_name'   ,
        'remarks'   ,
        'created_at',
        'updated_at',
    ];


    public function client()
    {
        return $this->belongsTo(Client::class , 'clients');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class , 'currencies');
    }




}
