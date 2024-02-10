<?php

namespace App\Http\Controllers;


use App\Models\Entrada;
use App\Models\Motorista;
use App\Models\Saida;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Frete;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {


        // Consulta para obter todos os IDs de motoristas
        $todosMotoristas = DB::table('motoristas')->pluck('id')->toArray();

        // Consulta para obter os dados dos fretes dos motoristas agrupados por mês
        $dadosFretes = DB::table('fretes')
            ->select(DB::raw('MONTH(frete_data) as mes'), 'motoristas.motorista_apelido', DB::raw('COUNT(*) as quantidade_fretes'))
            ->join('motoristas', 'fretes.motorista_id', '=', 'motoristas.id')
            ->whereIn('fretes.motorista_id', $todosMotoristas)
            ->groupBy(DB::raw('MONTH(frete_data)'), 'motoristas.motorista_apelido')
            ->orderBy(DB::raw('MONTH(frete_data)'))
            ->get();

        // $dadosFretes agora contém os resultados da consulta, incluindo o apelido do motorista

        // Consulta para obter os dados de entradas dos motoristas agrupados por mês
        $dadosEntradas = DB::table('entradas')
            ->select(DB::raw('MONTH(entrada_data) as mes'), 'motoristas.motorista_apelido', DB::raw('SUM(entrada_valor) as total_entradas'))
            ->join('motoristas', 'entradas.motorista_id', '=', 'motoristas.id')
            ->whereIn('entradas.motorista_id', $todosMotoristas)
            ->groupBy(DB::raw('MONTH(entrada_data)'), 'motoristas.motorista_apelido')
            ->orderBy(DB::raw('MONTH(entrada_data)'))
            ->get();

        // Consulta para obter os dados de saídas dos motoristas agrupados por mês
        $dadosSaidas = DB::table('saidas')
            ->select(DB::raw('MONTH(saida_data) as mes'), 'motoristas.motorista_apelido', DB::raw('SUM(saida_valor) as total_saidas'))
            ->join('motoristas', 'saidas.motorista_id', '=', 'motoristas.id')
            ->whereIn('saidas.motorista_id', $todosMotoristas)
            ->groupBy(DB::raw('MONTH(saida_data)'), 'motoristas.motorista_apelido')
            ->orderBy(DB::raw('MONTH(saida_data)'))
            ->get();

        // Mesclar os resultados das consultas de entradas e saídas com base no mês e motorista
        $dadosCompletos = [];

        foreach ($dadosEntradas as $dadoEntrada) {
            $mes = $dadoEntrada->mes;
            $motorista = $dadoEntrada->motorista_apelido;

            // Encontrar o dado correspondente na consulta de saídas
            $dadoSaida = $dadosSaidas->first(function ($item) use ($mes, $motorista) {
                return $item->mes == $mes && $item->motorista_apelido == $motorista;
            });

            if ($dadoSaida) {
                // Se houver um dado de saída correspondente, adicione-o aos dados completos
                $dadoCompl = [
                    'mes' => $mes,
                    'motorista_apelido' => $motorista,
                    'total_entradas' => $dadoEntrada->total_entradas,
                    'total_saidas' => $dadoSaida->total_saidas,
                ];
                $dadosCompletos[] = $dadoCompl;
            }
        }

        // Obtenha o mês atual
        $mesAtual = Carbon::now()->month;

        $valorSaidasMesAtual = Saida::whereMonth('saida_data', $mesAtual)->sum('saida_valor');
        $valorEntradasMesAtual = Entrada::whereMonth('entrada_data', $mesAtual)->sum('entrada_valor');
        $totalFretesMesAtual = Frete::whereMonth('frete_data', $mesAtual)->count();

        $valorSaidas = Saida::sum('saida_valor');
        $valorEntradas = Entrada::sum('entrada_valor');
        $totalFretes = Frete::count();
        $totalMotoristas = Motorista::count();


        return view('dashboard', compact('valorSaidasMesAtual','valorEntradasMesAtual','totalFretesMesAtual','dadosFretes','dadosCompletos','valorSaidas','valorEntradas','totalFretes','totalMotoristas'));
    }

    public function mostrarEntradasSaidas(Request $request , Motorista $motorista, Saida $saida, Entrada $entrada)
    {
        // Recupere todos os motoristas para a lista suspensa de seleção
        $motoristas = $motorista->all();

        // Recupere o ID do motorista e o mês selecionado do request
        $motoristaId = $request->input('motorista_id');
        $mesesSelecionados = $request->input('mes');
        if (!is_array($mesesSelecionados)) {
            // Se $mesesSelecionados não for um array, converta-o em um array
            $mesesSelecionados = [$mesesSelecionados];
        }

        // Consulta para obter as saídas do motorista no mês selecionado
        $saidas = $saida
            ->where('motorista_id', $motoristaId)
            ->whereIn(DB::raw('MONTH(saida_data)'), $mesesSelecionados)
            ->get();

        // Consulta para obter as saídas do motorista no mês selecionado
        $saida_valor_total = DB::table('saidas')
            ->select(DB::raw('SUM(saida_valor) as total_saidas'))
            ->where('motorista_id', $motoristaId)
            ->whereIn(DB::raw('MONTH(saida_data)'), $mesesSelecionados)
            ->get();

        // Consulta para obter as saídas do motorista no mês selecionado
        $entradas = $entrada
            ->where('motorista_id', $motoristaId)
            ->whereIn(DB::raw('MONTH(entrada_data)'), $mesesSelecionados)
            ->get();

        // Consulta para obter as saídas do motorista no mês selecionado
        $entrada_valor_total = DB::table('entradas')
            ->select(DB::raw('SUM(entrada_valor) as total_entradas'))
            ->where('motorista_id', $motoristaId)
            ->whereIn(DB::raw('MONTH(entrada_data)'), $mesesSelecionados)
            ->get();

        // Você pode fazer algo semelhante para as entradas, se necessário

        return view('mostrar_entradas_saidas', compact('saidas', 'saida_valor_total', 'entradas', 'entrada_valor_total', 'motoristas'));


    }

}
