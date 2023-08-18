<?php

namespace App\Http\Controllers;

use App\Http\Resources\DaftarPelangganResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrfail($id);
        return new DaftarPelangganResource($user);
    }

    public function delete($id)
    {
        //mencari data sesuai $id
        //$id diambil dari ujung url yang kita kirimkan dengan postman
        $user = User::findOrFail($id);

        // jika data berhasil didelete maka tampilkan pesan json 
        if ($user->delete()) {
            return response([
                'Berhasil Menghapus Data'
            ]);
        } else {
            //response jika gagal menghapus
            return response([
                'Tidak Berhasil Menghapus Data'
            ]);
        }
    }
}
