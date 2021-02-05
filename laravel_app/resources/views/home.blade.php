@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="col-sm-12">
                            <div class="alert alert-{{session('message_type')}} alert-dismissible fade show" role="alert">
                                {{ session('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <div class="row justify-content-center">
                        <div class="col-12 d-flex justify-content-center align-items-center text-center mb-3">
                            <a class="btn btn-primary p-1" href="{{ route('teste_request') }}">
                                {{ __('Teste Request') }}
                            </a>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-12 d-flex justify-content-center align-items-center text-center mb-3">
                            <a class="btn btn-primary p-1" href="{{ route('new_account_microservice_teste') }}">
                                {{ __('Criar nova conta microservice') }}
                            </a>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-12 d-flex justify-content-center align-items-center text-center mb-3">
                            <a class="btn btn-primary p-1" href="{{ route('gerar_frase') }}">
                                {{ __('Gerar frase') }}
                            </a>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-12 d-flex justify-content-center align-items-center text-center mb-3">
                            <a class="btn btn-primary p-1" href="{{ route('get_user_frases') }}">
                                {{ __('Visualizar minhas frases') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
