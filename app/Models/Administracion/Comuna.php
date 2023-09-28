<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
    protected $guarded = [];

    public function Region()
    {
        return $this->belongsTo(Region::class);
    }
}
