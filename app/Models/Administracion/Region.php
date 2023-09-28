<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regiones';

    public function Comuna()
    {
        return $this->hasMany(Comuna::class);
    }
}
