<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DosaItem extends Model
{
    public function dosa()
    {
        return $this->belongsTo('App\Dosa');
    }
}
