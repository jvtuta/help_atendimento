@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <card-component cardheader="Registrar">
                <template v-slot:cardbody>
                    <register-component 
                        action="{{route('home')}}"
                        csrf_token="{{csrf_token()}}"
                    >
                    </register-component>          
                </template>
            </card-component>
        </div>
    </div>

@endsection
