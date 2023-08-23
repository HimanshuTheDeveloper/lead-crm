<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $fillable= [ 'lead_number','lead_date','followup_date','work_description','name','status','email','alt_email','mobile','alt_mobile','skype','followed','services','country','state','city','address','domain_name','reject_reason','comment','created_by' , 'currency' , 'converted_amount']; 
}
