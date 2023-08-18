<?php

namespace App\Http\Controllers;

//use App\Http\Requests\GambarStoreRequest;

use App\Http\Resources\GambarResource;
use App\Models\GambarUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UploadGambarController extends Controller
{

    public function show($id)
    {
        $image = GambarUpload::findOrfail($id);
        return new GambarResource($image);
    }

    public function imageStore(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        $image = GambarUpload::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,

        ]);

        return response($image, Response::HTTP_CREATED);

        return [
            'message' => 'You have successfully upload image'
        ];
    }

    public function imageupdate(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            //'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $post = GambarUpload::find($id);

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
                'title'     => $request->title,
                //'content'   => $request->content,
            ]);
        } else {

            //update post without image
            $post->update([
                'title'     => $request->title,
                //'content'   => $request->content,
            ]);
        }

        //return response
        //return response($image, Response::HTTP_CREATED);

        return [
            'message' => 'Berhasil update Gambar'
        ];
        //return response
        //return new PostResource(true, 'Data Post Berhasil Diubah!', $post);
    }
}
