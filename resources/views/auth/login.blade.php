@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center" style="height: 760px;">
            <div class="col-md-4 col-sm-12">
                <card-component cardheader="Login">
                    <template v-slot:cardbody>
                        <div class="card-body p-4">
                            <login-component action="{{ route('login') }}" csrf_token={{ csrf_token() }} >
                            </login-component>
                        </div>
                    </template>
                </card-component>
            </div>
        </div>
        <div class="row justify-content-center">
            <footer class="text-center"> 
                Desenvolvido por joao@memoriaram.com.br
            </footer>
        </div>
    </div>
    
@endsection
