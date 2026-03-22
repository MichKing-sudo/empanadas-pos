<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model {
    public $timestamps = false;
    protected $fillable = ['nombre', 'categoria', 'precio', 'disponible'];

    public function ventaDetalles() {
        return $this->hasMany(VentaDetalle::class);
    }

    // Regla: no se puede borrar si tiene ventas
    public function tieneVentas() {
        return $this->ventaDetalles()->exists();
    }
}