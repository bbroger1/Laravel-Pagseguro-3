@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="jumbotron text-center">
                <h1 class="display-4"><i class="far fa-check-circle fa-2x"></i></h1>
                <h1 class="display-4">Sucesso!</h1>
                <p class="lead">Seu pedido de Nº {{$pedido->uuid}} no valor de R${{$pedido->total}} foi processado com sucesso.</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg mt-3" href="{{route('usuario.pedidos')}}" role="button">Detalhes do pedido</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection