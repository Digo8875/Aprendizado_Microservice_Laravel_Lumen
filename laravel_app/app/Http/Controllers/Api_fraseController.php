<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class Api_fraseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('api.frase.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if(!is_null($user->microservice_token)){

            $url = null;

            if(app()->environment() == 'production'){
                $url = "";
            }
            else{
                $url = "localhost:9000/api/v1/frase";
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
                    'form_params' => array_merge([
                        'api_token' => $user->microservice_token
                    ], $request->all()),
                    'path'  => request()->url(),
                    'query' => request()->query(),
                ]);

                $result = json_decode($response->getBody(), true);

                if($result['result'] == 'validation_error')
                    return back()->withErrors($result['errors'])->withInput();

                session()->flash('message', 'Ação efetuada com sucesso.');
                session()->flash('message_type', 'success');
                return redirect()->route('home');

            }catch( RequestException  $erro){
                report($erro);
                
                if($erro->getCode() == 0){
                    session()->flash('message', 'Sistema inacessível no momento.');
                    session()->flash('message_type', 'danger');
                    return redirect()->route('home');

                    dd($erro->getHandlerContext()['error']);
                }
                else{
                    session()->flash('message', 'Não foi possível executar a ação.');
                    session()->flash('message_type', 'danger');
                    return redirect()->route('home');

                    dd($erro->getResponse()->getReasonPhrase());
                }
            }catch( Exception $erro){
                session()->flash('message', 'Não foi possível executar a ação.');
                session()->flash('message_type', 'danger');
                return redirect()->route('home');

                dd($erro);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
