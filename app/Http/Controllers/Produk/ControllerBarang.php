<?php

namespace App\Http\Controllers\Produk;

use App\Models\Barang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\Events\Validated;
use App\Http\Resources\BarangResource;


class ControllerBarang extends Controller
{
    public function index()
    {

        $barang = Barang::all();
        //return response()->json(['data' => $barang]);
        return BarangResource::collection($barang);
    }
    public function show($id)
    {
        $barang1 = Barang::findOrfail($id);
        return new BarangResource($barang1);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kd_brg' => 'required|unique:barang',
            'hrg_brg' => 'required',
            'stok' => 'nullable',
            'nm_brg' => 'required',
            'ket_brg' => 'required',
            'berat_brg' => 'required',
            'jenis_brg' => 'required',
        ]);

        $barang = Barang::create([
            'kd_brg' => $request->kd_brg,
            'hrg_brg' => $request->hrg_brg,
            'stok' => $request->stok,
            'nm_brg' => $request->nm_brg,
            'ket_brg' => $request->ket_brg,
            'berat_brg' => $request->berat_brg,
            'jenis_brg' => $request->jenis_brg,
        ]);


        return response()->json(['Program created successfully.']);
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'kd_brg' => 'required|unique:barang',
            'hrg_brg' => 'required',
            'stok' => 'nullable',
            'nm_brg' => 'required',
            'ket_brg' => 'required',
            'berat_brg' => 'required',
            'jenis_brg' => 'required',
        ]);

        //$this->authorize('update', $barang);
        $barang = Barang::find($id);
        if ($barang) {
            $barang->kd_brg = $request->kd_brg;
            $barang->hrg_brg = $request->hrg_brg;
            $barang->stok = $request->stok;
            $barang->nm_brg = $request->nm_brg;
            $barang->ket_brg = $request->ket_brg;
            $barang->berat_brg = $request->berat_brg;
            $barang->jenis_brg = $request->jenis_brg;
            $barang->update();

            return ["result" => "data berhasil di update"];
        } else {
            return ["result" => "data gagal di update"];
        }
    }
}
