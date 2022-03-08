<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Type;
use DataTables;

class InventoryController extends Controller
{
    public function index()
    {
    }

    public function purchaseStok(Request $request)
    {
        $validatedData = $request->validate([
            'id_barang' => ['required', 'numeric'],
            'purchase_stok' => ['required', 'numeric'],
        ]);

        try {
            $up_inventory = Inventory::FindOrFail($request->id_barang);
            $up_inventory->stok = $up_inventory->stok + $request->purchase_stok;
            $up_inventory->update();

            return response()->json(array('success' => true, 'last_update_id' => $up_inventory->id), 200);
        } catch (\Exception $e) {
            return response()->json(array('success' => false), 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getDataId(Request $request)
    {
        $validatedData = $request->validate([
            'edit_id' => ['required', 'numeric'],
        ]);

        if ($haha = Inventory::whereUser_id($request->user()->id)->whereId($request->edit_id)->with(['type' => function ($q) {
            $q->select(['id', 'type_name']);
        }])->get()) {
            return response()->json(array('success' => true, 'data' => $haha), 200);
        } else {
            return response()->json(array('success' => false), 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'harga' => ['required', 'numeric'],
            'stok' => ['required', 'numeric'],
            'type_id' => ['required', 'numeric'],
            'nama_barang' => ['required'],
        ]);

        try {
            Type::FindOrFail($request->type_id);
        } catch (\Exception $e) {
            return response()->json(array('success' => false), 401);
        }

        $add_inventory = new Inventory;
        $add_inventory->user_id = $request->user()->id;
        $add_inventory->harga = $request->harga;
        $add_inventory->stok = $request->stok;
        $add_inventory->nama_barang = $request->nama_barang;
        $add_inventory->type_id = $request->type_id;

        if ($add_inventory->save()) {
            return response()->json(array('success' => true, 'last_insert_id' => $add_inventory->id), 201);
        } else {
            return response()->json(array('success' => false), 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory, Request $request)
    {
        $invent = Inventory::whereUser_id($request->user()->id)->with(['type' => function ($q) {
            $q->select(['id', 'type_name']);
        }])->get();

        // return $haha;
        return DataTables::of($invent)->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        $validatedData = $request->validate([
            'id' => ['required'],
            'harga' => ['required', 'numeric'],
            'stok' => ['required', 'numeric'],
            'type_id' => ['required', 'numeric'],
            'nama_barang' => ['required'],
        ]);

        try {
            Type::FindOrFail($request->type_id);

            $up_inventory = Inventory::whereUser_id($request->user()->id)->FindOrFail($request->id);

            $up_inventory->update($request->all());

            return response()->json(array('success' => true, 'last_update_id' => $up_inventory->id), 200);
        } catch (\Exception $e) {
            return response()->json(array('success' => false), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Inventory $inventory)
    {

        try {
            $up_inventory = Inventory::whereUser_id($request->user()->id)->FindOrFail($request->id_delete);

            $up_inventory->delete();

            return response()->json(array('success' => true, 'last_update_id' => $up_inventory->id), $status = 200);
        } catch (\Exception $e) {
            return response()->json(array('success' => false), 401);
        }
    }
}
