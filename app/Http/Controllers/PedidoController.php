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

    public function index()
    {
        return view('pedido.pagamento');
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
