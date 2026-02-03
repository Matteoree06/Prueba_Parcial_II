<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto_Financiero extends Model
{
    use HasFactory; 
    protected $table = 'producto_financiero';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'nombre', 'descripcion', 'costo', 'porcentaje_retorno', 'activo'];

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
