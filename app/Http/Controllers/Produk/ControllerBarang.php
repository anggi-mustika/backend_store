<?php

namespace App\Http\Controllers\Produk;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;
use App\Http\Resources\BarangResource;
use Illuminate\Support\Facades\Storage;


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
            'tag' => 'required',
            'type_size' => 'required',
            'ket_brg' => 'required',
            'berat_brg' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5048',
            'jenis_brg' => 'required',
        ]);

        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        $image = Barang::create([
            'image'     => $image->hashName(),
            'kd_brg'     => $request->kd_brg,
            'hrg_brg'     => $request->hrg_brg,
            'stok'     => $request->stok,
            'nm_brg'     => $request->nm_brg,
            'tag'     => $request->tag,
            'ket_brg'     => $request->ket_brg,
            'berat_brg'     => $request->berat_brg,
            'jenis_brg'     => $request->jenis_brg,
            'type_size'     => $request->type_size,

        ]);

        //return response($image, Response::HTTP_CREATED);

        return [
            'message' => 'Berhasil Upload Barang'
        ];
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'kd_brg' => 'required|unique:barang',
            'hrg_brg' => 'required',
            'stok' => 'nullable',
            'nm_brg' => 'required',
            'ket_brg' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5048',
            'berat_brg' => 'required',
            'jenis_brg' => 'required',
        ]);


        //$this->authorize('update', $barang);
        $post = Barang::find($id);

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //delete old image
            Storage::delete('public/posts/' . basename($post->image));

            //update post with new image
            $post->update([
                'image'     => $image->hashName(),
                'kd_brg'     => $request->kd_brg,
                'hrg_brg'     => $request->hrg_brg,
                'stok'     => $request->stok,
                'nm_brg'     => $request->nm_brg,
                'tag'     => $request->tag,
                'ket_brg'     => $request->ket_brg,
                'type_size'     => $request->type_size,
                'berat_brg'     => $request->berat_brg,
                'jenis_brg'     => $request->jenis_brg,
            ]);
        } else {

            //update post without image
            $post->update([
                'title'     => $request->title,
                'kd_brg'     => $request->kd_brg,
                'hrg_brg'     => $request->hrg_brg,
                'stok'     => $request->stok,
                'nm_brg'     => $request->nm_brg,
                'tag'     => $request->tag,
                'ket_brg'     => $request->ket_brg,
                'type_size'     => $request->type_size,
                'berat_brg'     => $request->berat_brg,
                'jenis_brg'     => $request->jenis_brg,
                //'content'   => $request->content,
            ]);
        }

        //return response
        //return response($image, Response::HTTP_CREATED);

        return [
            'message' => 'Berhasil update barang'
        ];
    }


    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $data = Barang::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // Lakukan penghapusan
        $data->delete();

        return response()->json(['message' => 'Barang berhasil dihapus'], 200);
    }

    public function kategori(Request $request)
    {
        $categoryName = $request->input('category_name');

        if (!$categoryName) {
            return response()->json(['error' => 'kategori yang anda cari tidak ada!'], 400);
        }

        $products = Barang::where('type_size', $categoryName)->get();

        return response()->json(['barang' => $products]);
    }

    public function hitungJumlahBarang()
    {
        // Menggunakan Query Builder untuk menghitung jumlah barang
        $jumlahBarang = DB::table('barang')->count();

        return response()->json(['jmlh_products' => $jumlahBarang]);
    }
}
