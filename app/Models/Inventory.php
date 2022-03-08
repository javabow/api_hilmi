<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Inventory extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'inventory';

    protected $fillable = ['user_id', 'nama_barang', 'type_id', 'harga', 'stok'];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}
