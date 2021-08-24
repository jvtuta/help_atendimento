@extends('layouts.app')

@section('content')
    <reset-password-component csrf_token="{{ csrf_token() }}" usuario="{{ Auth::user()->id}}">

    </reset-password-component>
@endsection