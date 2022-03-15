<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;

class Inventory extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'inventory';

    protected $fillable = ['user_id', 'nama_barang', 'type_id', 'harga', 'stok'];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function scopeFiltered(Builder $builder)
    {
        $search = request('search') ?? null;
        $searchColumns = request('searchColumns') ?? null;

        $sort = request('sort') ?? null;
        $sortBy = request('sortBy') ?? null;
        $sortColumns = request('sortColumns') ?? null;

        // format

        $inventory = $builder->select(
            'inventory.id AS id',
            'inventory.nama_barang AS nama_barang',
            'inventory.harga AS harga',
        );

        if ($search && Str::length($search) > 0) {
            $listSearch = Str::of($search)->split('/[\s,]+/')->toArray();
            $search = count($listSearch) > 1 ? implode("%", $listSearch) : "%{$search}%";

            $searchColumns = Str::of($searchColumns)->split('/[\s,]+/')->toArray();

            $inventory->where(function ($query) use ($search, $searchColumns) {
                foreach ($searchColumns as $searchColumn) {
                    $query->orWhereRaw("inventory.{$searchColumn} LIKE '{$search}'");
                }
            });
        }


        $sortColumns = Str::of($sortColumns)->split('/[\s,]+/')->toArray();

        if (collect($sortColumns)->contains($sortBy) &&  collect(['ASC', 'DESC'])->contains($sort)) {
            $inventory->orderBy("inventory.{$sortBy}", $sort);
        }

        return $inventory;
    }
}
