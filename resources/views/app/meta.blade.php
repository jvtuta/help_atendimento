@extends('layouts.app')

@section('content')
    <meta-component action="{{ route('metas') }}" csrf_token="{{ csrf_token() }}" data="{{ date('d/m/Y') }}"
     visualizar_imports="{{ $visualizar }}" imports={{ $importar }}>

    </meta-component>
@endsection
