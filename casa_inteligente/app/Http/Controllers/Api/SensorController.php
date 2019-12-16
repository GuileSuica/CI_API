<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sensor;

class SensorController extends Controller
{
    public function index()
    {
    	return Sensor::all();
    }
    public function store(Request $request)
    {
        Sensor::create($request->all());
    }
}
