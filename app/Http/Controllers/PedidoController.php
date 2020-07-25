<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PedidoRequest;
use App\Services\PedidoService;
use App\Models\Pedido;

class PedidoController extends Controller
{
    protected $pedidoService;

    public function __construct(PedidoService $pedidoService)
    {
        $this->pedidoService = $pedidoService;
    }

    public function exibirBoleto()
    {
        return view('pagamento.boleto');
    }

    public function exibirCartao()
    {
        return view('pagamento.cartao');
    }

    public function processarCartao(PedidoRequest $request)
    {
        $dadosPedido = $request->validated();
        $response = $this->pedidoService->efetuarPagamento($dadosPedido);
        if ($response->clientError()) {
            return back()->withInput()->with('error', 'Ocorreu um erro durante o processamento. Por favor verifique se todos os dados estão corretos.');
        }
        if ($response->serverError()) {
            return back()->withInput()->with('error', 'Ocorreu um erro durante o processamento. Por favor tente de novo após alguns minutos.');
        }

        $pedidoCriado = $this->criarPedido($dadosPedido, $response);
        if ($pedidoCriado->isRecusado()) {
            return redirect()->route('pagamento.falha');
        }
        return redirect()->route('pagamento.sucesso', $pedidoCriado);
    }

    public function exibirSucesso(Pedido $pedido)
    {
        return view('pedido.sucesso', compact('pedido'));
    }

    public function exibirFalha()
    {
        return view('pedido.falha');
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
