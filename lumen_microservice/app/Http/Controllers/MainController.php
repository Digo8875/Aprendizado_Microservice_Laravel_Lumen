<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\User;
use App\Frase;
use App\Sys_connection;

class MainController extends Controller
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

    public function teste_request(Request $request){

        $response = [
            'header' => $request->header(),
            'method' => $request->method(),
            'url' => $request->url(),
            'fullUrl' => $request->fullUrl(),
            'path' => $request->path(),
            'bearerToken' => $request->bearerToken(),
            'request_ip' => $request->ip(),
            'getAcceptableContentTypes' => $request->getAcceptableContentTypes(),
            'request_puro' => $request,
            'request_all' => $request->all(),
            'request_input' => $request->input(),
            'request_query' => $request->query(),
            'request_user' => $request->user,
            'sys_key' => strtoupper(md5(uniqid(rand(10, rand(10, 99999999)), true))),
            'sys_secret' => strtoupper(md5(uniqid(rand(10, rand(10, 99999999)), true))),
            'sys_access_token' => strtoupper(md5(uniqid(rand(10, rand(10, 99999999)), true)))
        ];

        return response()->json($response, 200);
    }

    public function new_user(Request $request){

        $sys_connection = Sys_connection::where('sys_access_token', '=', $request->bearerToken())->first();

        $user = new User;

        $new_api_token = null;
        do{
            $new_api_token = strtoupper(md5(uniqid(rand(10, rand(10, 99999999)), true)));
            $has_user_api_token = User::where('api_token', '=', $new_api_token)->first();
        }while(!is_null($has_user_api_token));

        // $user->api_token = Str::random(80);
        $user->api_token = $new_api_token;
        $user->id_sys_connection = $sys_connection->id;
        $user->save();

        $response = [
            'user_token' => $user->api_token
        ];

        return response()->json($response, 200);
    }

    public function gerar_frase(Request $request){

        $response = [
            'message' => null
        ];

        $user = auth()->user();

        $frase = new Frase;
        $frase->texto = Str::random(60);
        $frase->id_user = $user->id;
        $frase->save();

        $response['message'] = 'Success';

        return response()->json($response, 200);
    }

    public function get_user_frases(Request $request){

        $user = auth()->user();

        $lista_frases = $user->frases()->paginate($request->qtd_paginate);


        $query_response = request()->query();
        if($request->has('api_token'))
            unset($query_response['api_token']);

        $response = [
            'items' => $lista_frases->items(),
            'total' => $lista_frases->total(),
            'perPage' => $lista_frases->perPage(),
            'currentPage' => $lista_frases->currentPage(),
            'path' => request()->url(),
            'query' => $query_response,
        ];
        return response()->json($response, 200);
    }
}