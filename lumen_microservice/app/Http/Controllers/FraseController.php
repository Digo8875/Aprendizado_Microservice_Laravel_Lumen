<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

use App\User;
use App\Frase;

class FraseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator($request)
    {

        return $this->validate($request, [
            'texto' => ['bail', 'required', 'string', 'max:180'],
        ]);
    }

    public function store(Request $request){

        $response = null;

        try{
            $this->validator($request);
        }catch( ValidationException $erro){
            $response = [
                'result' => 'validation_error',
                'errors' => $erro->errors()
            ];

            return response()->json($response, 200);
        }

        try{

            $frase = new Frase;
            $frase->texto = $request->texto;
            $frase->id_user = auth()->user()->id;
            $frase->save();

        } catch( Exception $erro){
            report($erro);

            return response()->json('Server Error', 500);
        }
    }
}