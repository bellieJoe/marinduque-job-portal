<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPRS extends Model
{
    use HasFactory;

    protected $table = "sprs";
    protected $primaryKey = "sprs_id";
    protected $guarded = [];
}
