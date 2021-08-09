@extends('layouts.app')

@section('content')
    <div class="container">
        <card-component cardheader="Dashboard">
            <template v-slot:cardbody>
                <div class="card-body">
                    teste
                </div>
            </template>
        </card-component>
    </div>
@endsection
