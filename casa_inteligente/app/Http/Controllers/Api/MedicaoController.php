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

    private $medicoe;
    public function __construct(Medicoe $medicoes)
    {
        $this->medicoe = $medicoes;
    }

    public function index()
    {
        if(sizeof($this->medicoe->all()) <= 0 ){
            return response()->json(['data' => ['msg' => 'Nenhuma medição cadastrada']], 404);
        }
        else{
            return response()->json($this->medicoe->all(), 200);
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
            'sensor_id' => 'required|numeric|',
            'valor' => 'required|numeric|',
            'data_horario' => 'required|date',
        ]);
        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }

        try{
            $medicaoData = $request->all();
            $this->medicoe->create($medicaoData);
            $data = Medicoe::where('sensor_id', $request->get('sensor_id'))->get();
            $return = ['data' => ['msg' => ['Medição criado com sucesso!'], [$data]]];
            return response()->json($return, 201);

        }catch(\Exception $e){
            if(is_null($request->sensor_id)) return response()->json(['data'=>['msg'=>'Sensor não encontrado!']], 404);
        }

        //$req = $request->all();
        //return response()->json($return);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $i = ['id' => $id];
        $validator = Validator::make($i,[
            'id' => 'required|numeric'
        ]);
        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }

        $medicoes = Medicoe::where('id', $id)->get();
        $teste = count($medicoes);
        if($teste != 0){
            $dataMedi = ['data' => [$medicoes]];
            return response()->json($dataMedi ,201);
        }else{
            $empty = ['data' => ["Não tem medições com esse id"]];
            return response()->json($empty, 404);
        }

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
        //return response()->json($request->all(), 200);
        $validator = Validator::make($request->all(), [
            'valor' => 'required|numeric',
            'data_horario' => 'date'
        ]);

        $i = ['id' => $id];
        $validatorid = Validator::make($i, [
            'id' => 'required|numeric'
        ]);

        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors(), 404);
        }
        if(sizeof($validatorid->errors()) > 0){
            return response()->json($validatorid->errors(), 404);
        }

        $medicao_count= Medicoe::where('id', $id)->count();
        $medicao = Medicoe::find($id);

        if($medicao_count != 0){

            $update_req = $request->all();
            $medicao->update($update_req);
            $json = ['data' => ['Update feito com sucesso']];
            return response()->json($json , 200);

        }else{
            return response()->json(['data' => ['msg' => 'Esta medição nao pode ter update porque não existe']], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $i = ['id' => $id];
        $validator = Validator::make($i, [
            'id' => 'required|numeric'
        ]);

        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }

        $medicao_count = Medicoe::where('id', $id)->count();
        $medicao = Medicoe::find($id);

        if($medicao_count != 0){
            $medicao->delete();
            return response()->json(['data' => [$i],['msg' => 'Medição removida com sucesso!']], 200);
        }else{
            return response()->json(['data' => ['msg' => 'Esta medição nao pode ser removida porque nao existe']], 500);
        }

        //return response()->json($medicao ,201);
        $json_medicao = ['data' => [$medicao]];
        return response()->json($json_medicao ,201);
    }
}
