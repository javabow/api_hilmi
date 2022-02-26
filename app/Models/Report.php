<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Report extends Model
{
    use HasFactory, HasApiTokens;

    //lock untuk table dalam database
    protected $table = "report";
    protected $fillable = ['report, report_name'];
}
