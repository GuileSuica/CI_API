<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sensor;
use Illuminate\Support\Facades\Validator;

class SensorController extends Controller
{
	private $sensors;

	public function __construct(Sensor $sensors)
	{
		$this->sensors = $sensors;
	}
    public function index()
    {
        if(sizeof($this->sensors->all()) <= 0 ){
            return response()->json(['data' => ['msg' => 'Nenhum sensor cadastrado']], 404);
        }
        else{
            return response()->json($this->sensors->all());
        }
    }
    public function show($id)
    {
        $validator = Validator::make($id,[
            'id' => 'required|number'
        ]);
        if($validator->errors()){
            return response()->json($validator->errors(), 404);
        }

    	$sensors = $this->sensors->find($id);
    	if(is_null($sensors)) return response()->json(['data'=>['msg'=>'Sensor não encontrado!']], 404);
    	$data = ['data' => $sensors];
	    return response()->json($data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|min:2|max:50',
            'tipo' => 'in:temperatura, luminosidade, presença, magnético|required|min:8|max:10'
        ]);

        if($validator->errors()){
            return response()->json($validator->errors(), 404);
        }

		try {
			$sensorsData = $request->all();
			$this->sensors->create($sensorsData);
			$return = ['data' => ['msg' => 'Sensor criado com sucesso!']];
			return response()->json($return, 201);
		} catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(['data'=>['msg'=>'Houve um erro ao realizar operação de salvar']], 500);
			}
			if(is_null($sensors)) return response()->json(['data'=>['msg'=>'Sensor não encontrado!']], 404);

		}
    }
	public function update(Request $request, $id)
	{
        $validator = Validator::make($id, $request->all(),[
            'id' => 'required|number',
            'nome' => 'required|string|min:2|max:50',
            'tipo' => 'in:temperatura, luminosidade, presença, magnético|required|min:8|max:10'
        ]);
        if($validator->errors()){
            return response()->json($validator->errors(), 404);
        }
		try {
			$sensorsData = $request->all();
			$sensors     = $this->sensors->find($id);
			$sensors->update($sensorsData);
			$return = ['data' => ['msg' => 'Sensor atualizado com sucesso!']];
			return response()->json($return, 201);
		} catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(['data'=>['msg'=>'Houve um erro ao realizar operação de atualizar']], 500);
			}
		}
	}
	public function delete(Sensor $id)
	{

		try {
			$id->delete();
			return response()->json(['data' => ['msg' => 'Sensor removido com sucesso!']], 200);
		}catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(['data'=>['msg'=>'Houve um erro ao realizar operação de remover']], 500);
			}
		}
	}
}
