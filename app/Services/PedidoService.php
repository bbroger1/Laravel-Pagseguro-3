<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;

class PedidoService 
{
    function efetuarPagamento($dadosPedido, $curso)
    {
        $response = Http::withHeaders([
            'Authorization' => config('pagseguro.token_sandbox'),
            'x-api-version' => config('pagseguro.api_version'),
        ])->post('https://sandbox.api.pagseguro.com/charges', [
            'reference_id' => Uuid::uuid4(),
            'description' => "Archer - $curso->nm_curso",
            'amount' => [
                'value' => str_replace(',', '', $curso->valor),
                'currency' => 'BRL',
            ],
            'payment_method' => [
                'type' => 'CREDIT_CARD',
                'installments' => $dadosPedido['parcelas'],
                'capture' => 'true',
                'card' => [
                    'encrypted' => $dadosPedido['encryptedCard'],
                ],
            ],
        ]);

        return $response;
    }

    function consultaCobrancaId($idPedido)
    {
        $response = Http::withHeaders([
            'Authorization' => config('pagseguro.token_sandbox'),
            'x-api-version' => config('pagseguro.api_version'),
        ])->get("https://sandbox.api.pagseguro.com/charges/$idPedido");

        return $response;
    }

    function consultaCobrancaReferencia($referenciaPedido)
    {
        $response = Http::withHeaders([
            'Authorization' => config('pagseguro.token_sandbox'),
            'x-api-version' => config('pagseguro.api_version'),
        ])->get("https://sandbox.api.pagseguro.com/charges?reference_id=$referenciaPedido");

        return $response;
    }

    function consultaNotificacao($idNotificacao)
    {
        $response = Http::get("https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/$idNotificacao?email=".config('pagseguro.email')."&token=".config('pagseguro.token_sandbox'));
        $jsonEncode = json_encode(simplexml_load_string($response));
        $jsonDecode = json_decode($jsonEncode);
        return $jsonDecode;
    }
}