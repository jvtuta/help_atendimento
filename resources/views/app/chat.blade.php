@extends('layouts.app')

@section('content')
    <chat-component 
        csrf_token="{{csrf_token()}}" 
        logout="{{route('logout')}}" 
        >
    </chat-component>
@endsection
