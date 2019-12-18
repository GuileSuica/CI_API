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
		$i = ['id' => $id];
        $validator = Validator::make($i,[
            'id' => 'required|numeric'
        ]);
        if(sizeof($validator->errors()) > 0 ){
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
            'tipo' => 'in:temperatura,luminosidade,presença,magnético|required|min:8|max:20'
        ]);

        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }

		try {
			$sensorsData = $request->all();
			$this->sensors->create($sensorsData);
			$data = Sensor::where('nome',$request->get('nome'))->where('tipo', $request->get('tipo'))->get();
			$return = ['data' => ['msg' => 'Sensor criado com sucesso!'], 'id' => ['number' => $data[0]->id ]];
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
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|min:2|max:50',
            'tipo' => 'in:temperatura,luminosidade,presença,magnético|required|min:8|max:20'
        ]);

        if(sizeof($validator->errors()) > 0 ){
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
	public function delete($id)
	{
		//dd($id);
		$sensor = Sensor::find($id);
		//dd($sensor);
		try {
			if($sensor){
				$sensor->delete();
				return response()->json(['data' => ['msg' => 'Sensor removido com sucesso!']], 200);
			}
			else{
				return response()->json(['data' => ['msg' => 'Este sensor nao pode ser removido porque nao existe']], 500);
			}
		}catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(['data'=>['msg'=>'Houve um erro ao realizar operação de remover']], 500);
			}
		}
	}
}
