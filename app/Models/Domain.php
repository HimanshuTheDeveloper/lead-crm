<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;
    protected $fillable = ['client_fk_id' , 'expiry_date' ,'registration_date' , 'domain_name' , 'registrar_details' , 'currency', 'amount', 'remarks','status' , 'created_by'];

}
