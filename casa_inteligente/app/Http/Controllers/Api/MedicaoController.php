<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Medicoe;
use App\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class MedicaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(Sensor $sensors)
	{
		$this->sensors = $sensors;
	}


    public function __constructM(Medicoe $medicoes)
    {
        $this->medicoe = $medicoes;
    }

    public function index()
    {
        if(sizeof($this->sensors->all()) <= 0 ){
            return response()->json(['data' => ['msg' => 'Não existe nenhuma medição salva']], 404);
        }
        else{
            return response()->json($this->sensors->all());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sensor_id' => 'required|integer|min:1|max:3',
            'valor' => 'in:celcius|required|min:7|max:7',
            'data_horario' => 'required|date',
        ]);
        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }

        try{
            $medicaoData = $request->all();
            $this->medicoe->create($medicaoData);
            $data = Medicoe::where('sensor_id', $request->get('sensor_id'))->get();
            $return = ['data' => ['msg' => 'Medição criado com sucesso!']];
            return response()->json($return, 201);

        }catch(\Exception $e){
            if(is_null($request->sensor_id)) return response()->json(['data'=>['msg'=>'Sensor não encontrado!']], 404);
        }

        //$req = $request->all();
        //return response()->json($req);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $medicoes = Medicoe::where('sensor_id')->get();
        return view('indexMedicoes', compact('medicoes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
