<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model {
    public $timestamps = false;  // 👈 agregar esta línea
    protected $fillable = ['cliente_id', 'es_mostrador', 'total', 'created_at'];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function detalles() {
        return $this->hasMany(VentaDetalle::class);
    }
}