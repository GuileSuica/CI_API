<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicao extends Model
{
    protected $table = [
        'medicoes',
    ];

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

}
