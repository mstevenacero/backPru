<?php

namespace App\Http\Controllers;

use App\Models\autor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post =  DB::table('autors')->get();

        $data = array(
            'status' => 'success',
            'code' => 200,
            'message' => 'Ok',
            'data'=> $post
        );
        return response()->json($data, 200);
    }

    public function getOne(Request $request)
    {
        $id = $request->id;

        $user_data = autor::where('id', $id)->get();
        if (!empty($user_data)) {
            $data = array(
                'menssage' => 'usuario encontrado',
                'code' => 200,
                'data'=>$user_data
            );
        } else {
            $data = array(
                'menssage' => 'usuario no encontrado',
                'code' => 400,

            );
        }
        //
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required ',

        ]);
        if ($validator->fails()) {
            $data = array(
                'status' => 'erorr',
                'code' => 400,
                'message' => 'error de datos al requerirlos '
            );
            return response()->json($data, 400);
        } else {
            DB::table('autors')->insert([
                'name' => $request->name,
                'surname' => $request->surname,

            ]);
            $data = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'se creo el un nuevo usuario'
            );
            return response()->json($data, 200);
        }
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required ',
        ]);
        if ($validator->fails()) {
            $data = array(
                'status' => 'erorr',
                'code' => 400,
                'message' => 'error de datos al requerirlos '
            );
            return response()->json($data, 400);
        } else {
            $data = DB::table('autors')->where('id', $request->id)->update(
                [
                    'name' => $request->name,
                    'surname' => $request->surname,
                ]
            );

            $dataReturn = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'se actualizo el usuario '
            );
            return response()->json($dataReturn, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\autor  $autor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        DB::table('autors')->where('id', $request->id)->delete();
        $data = array(
            'status' => 'success',
            'code' => 200,
            'message' => 'se elimino el usuario',

        );
        return response()->json($data, 200);
    }
}
