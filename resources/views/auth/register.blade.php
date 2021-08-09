@extends('layouts.app')

@section('content')
<container-component>
    <template>
    <row-center-component>
        <template>
                <card-component cardheader="Registar">
                    <template v-slot:cardbody>
                        <card-body-component>
                        <template>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
    
                            <div class="mb-2 row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nome</label>
    
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nome">
    
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="mb-2 row">
                                <label for="nome_usuario" class="col-md-4 col-form-label text-md-right">Login</label>
    
                                <div class="col-md-6">
                                    <input id="nome_usuario" type="text" class="form-control @error('nome_usuario') is-invalid @enderror" name="nome_usuario" value="{{ old('nome_usuario') }}" required autocomplete="nome_usuario" placeholder="Nome de Usuário">
    
                                    @error('nome_usuario')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="mb-2 row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Senha</label>
    
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Senha">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="mb-2 row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar senha</label>
    
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Senha">
                                </div>
                            </div>
    
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Registrar
                                    </button>
                                </div>
                            </div>
                        </form>
                        </template>
                        </card-body-component>
                    </template>
                </card-component>
        </template>
    </row-center-component>
    </template>
</container-component>

       
@endsection
