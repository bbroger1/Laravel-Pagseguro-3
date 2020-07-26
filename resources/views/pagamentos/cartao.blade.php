@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card text-center">
                <div class="card-header">
                    <i class="fas fa-credit-card"></i> Cartão de Crédito
                </div>
                <div class="card-body">
                    <form name="formPagamento" id="formPagamento" action="{{route('pagamento.processamento.cartao')}}"
                        method="post">
                        @csrf

                        <div class="row justify-content-center">
                            <div class="col-9 form-group">
                                <label>Nome no Cartão</label>
                                <input type="text" class="form-control @error('card_holder') is-invalid @enderror"
                                    name="card_holder" id="card_holder" value="{{old('card_holder')}}">

                                @error('card_holder')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="col-9 form-group">
                                <label>Número do Cartão <span class="brand"></span></label>
                                <input type="text" class="form-control @error('card_number') is-invalid @enderror"
                                    name="card_number" id="card_number" value="{{old('card_number')}}" maxlength="16">

                                @error('card_number')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-3 form-group">
                                <label>Mês de Expiração</label>
                                <select class="form-control @error('card_month') is-invalid @enderror" name="card_month" id="card_month">
                                    @for ($i = 1; $i <= 12; $i++) <option value="{{sprintf('%02d', $i)}}">
                                        {{sprintf('%02d', $i)}}
                                        </option>
                                        @endfor
                                </select>

                                @error('card_month')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="col-3 form-group">
                                <label>Ano de Expiração</label>
                                <select class="form-control @error('card_year') is-invalid @enderror" name="card_year" id="card_year" required>
                                    @for ($i = 0; $i <= 9; $i++) <option value="{{now()->year+$i}}">{{now()->year+$i}}
                                        </option>
                                        @endfor
                                </select>

                                @error('card_year')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="col-3 form-group">
                                <label>CVV</label>
                                <input type="text" class="form-control @error('card_cvv') is-invalid @enderror"
                                    name="card_cvv" id="card_cvv" value="{{old('card_cvv')}}">

                                @error('card_cvv')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-5 form-group">
                                <label>Valor total</label>
                                <h2>R$ 19,90</h2>
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Quantidade de parcelas</label>
                                <select class="form-control" name="parcelas" id="parcelas">
                                    @for ($i = 1; $i <= 12; $i++) <option value="{{$i}}">{{$i}}x de
                                        R${{number_format(19.90/$i, 2, ',', '.')}}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-4 form-group">
                                <input type="hidden" class="form-control" name="encryptedCard" id="encryptedCard"
                                    readonly="true">
                                <label></label>
                                <button id="submit" name="submit" class="form-control btn btn-primary btn-lg"
                                    dusk="confirmar-button">Confirmar
                                    Pagamento</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://assets.pagseguro.com.br/checkout-sdk-js/rc/dist/browser/pagseguro.min.js"></script>

<script>
    $(function () {
    $("#card_number").mask("0000 0000 0000 0000");
    $("#card_cvv").mask("0009");

    $("#formPagamento").submit(function(e){
        var encrypted = criptografar();
        if(encrypted != null){
            $('#encryptedCard').val(encrypted);
            return true;
        } else {
            $(".spinner").fadeOut();
            return false; 
        }
    });
});
</script>

<script src="{{asset('js/pagseguro/criptografia.js')}}"></script>
@endsection