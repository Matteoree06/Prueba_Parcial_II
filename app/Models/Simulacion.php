<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Simulacion extends Model
{
    protected $table = 'simulaciones';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'usuario_id', 'fecha_simulacion', 'capital_disponible', 'ganancia_total'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model){
            if(empty($model->id)){
                $model->id = (string) Str::uuid();
            }
        });
    }
}
