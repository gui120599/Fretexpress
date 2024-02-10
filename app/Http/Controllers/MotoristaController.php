<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMotoristaRequest;
use App\Http\Requests\UpdateMotoristaRequest;
use App\Models\Motorista;

class MotoristaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Motorista $motorista)
    {
        $motoristas = $motorista->all();
        $result = null;
        $motorista_edit = [
            'id' => 0,
            'motorista_primeiro_nome'=> null,
            'motorista_sobrenome' => null,
            'motorista_apelido' => null,
            'motorista_celular' => null
        ];
        //dd($motorista_edit['id']);
        return view('motoristas.motoristas', compact('motoristas','motorista_edit','result'));
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
    public function store(StoreMotoristaRequest $request, Motorista $motorista)
    {

        $dados = $request->all();


        $motorista->create($dados);

        return redirect()->route('motoristas.motoristas')->with('result','success')->with('msg','Registro salvo com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Motorista $motorista)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Motorista $motorista, string|int $id)
    {
        if (!$motorista_edit = $motorista->where('id',$id)->first()){
            return back()->with('result','error')->with('msg','Registro não encontrado.');
        }
        $motoristas = $motorista->all();
        $result = 'edit';
        return view('motoristas/motoristas', compact('motoristas','motorista_edit','result'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMotoristaRequest $request, Motorista $motorista, string|int $id)
    {
        if (!$motorista = $motorista->where('id',$id)->first()){
            return back()->with('result','error')->with('msg','Registro não encontrado.');
        }
        $motorista->update($request->only([
            'motorista_primeiro_nome',
            'motorista_sobrenome',
            'motorista_apelido',
            'motorista_celular',
        ]));
        return redirect()->route('motoristas.motoristas')->with('result','success')->with('msg','Registro atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Motorista $motorista, $id)
    {
        // Encontre o registro que você deseja inativar
        $motorista = Motorista::find($id);

        if (!$motorista) {
            // Lide com o caso em que o registro não foi encontrado
            return redirect('/motoristas')->with('result','error')->with('msg','Registro não encontrado.');
        }

        // Inative o registro (soft delete)
        $motorista->delete();

        // Redirecione ou retorne uma resposta
        return redirect('/motoristas')->with('result','success')->with('msg', 'Registro inativado com sucesso.');
    }
}
