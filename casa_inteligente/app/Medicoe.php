<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicoe extends Model
{
    protected $fillabel = [
        'valor',
        'data_horario'
    ];

    protected $guarded = [
        'id',
        'sensor_id',
        'created_at',
        'updated_at'
    ];

    public function  sen(){
        return $this->hasMany('App\Sensor');
    }

}
