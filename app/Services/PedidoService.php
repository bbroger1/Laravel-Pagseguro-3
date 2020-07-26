<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;

class PedidoService 
{
    function efetuarPagamentoBoleto($dadosPedido)
    {
        $response = Http::withHeaders([
            'Authorization' => config('pagseguro.token'),
            'x-api-version' => config('pagseguro.api_version'),
        ])->post(config('pagseguro.endpoint').'charges', [
            'reference_id' => Uuid::uuid4(),
            'description' => config('pagseguro.description'),
            'amount' => [
                'value' => config('pagseguro.value'),
                'currency' => config('pagseguro.currency'),
            ],
            'payment_method' => [
                'type' => 'BOLETO',
                'boleto' => [
                    'due_date' => now()->addDays(3),
                    'instruction_lines' => [
                        'line_1' => 'Descrição linha 1',
                        'line_2' => 'Via PagSeguro',
                    ],
                    'holder' => [
                        'name' => $dadosPedido['nome'],
                        'tax_id' => $dadosPedido['cpf'],
                        'email' => $dadosPedido['email'],
                        'address' => [
                            'country' => 'Brasil',
                            'region' => $dadosPedido['estado'],
                            'region_code' => $dadosPedido['sigla'],
                            'city' => $dadosPedido[''],
                            'postal_code' => $dadosPedido['cep'],
                            'street' => $dadosPedido[''],
                            'number' => $dadosPedido[''],
                            'locality' => $dadosPedido['bairro'],
                        ],
                    ],
                ],
            ],
        ]);

        return $response;
    }

    function efetuarPagamentoCartao($dadosPedido)
    {
        $response = Http::withHeaders([
            'Authorization' => config('pagseguro.token'),
            'x-api-version' => config('pagseguro.api_version'),
        ])->post(config('pagseguro.endpoint').'charges', [
            'reference_id' => Uuid::uuid4(),
            'description' => config('pagseguro.description'),
            'amount' => [
                'value' => config('pagseguro.value'),
                'currency' => config('pagseguro.currency'),
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

    function efetuarReembolso($idPedido)
    {
        $response = Http::withHeaders([
            'Authorization' => config('pagseguro.token'),
            'x-api-version' => config('pagseguro.api_version'),
        ])->post("https://sandbox.api.pagseguro.com/charges/$order->pagseguro_code/cancel", [
            'amount' => [
                'value' => '',
            ],
        ]);
    }

    function consultarCobrancaId($idPedido)
    {
        $response = Http::withHeaders([
            'Authorization' => config('pagseguro.token'),
            'x-api-version' => config('pagseguro.api_version'),
        ])->get(config('pagseguro.endpoint')."charges/$idPedido");

        return $response;
    }

    function consultarCobrancaReferencia($referenciaPedido)
    {
        $response = Http::withHeaders([
            'Authorization' => config('pagseguro.token'),
            'x-api-version' => config('pagseguro.api_version'),
        ])->get(config('pagseguro.endpoint')."charges?reference_id=$referenciaPedido");

        return $response;
    }

    function consultarNotificacao($idNotificacao)
    {
        $response = Http::get("https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/$idNotificacao?email=".config('pagseguro.email')."&token=".config('pagseguro.token'));
        $jsonEncode = json_encode(simplexml_load_string($response));
        $jsonDecode = json_decode($jsonEncode);
        return $jsonDecode;
    }
}