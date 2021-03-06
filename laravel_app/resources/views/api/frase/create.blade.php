@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('api_frase.store') }}" enctype="multipart/form-data" accept="image/*">
                        @csrf

                        <div class="form-group row">
                            <label for="texto" class="col-md-4 col-form-label text-md-right ">{{ __("Texto") }}</label>

                            <div class="col-md-6">
                                <input id="texto" type="text" class="form-control @error('texto') is-invalid @enderror" name="texto" value="{{ old('texto') }}" placeholder="" maxlength="180">

                                @error("texto")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center mb-0 mt-5">
                            <div class="col-md-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary px-4">
                                    {{ __("Cadastrar") }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
