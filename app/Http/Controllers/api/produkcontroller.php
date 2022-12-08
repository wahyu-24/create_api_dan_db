<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\produk;
use App\Http\Resources\produkresource;

class produkcontroller extends Controller
{
    public function index()
    {
    $data = produk::latest()->get();
    return response()->json([produkresource::collection($data), 
    'produks fetched.']);
    }

    public function store(Request $request)
    {
    $validator = Validator::make($request->all(),[
    'kode_produk' => 'required|string|max:255',
    'nama_produk' => 'required|string|max:255',
    'harga' => 'required'
    ]);
    if($validator->fails()){
    return response()->json($validator->errors()); 
    }
    $produk = produk::create([
    'kode_produk' => $request->kode_produk,
    'nama_produk' => $request->nama_produk,
    'harga' => $request->harga
    ]);
    
    return response()->json(['produk created successfully.', new
    produkresource($produk)]);
    }

    public function show($id)
    {
    $produk = produk::find($id);
    if (is_null($produk)) {
    return response()->json('Data not found', 404); 
    }
    return response()->json([new produkresource($produk)]);
    }

    public function update(Request $request, produk $produk)
    {
    $validator = Validator::make($request->all(),[
    'kode_produk' => 'required|string|max:255',
    'nama_produk' => 'required|string|max:255',
    'harga' => 'required'
    ]);
    if($validator->fails()){
    return response()->json($validator->errors()); 
    }
    $produk->kode_produk = $request->kode_produk;
    $produk->nama_produk = $request->nama_produk;
    $produk->harga = $request->harga;
    $produk->save();
    
    return response()->json(['produk updated successfully.', new
    produkresource($program)]);
    }

    public function destroy(produk $produk)
    {
    $produk->delete();
    return response()->json('produk deleted successfully');
    }
}
