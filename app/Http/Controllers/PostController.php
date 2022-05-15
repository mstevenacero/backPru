<?php

namespace App\Http\Controllers;

use App\Models\post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post =  DB::table('posts')->get();

        $data = array(
            'status' => 'success',
            'code' => 200,
            'message' => 'Ok',
            $post
        );
        return response()->json($data, 200);


        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'title' => 'required ',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            $data = array(
                'status' => 'erorr',
                'code' => 400,
                'message' => 'error de datos al requerirlos '
            );
            return response()->json($data, 400);
        } else {
            DB::table('posts')->insert([
                'id_user' => $request->id_user,
                'title' => $request->title,
                'autor'=>$request->autor,
                'content' => $request->content,
                'image' => $request->image,

            ]);
            $data = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'se creo el un nuevo post'
            );
            return response()->json($data, 200);
        }

        //
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required ',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            $data = array(
                'status' => 'erorr',
                'code' => 400,
                'message' => 'error de datos al requerirlos '
            );
            return response()->json($data, 400);
        } else {
            $data = DB::table('posts')->where('id', $request->id)->update(
                [
                    'id_user' => $request->id_user,
                    'title' => $request->title,
                    'content' => $request->content,
                    'image' => $request->image,
                ]
            );

            $dataReturn = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'se actuliazo el post '
            );
            return response()->json($dataReturn, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        DB::table('posts')->where('id', $request->id)->delete();
        $data = array(
            'status' => 'success',
            'code' => 200,
            'message' => 'se elimino el post',

        );
        return response()->json($data, 200);
    }

    public function upload(Request $request)
    {
        $image = $request->file('file0');

        $validator = Validator::make($request->all(), [
            'file0' => 'required |image',

        ]);
        if (!$image | $validator->fails()) {
            $data = array(
                'status' => 'erorr',
                'code' => 400,
                'message' => 'error de datos al requerirlos '
            );
            return response()->json($data, 400);
        } else {

            $name_image = time() . $image->getClientOriginalName();
            Storage::disk('public')->put($name_image, file_get_contents($image));
            $dataReturn = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'se envio la image ',
                'image' => $name_image
            );
            return response()->json($dataReturn, 200);
        }
    }

    public function getImage($filename)
    {

        $setImage = Storage::disk('public')->exists($filename);
        $headers = [];
        if ($setImage) {

            $file = Storage::disk('public')->get($filename);


            return $file;
        } else {
            $data = array(
                'status' => 'erorr',
                'code' => 400,
                'message' => 'No encontro image '
            );
            return response()->json($data, 400);
        }
    }
}
