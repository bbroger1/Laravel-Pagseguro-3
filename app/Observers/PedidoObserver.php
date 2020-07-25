<?php

namespace App\Observers;

use App\Pedido;

class PedidoObserver
{
    /**
     * Handle the pedido "created" event.
     *
     * @param  \App\Pedido  $pedido
     * @return void
     */
    public function created(Pedido $pedido)
    {
        //
    }

    /**
     * Handle the pedido "updated" event.
     *
     * @param  \App\Pedido  $pedido
     * @return void
     */
    public function updated(Pedido $pedido)
    {
        //
    }

    /**
     * Handle the pedido "deleted" event.
     *
     * @param  \App\Pedido  $pedido
     * @return void
     */
    public function deleted(Pedido $pedido)
    {
        //
    }

    /**
     * Handle the pedido "restored" event.
     *
     * @param  \App\Pedido  $pedido
     * @return void
     */
    public function restored(Pedido $pedido)
    {
        //
    }

    /**
     * Handle the pedido "force deleted" event.
     *
     * @param  \App\Pedido  $pedido
     * @return void
     */
    public function forceDeleted(Pedido $pedido)
    {
        //
    }
}
