@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="row justify-content-center mt-2">
                        <div class="col-12 d-flex justify-content-center align-items-center text-center mb-3">
                            <a class="btn btn-primary p-1" href="{{ route('home') }}">
                                {{ __('Home') }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-header">{{ __('Listagem de Frases') }}</div>

                    <div class="card-body">
                        
                        <div class="col-12 d-flex justify-content-center">
                            {{ $lista_objs->links() }}
                        </div>
        
                        <table class='table table-striped table-responsive-xl rounded title table-hover'>
                            <thead class='rounded thead-dark'>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">{{ __('Texto')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($lista_objs) < 1)
                                <tr>
                                    <td class="text-center" colspan="2">{{ "Não há registros no sistema!" }}</td>
                                </tr>
                            @else
                                @for($i = 0; $i < count($lista_objs); $i++)
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle;">{{ $i + 1 }}</td>
                                        <td class="text-center" style="vertical-align: middle;">{{ $lista_objs[$i]['texto'] }}</td>
                                    </tr>
                                @endfor
                            @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
