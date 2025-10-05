<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';
    protected $primaryKey = 'id_estado';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['nombre_estado'];

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'id_estado', 'id_estado');
    }
}
