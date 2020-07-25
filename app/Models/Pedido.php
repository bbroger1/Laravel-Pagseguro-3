<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['uuid', 'pagseguro_id', 'pagseguro_status', 'total', 'parcelas'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = sprintf("%.2f", $value/100);
    }

    public function setPagseguroStatusAttribute($value)
    {
        switch ($value) {
            case 1:
            case 'WAITING':
                $status = 'Aguardando pagamento';
                break;
            case 2: 
                $status = 'Em análise';
                break;
            case 3:
            case 'PAID':
                $status = 'Paga';
                break;
            case 4: 
                $status = 'Disponível';
                break;
            case 5: 
                $status = 'Em disputa';
                break;
            case 6:
            case 'CANCELED':
                $status = 'Devolvida';
                break;
            case 7:
            case 'DECLINED':
                $status = 'Cancelada';
                break;
            case 9:
                $status = 'Em contestação';
                break;
            case 10:
                $status = 'Em devolução';
                break;
            default:
                $status = $value;
                break;
        }
        $this->attributes['pagseguro_status'] = $status;
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i');
    }

    public function getTotalAttribute($value)
    {
        return str_replace('.', ',', $value);
    }

    public function scopeAutenticado($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function scopePago($query)
    {
        return $query->where('pagseguro_status', 'Paga');
    }

    public function scopeRecusado($query)
    {
        return $query->where('pagseguro_status', 'Cancelada');
    }

    public function scopeReembolsado($query)
    {
        return $query->where('pagseguro_status', 'Devolvida');
    }

    public function isRecusado()
    {
        return $this->pagseguro_status == 'Cancelada';
    }
}
