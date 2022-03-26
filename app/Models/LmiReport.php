<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LmiReport extends Model
{
    protected $primaryKey = "lmi_report_id";

    protected $guarded = [];

    use HasFactory;
}
