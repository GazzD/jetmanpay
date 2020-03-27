<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title', 'message', 'created_at', 'updated_at'
    ];
    public function payments()
    {
        return $this->belongsToMany('App\Payment');
    }
}
