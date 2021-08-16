@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <card-component cardheader="Registrar">
                <template v-slot:cardbody>
                    <register-component 
                        action="{{route('register')}}"
                        csrf_token="{{csrf_token()}}"
                    >
                    </register-component>          
                </template>
            </card-component>
        </div>
    </div>

@endsection
