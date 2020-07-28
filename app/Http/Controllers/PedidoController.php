<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BoletoRequest;
use App\Http\Requests\CartaoRequest;
use App\Services\PedidoService;
use App\Pedido;

class PedidoController extends Controller
{
    protected $pedidoService;

    public function __construct(PedidoService $pedidoService)
    {
        $this->pedidoService = $pedidoService;
    }

    public function exibirBoleto()
    {
        return view('pagamentos.boleto');
    }

    public function exibirCartao()
    {
        return view('pagamentos.cartao');
    }

    public function processarBoleto(BoletoRequest $request)
    {
        $dadosPedido = $request->validated();
        $response = $this->pedidoService->efetuarPagamentoBoleto($dadosPedido);
        if ($response->clientError()) {
            return back()->withInput()->with('error', 'Ocorreu um erro durante o processamento. Por favor verifique se todos os dados estão corretos.');
        }
        if ($response->serverError()) {
            return back()->withInput()->with('error', 'Ocorreu um erro durante o processamento. Por favor tente de novo após alguns minutos.');
        }

        $pedidoCriado = $this->criarPedido($response);
        if ($pedidoCriado->isRecusado()) {
            return redirect()->route('pagamento.falha');
        }
        return redirect()->route('pagamento.sucesso', $pedidoCriado);
    }

    public function processarCartao(CartaoRequest $request)
    {
        $dadosPedido = $request->validated();
        $response = $this->pedidoService->efetuarPagamentoCartao($dadosPedido);
        if ($response->clientError()) {
            return back()->withInput()->with('error', 'Ocorreu um erro durante o processamento. Por favor verifique se todos os dados estão corretos.');
        }
        if ($response->serverError()) {
            return back()->withInput()->with('error', 'Ocorreu um erro durante o processamento. Por favor tente de novo após alguns minutos.');
        }

        $pedidoCriado = $this->criarPedido($response);
        if ($pedidoCriado->isRecusado()) {
            return redirect()->route('pagamento.falha');
        }
        return redirect()->route('pagamento.sucesso', $pedidoCriado);
    }

    public function criarPedido($response)
    {
        $dadosPagseguro = [
            'uuid' => $response['reference_id'],
            'pagseguro_id' => substr($response['id'], 5),
            'pagseguro_status' => $response['status'],
            'pagseguro_type' => $response['payment_method']['type'],
            'total' => $response['amount']['value'],
            'parcelas' => $response['payment_method']['installments'] ?? null,
        ];
        return auth()->user()->pedidos()->create($dadosPagseguro);
    }

    public function exibirSucesso(Pedido $pedido)
    {
        return view('pagamentos.sucesso', compact('pedido'));
    }

    public function exibirFalha()
    {
        return view('pagamentos.falha');
    }

    public function receberStatus(Request $request)
    {
        $idNotificacao = $request->notificationCode;
        $response = $this->pedidoService->consultaNotificacao($idNotificacao);
        $pedido = Pedido::where('uuid', $response->reference)->firstOrFail();
        $pedido->pagseguro_status = $response->status;
        $pedido->save();
    }
}
