@extends('layouts.app')

@section('content')
    <div class="container">
        <card-component cardheader="Dashboard">
            <template v-slot:cardbody>
                <div class="card-body">
                    <home-component usuario="{{Auth::user()->name}}"></home-component>
                </div>
            </template>
        </card-component>
    </div>
@endsection
