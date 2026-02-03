<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'nombre', 'email', 'capital_disponible'];


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
