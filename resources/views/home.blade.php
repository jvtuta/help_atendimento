@extends('layouts.app')

@section('content')
    <div class="container">
        <card-component >
            <template v-slot:cardheader>
                <div class="d-flex justify-content-between"> 
                    <span class="h4">Dashboard</span>
                    <span class="h4">{{ date('d/m/Y') }}</span>
                </div>   
            </template>
            <template v-slot:cardbody>
                <div class="card-body">
                    <home-component usuario="{{Auth::user()->name}}" funcao="{{strtolower(Auth::user()->nivel_usuario)}}" data="{{ date('d/m/Y') }}" usuario_id="{{Auth::user()->id}}"></home-component>
                </div>
            </template>
        </card-component>
    </div>
@endsection
