@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="jumbotron text-center">
                <h1 class="display-4"><i class="far fa-times-circle fa-2x"></i></h1>
                <h1 class="display-4">Ops, algo saiu errado!</h1>
                <p class="lead">Sentimos muito, mas o seu pagamento não pôde ser completado com sucesso.</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg mt-3" href="{{route('inicio')}}" role="button">Tentar novamente</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection