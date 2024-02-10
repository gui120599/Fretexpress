<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntradaRequest;
use App\Http\Requests\UpdateEntradaRequest;
use App\Models\Entrada;
use App\Models\Motorista;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Entrada $entrada, Motorista $motorista)
    {
        $motoristas = $motorista->all();
        $entradas = $entrada->all();
        $result = null;
        $entrada_edit = [
            'id' => 0,
            'motorista_id'=> null,
            'entrada_descricao'=> null,
            'entrada_data' => null,
            'entrada_valor' => null
        ];
        //dd($entrada_edit['id']);
        return view('entradas.entradas', compact('entradas','entrada_edit','result','motoristas'));
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
    public function store(StoreEntradaRequest $request, Entrada $entrada)
    {
        $dados = $request->all();

        // Substitua a vírgula pelo ponto nos valores decimais
        $dados['entrada_valor'] = str_replace(',', '.', $dados['entrada_valor']);

        //Crie uma instância do modelo Saida para atribuir o novo valor sem a virgula
        $entrada = new Entrada();
        $entrada->fill($dados);
        $entrada->save($dados);


        return redirect()->route('entradas.entradas')->with('result','success')->with('msg','Registro salvo com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Entrada $entrada)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entrada $entrada, string|int $id, Motorista $motorista)
    {
        $motoristas = $motorista->all();
        if (!$entrada_edit = $entrada->where('id',$id)->first()){
            return back()->with('result','error')->with('msg','Registro não encontrado.');
        }
        $entradas = $entrada->all();
        $result = 'edit';
        return view('entradas/entradas', compact('entradas','entrada_edit','result','motoristas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEntradaRequest $request, Entrada $entrada, string|int $id)
    {
        $entrada = $entrada->find($id);

        if (!$entrada){
            return back()->with('result','error')->with('msg','Registro não encontrado.');
        }
        $data = $request->only([
            'motorista_id',
            'entrada_descricao',
            'entrada_data',
            'entrada_valor',
        ]);

        $data['entrada_valor'] = str_replace(',', '.', $data['entrada_valor']);

        $entrada->update($data);

        return redirect()->route('entradas.entradas')->with('result','success')->with('msg','Registro atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entrada $entrada, $id)
    {
        // Encontre o registro que você deseja inativar
        $entrada = Entrada::find($id);

        if (!$entrada) {
            // Lide com o caso em que o registro não foi encontrado
            return redirect('/entradas')->with('result','error')->with('msg','Registro não encontrado.');
        }

        // Inative o registro (soft delete)
        $entrada->delete();

        // Redirecione ou retorne uma resposta
        return redirect('/entradas')->with('result','success')->with('msg', 'Registro inativado com sucesso.');
    }
}
