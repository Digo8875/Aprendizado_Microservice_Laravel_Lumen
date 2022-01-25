<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;
use GuzzleHttp\Exception\RequestException;


class Microservice_testeController extends Controller
{

    public function teste_request()
    {
        try{
            $user = auth()->user();

            $data = [
                'dado1' => 'dados 1',
                'dado2' => 7,
                'user' => $user->toarray()
            ];

            $url = null;

            if(app()->environment() == 'production'){
                $url = "";
            }
            else{
                $url = "localhost:9000/teste_request";
            }

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', $url, [
                'headers' => [
                    'User-Agent' => 'microservice_teste/1.0',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer YWxhZGRpbjpvcGVuc2VzYW1l'
                ],
                'form_params' => $data,
                'query' => 'foo=bar'
            ]);

            $result = json_decode($response->getBody(), true);

            // dd($response->getHeaders());
            // dd($response->getStatusCode());
            // dd($response->getReasonPhrase());
            dd($result);
        }catch(Exception $erro){
            report($erro);
        }
    }

    public function create_new_account(){

        $user = auth()->user();

        if(is_null($user->microservice_token)){

            $url = null;

            if(app()->environment() == 'production'){
                $url = "";
            }
            else{
                $url = "localhost:9000/new_user";
            }

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', $url, [
                'headers' => [
                    'User-Agent' => 'microservice_teste/1.0',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.env('SYS_ACCESS_TOKEN'),
                    'JWT-Token' => $this->gerar_jwt(),
                ]
            ]);

            $result = json_decode($response->getBody(), true);


            $user->microservice_token = $result['user_token'];
            $user->save();

            session()->flash('message', 'Ação efetuada com sucesso.');
            session()->flash('message_type', 'success');
            return redirect()->route('home');

        }
        else{

            session()->flash('message', 'Você já está integrado com o microservice!');
            session()->flash('message_type', 'danger');
            return redirect()->back();
        }
    }

    public function gerar_frase(){

        $user = auth()->user();

        if(!is_null($user->microservice_token)){

            $url = null;

            if(app()->environment() == 'production'){
                $url = "";
            }
            else{
                $url = "localhost:9000/api/v1/gerar_frase";
            }

            try{
                $client = new \GuzzleHttp\Client();
                $response = $client->request('POST', $url, [
                    'headers' => [
                        'User-Agent' => 'microservice_teste/1.0',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer '.env('SYS_ACCESS_TOKEN'),
                        'JWT-Token' => $this->gerar_jwt(),
                    ],
                    'form_params' => [
                        'api_token' => $user->microservice_token
                    ],
                    'path'  => request()->url(),
                    'query' => request()->query(),
                ]);

                $result = json_decode($response->getBody(), true);

                session()->flash('message', 'Ação efetuada com sucesso.');
                session()->flash('message_type', 'success');
                return redirect()->route('home');

            }catch( RequestException  $erro){
                if($erro->getCode() == 0){
                    session()->flash('message', $erro->getHandlerContext()['error']);
                    session()->flash('message_type', 'danger');
                    return redirect()->route('home');

                    dd($erro->getHandlerContext()['error']);
                }
                else{
                    session()->flash('message', $erro->getResponse()->getReasonPhrase());
                    session()->flash('message_type', 'danger');
                    return redirect()->route('home');
                }
            }catch( Exception $erro){
                session()->flash('message', 'Você já está integrado com o microservice!');
                session()->flash('message_type', 'danger');
                return redirect()->route('home');

                dd($erro);
            }

        }
        else{

            dd('Primeiro você deve integrar com o microservice!');
        }
    }

    public function get_user_frases(){

        $user = auth()->user();

        if(!is_null($user->microservice_token)){

            $url = null;

            if(app()->environment() == 'production'){
                $url = "";
            }
            else{
                $url = "localhost:9000/api/v1/get_user_frases";
            }

            $query = request()->query();
            $query['api_token'] = $user->microservice_token;
            $query['qtd_paginate'] = 4;

            try{
                $client = new \GuzzleHttp\Client();
                $response = $client->request('GET', $url, [
                    'headers' => [
                        'User-Agent' => 'microservice_teste/1.0',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer '.env('SYS_ACCESS_TOKEN'),
                        'JWT-Token' => $this->gerar_jwt(),
                    ],
                    'path' => request()->path(),
                    'query' => $query
                ]);

                $result = json_decode($response->getBody(), true);

                $lista_objs = (new LengthAwarePaginator($result['items'], $result['total'], $result['perPage'], $result['currentPage'], [
                    'path'  => request()->url(),
                    'query' => request()->query(),
                ]))->onEachSide(3);

                return view('listar_user_frases', ['lista_objs' => $lista_objs]);

            }catch( RequestException  $erro){
                if($erro->getCode() == 0){
                    session()->flash('message', $erro->getHandlerContext()['error']);
                    session()->flash('message_type', 'danger');
                    return redirect()->route('home');

                    dd($erro->getHandlerContext()['error']);
                }
                else{
                    session()->flash('message', $erro->getResponse()->getReasonPhrase());
                    session()->flash('message_type', 'danger');
                    return redirect()->route('home');
                }
            }catch( Exception $erro){
                session()->flash('message', 'Você já está integrado com o microservice!');
                session()->flash('message_type', 'danger');
                return redirect()->route('home');

                dd($erro);
            }

        }
        else{

            dd('Primeiro você deve integrar com o microservice!');
        }
    }

    public function gerar_jwt(){

        $jwt_header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];
        $jwt_payload = [
            'access_token' => env('SYS_ACCESS_TOKEN')
        ];

        $jwt_key = env('SYS_KEY').':'.env('SYS_SECRET');

        //JSON
        $header = json_encode($jwt_header);
        $payload = json_encode($jwt_payload);

        //Base 64
        $header = base64_encode($header);
        $payload = base64_encode($payload);
        $key = base64_encode($jwt_key);

        //Sign
        $sign = hash_hmac('sha256', $header . "." . $payload, $key, true);
        $sign = base64_encode($sign);

        //Token
        $token = $header . '.' . $payload . '.' . $sign;

        return $token;
    }
}
