<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sensor;

class SensorController extends Controller
{
	private $sensors;

	public function __construct(Sensor $sensors)
	{
		$this->sensors = $sensors;
	}
	public function index()
    {
    	return response()->json($this->sensors->all());
    }
    public function show($id)
    {
    	$sensors = $this->sensors->find($id);
    	if(! $sensors) return response()->json(ApiError::errorMessage('Sensor não encontrado!', 4040), 404);
    	$data = ['data' => $sensors];
	    return response()->json($data);
    }
    public function store(Request $request)
    {
		try {
			$sensorsData = $request->all();
			$this->sensors->create($sensorsData);
			$return = ['data' => ['msg' => 'Sensor criado com sucesso!']];
			return response()->json($return, 201);
		} catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 1010), 500);
			}
			return response()->json(ApiError::errorMessage('Houve um erro ao realizar operação de salvar', 1010),  500);
		}
    }
	public function update(Request $request, $id)
	{
		try {
			$sensorsData = $request->all();
			$sensors     = $this->sensors->find($id);
			$sensors->update($sensorsData);
			$return = ['data' => ['msg' => 'Sensor atualizado com sucesso!']];
			return response()->json($return, 201);
		} catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 1011),  500);
			}
			return response()->json(ApiError::errorMessage('Houve um erro ao realizar operação de atualizar', 1011), 500);
		}
	}
	public function delete(Sensor $id)
	{
		try {
			$id->delete();
			return response()->json(['data' => ['msg' => 'Produto: ' . $id->name . ' removido com sucesso!']], 200);
		}catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 1012),  500);
			}
			return response()->json(ApiError::errorMessage('Houve um erro ao realizar operação de remover', 1012),  500);
		}
	}
}
