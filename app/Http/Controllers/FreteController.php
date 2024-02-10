<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreFreteRequest;
use App\Http\Requests\UpdateFreteRequest;
use App\Models\Motorista;
use App\Models\Frete;
use App\Models\Entrada;

class FreteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Frete $frete, Motorista $motorista)
    {
        $motoristas = $motorista->all();
        $fretes = $frete->with('motorista')->get();
        $result = null;
        $frete_edit = [
            'id' => 0,
            'frete_descricao_carga' => null,
            'frete_empresa' => null,
            'motorista_id' => null,
            'frete_municipio_saida' => null,
            'frete_municipio_destino' => null,
            'frete_valor_km' => null,
            'frete_distancia_percorrida' => null,
            'frete_valor_total' => null,
            'frete_data_saida' => null,
            'frete_data_chegada' => null,
            'frete_data' => null
        ];

        return view('fretes.fretes', compact('result','motoristas','fretes','frete_edit' ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFreteRequest $request, Frete $frete)
    {
        $dados = $request->all();

        if ($dados['frete_valor_km'] == null){
            $dados['frete_valor_km'] = 0.0;
        }

        // Substitua a vírgula pelo ponto nos valores decimais
        $dados['frete_valor_km'] = str_replace(',', '.', $dados['frete_valor_km']);
        $dados['frete_valor_total'] = str_replace(',', '.', $dados['frete_valor_total']);

        // Crie uma instância do modelo Frete e atribua os valores
        $frete = new Frete();
        $frete->fill($dados);
        $frete->save();

        // Agora, crie um novo registro na tabela de Entradas
        $entrada = new Entrada();
        $entrada->frete_id = $frete->id; // Use o ID do frete recém-salvo
        $entrada->motorista_id = $frete->motorista_id;
        $entrada->entrada_descricao = $frete->frete_empresa . ' - ' . $frete->frete_municipio_saida . '_X_' . $frete->frete_municipio_destino;
        $entrada->entrada_data = $frete->frete_data;
        $entrada->entrada_valor = $frete->frete_valor_total;
        $entrada->save();

        return redirect()->route('fretes.fretes')->with('result','success')->with('msg','Registro salvo com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Frete $frete)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Frete $frete, string|int $id, Motorista $motorista)
    {
        $motoristas = $motorista->all();
        if (!$frete_edit = $frete->where('id',$id)->first()){
            return back()->with('result','error')->with('msg','Registro não encontrado.');
        }
        $fretes = $frete->all();
        $result = 'edit';
        return view('fretes/fretes', compact('fretes','frete_edit', 'motoristas','result'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFreteRequest $request, Frete $frete, string|int $id)
    {
        $frete = $frete->find($id);

        if (!$frete) {
            return back()->with('result', 'error')->with('msg', 'Registro não encontrado.');
        }

        // Substitua a vírgula pelo ponto nos valores decimais
        $data = $request->only([
            'frete_descricao_carga',
            'motorista_id',
            'frete_empresa',
            'frete_municipio_saida',
            'frete_municipio_destino',
            'frete_valor_km',
            'frete_distancia_percorrida',
            'frete_valor_total',
            'frete_data_saida',
            'frete_data_chegada',
            'frete_data',
        ]);

        if ($data['frete_valor_km'] == null){
            $data['frete_valor_km'] = 0.0;
        }
        $data['frete_valor_km'] = str_replace(',', '.', $data['frete_valor_km']);
        $data['frete_valor_total'] = str_replace(',', '.', $data['frete_valor_total']);

        // Atualize o registro do frete
        $frete->update($data);

        // Atualize também a entrada correspondente (ou crie uma nova se não existir)
        $entrada = Entrada::firstOrNew(['frete_id' => $frete->id]);
        $entrada->motorista_id = $frete->motorista_id;
        $entrada->entrada_descricao = $frete->frete_empresa . ' - ' . $frete->frete_municipio_saida . '_X_' . $frete->frete_municipio_destino;
        $entrada->entrada_data = $frete->frete_data;
        $entrada->entrada_valor = $frete->frete_valor_total;
        $entrada->save();

        return redirect()->route('fretes.fretes')->with('result','success')->with('msg','Registro atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Frete $frete, $id)
    {
        // Encontre o registro que você deseja inativar
        $frete = Frete::find($id);

        if (!$frete) {
            // Lide com o caso em que o registro não foi encontrado
            return redirect('/fretes')->with('result','error')->with('msg','Registro não encontrado.');
        }

        // Inative o registro (soft delete)
        $frete->delete();

        // Redirecione ou retorne uma resposta
        return redirect('/fretes')->with('result','success')->with('msg', 'Registro inativado com sucesso.');
    }
}
