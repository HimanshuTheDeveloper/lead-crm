<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    use HasFactory;
    protected $fillable=['lead_fk_id','client_resonse','client_resonse','your_response','followup_date','created_by'];
}
