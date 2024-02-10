<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaidaRequest;
use App\Http\Requests\UpdateSaidaRequest;
use App\Models\Motorista;
use App\Models\Saida;

class SaidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Saida $saida ,Motorista $motorista)
    {
        $motoristas = $motorista->all();
        $saidas = $saida->all();
        $result = null;
        $saida_edit = [
            'id' => 0,
            'motorista_id' => null,
            'saida_descricao'=> null,
            'saida_data' => null,
            'saida_valor' => null
        ];
        //dd($saida_edit['id']);
        return view('saidas.saidas', compact('saidas','saida_edit','result','motoristas'));
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
    public function store(StoreSaidaRequest $request, Saida $saida)
    {

        $dados = $request->all();

        // Substitua a vírgula pelo ponto nos valores decimais
        $dados['saida_valor'] = str_replace(',', '.', $dados['saida_valor']);

        //Crie uma instância do modelo Saida para atribuir o novo valor sem a virgula
        $saida = new Saida();
        $saida->fill($dados);
        $saida->save($dados);

        return redirect()->route('saidas.saidas')->with('result','success')->with('msg','Registro salvo com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Saida $saida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Saida $saida, string|int $id, Motorista $motorista)
    {
        $motoristas = $motorista->all();
        if (!$saida_edit = $saida->where('id',$id)->first()){
            return back()->with('result','error')->with('msg','Registro não encontrado.');
        }
        $saidas = $saida->all();
        $result = 'edit';
        return view('saidas/saidas', compact('saidas','saida_edit','result','motoristas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaidaRequest $request, Saida $saida, string|int $id)
    {
        $saida = $saida->find($id);

        if (!$saida){
            return back()->with('result','error')->with('msg','Registro não encontrado.');
        }
        $data = $request->only([
            'motorista_id',
            'saida_descricao',
            'saida_data',
            'saida_valor',
        ]);

        $data['saida_valor'] = str_replace(',', '.', $data['saida_valor']);

        $saida->update($data);

        return redirect()->route('saidas.saidas')->with('result','success')->with('msg','Registro atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Saida $saida, $id)
    {
        // Encontre o registro que você deseja inativar
        $saida = Saida::find($id);

        if (!$saida) {
            // Lide com o caso em que o registro não foi encontrado
            return redirect('/saidas')->with('result','error')->with('msg','Registro não encontrado.');
        }

        // Inative o registro (soft delete)
        $saida->delete();

        // Redirecione ou retorne uma resposta
        return redirect('/saidas')->with('result','success')->with('msg', 'Registro inativado com sucesso.');
    }
}
