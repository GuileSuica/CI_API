<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $fillable = [
        'nome', 'tipo',
    ];
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function med(){
        return $this->belongsTo('App\Medicao');
    }
    
}
