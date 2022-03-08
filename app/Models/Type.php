<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Type extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'type';

    protected $fillable = ['type_name', 'description', 'image'];
}
