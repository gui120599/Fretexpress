@extends('layouts.app')
@section('title','Entradas e Saídas')
@section('content')
    <h1 class="text-2xl font-bold mb-4">Entradas e Saídas por Motorista e Mês</h1>

    <form action="{{ route('entradas-saidas') }}" method="GET" class="mb-8">
        @csrf

        <div class="mb-4">
            <label for="motorista" class="block text-gray-700">Selecione o Motorista:</label>
            <select name="motorista_id" id="motorista_id" class="block w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                @foreach ($motoristas as $motorista)
                    <option value="{{ $motorista->id }}">{{ $motorista->motorista_apelido }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Selecione os Meses:</label>
            <div class="grid grid-cols-3 gap-2">
                @php
                    $meses = [
                        1 => 'Janeiro',
                        2 => 'Fevereiro',
                        3 => 'Março',
                        4 => 'Abril',
                        5 => 'Maio',
                        6 => 'Junho',
                        7 => 'Julho',
                        8 => 'Agosto',
                        9 => 'Setembro',
                        10 => 'Outubro',
                        11 => 'Novembro',
                        12 => 'Dezembro',
                    ];
                @endphp

                @foreach ($meses as $numeroMes => $nomeMes)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="mes[]" value="{{ $numeroMes }}" id="mes_{{ $numeroMes }}" class="form-checkbox h-5 w-5 text-blue-600">
                        <span class="ml-2">{{ $nomeMes }}</span>
                    </label>
                @endforeach
            </div>
        </div>


        <button type="submit" class="w-full bg-blue-400 hover:bg-blue-900 p-2 rounded text-white font-semibold">
            <span>Pesquisar</span>
        </button>
    </form>
    <!-- Botão Adicionar -->
    <div class="mb-4 w-full md:w-1/4">
        <button id="imprimir" class="w-full md:w-auto lg:max-w-sm flex items-center bg-blue-400 hover:bg-blue-900 p-1 rounded text-white justify-center font-semibold">
            <i class='bx bx-printer'></i>
            <span>Imprimir</span>
        </button>
    </div>

    <div id="secao-imprimir">
        @if(isset($saidas[0]))
            Mototrista: <input type="text" class="w-full" value="{{ $saidas[0]['motorista']['motorista_primeiro_nome'] }} {{ $saidas[0]['motorista']['motorista_sobrenome'] }}" readonly>
        @elseif(isset($entradas[0]))
            Mototrista: <input type="text" class="w-full" value="{{ $entradas[0]['motorista']['motorista_primeiro_nome'] }} {{ $entradas[0]['motorista']['motorista_sobrenome'] }}" readonly>
        @endif

        <div class="max-w-3xl mx-auto mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2">

            <!-- Card de Entradas -->
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold">Entradas Mensais</h2>
                        <i class='bx bx-dollar text-2xl'></i>
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-600">Valor de Entradas:</p>
                        <p class="text-3xl font-semibold text-green-500">R$
                            @foreach($entrada_valor_total as $evt) {{ $evt->total_entradas }}@endforeach
                        </p>
                    </div>
                </div>

                <!-- Card de Saídas -->
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold">Saídas Mensais</h2>
                        <i class='bx bx-wallet text-2xl'></i>
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-600">Valor de Saídas:</p>
                        <p class="text-3xl font-semibold text-red-500">R$
                            @foreach($saida_valor_total as $svt) -{{ $svt->total_saidas }}@endforeach
                        </p>
                    </div>
                </div>

            </div>

        <div class="w-[18rem] sm:w-[99%] overflow-auto mx-auto h-2/4 mt-6">

                <h2 class="text-center font-semibold mb-4">Todas as Entradas</h2>
                <table class="w-full text-center text-[10px] md:text-base" id="tabela">
                    <thead class="bg-gray-50 border-2 border-gray-200">
                    <tr>
                        <th class="border-2">ID</th>
                        <th class="border-2 px-1 md:px-4"><i class='mr-2 pt-1 bx bx-package'></i>Motorista</th>
                        <th class="border-2 px-1 md:px-4"><i class='mr-2 pt-1 bx bx-package'></i>Descrição Entrada</th>
                        <th class="border-2 px-1 md:px-4"><i class='mr-2 mt-1 bx bx-calendar' ></i>Data Entrada</th>
                        <th class="border-2 px-1 md:px-4"><i class='mr-2 mt-1 bx bxs-badge-dollar' ></i>Valor R$</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="hover:bg-gray-50" id="nenhumRegistroEncontrado" style="display: none;">
                        <td class="border-2" colspan="5">Nenhum registro encontrado</td>
                    </tr>
                    @foreach($entradas as $entrada)
                        <tr class="hover:bg-gray-50">
                            <th class="border-2">{{ $entrada->id }}</th>
                            <td class="border-2">{{ $entrada->motorista->motorista_apelido }}</td>
                            <td class="border-2">{{ $entrada->entrada_descricao }}</td>
                            <td class="border-2">
                                @if ($entrada->entrada_data)
                                    {{ \Carbon\Carbon::parse($entrada->entrada_data)->format('d/m/Y') }}
                                @else
                                    Data não disponível
                            @endif
                            <td class="border-2">R$ {{ $entrada->entrada_valor }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <h2 class="text-center font-semibold mb-4 mt-6">Todas as Saídas</h2>
                <table class="w-full text-center text-[10px] md:text-base" id="tabela">
                    <thead class="bg-gray-50 border-2 border-gray-200">
                    <tr>
                        <th class="border-2">ID</th>
                        <th class="border-2 px-1 md:px-4"><i class='mr-2 pt-1 bx bx-package'></i>Motorista</th>
                        <th class="border-2 px-1 md:px-4"><i class='mr-2 pt-1 bx bx-package'></i>Descrição Saída</th>
                        <th class="border-2 px-1 md:px-4"><i class='mr-2 mt-1 bx bx-calendar' ></i>Data Saída</th>
                        <th class="border-2 px-1 md:px-4"><i class='mr-2 mt-1 bx bxs-badge-dollar' ></i>Valor R$</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="hover:bg-gray-50" id="nenhumRegistroEncontrado" style="display: none;">
                        <td class="border-2" colspan="5">Nenhum registro encontrado</td>
                    </tr>
                    @foreach($saidas as $saida)
                        <tr class="hover:bg-gray-50">
                            <th class="border-2">{{ $saida->id }}</th>
                            <td class="border-2">{{ $saida->motorista->motorista_apelido }}</td>
                            <td class="border-2">{{ $saida->saida_descricao }}</td>
                            <td class="border-2">
                                @if ($saida->saida_data)
                                    {{ \Carbon\Carbon::parse($saida->saida_data)->format('d/m/Y') }}
                                @else
                                    Data não disponível
                            @endif
                            <td class="border-2">R$ {{ $saida->saida_valor }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        // Obtém a URL atual
        var url = window.location.href;

        // Cria um objeto URL
        var urlObj = new URL(url);

        // Remove o parâmetro '_token'
        urlObj.searchParams.delete('_token');

        // Obtém os valores dos outros parâmetros
        var motorista_id = urlObj.searchParams.get('motorista_id');
        var meses = urlObj.searchParams.getAll('mes[]');

        // Exibe os valores no console
        console.log('motorista_id:', motorista_id);
        console.log('meses:', meses);

        // Marca os checkboxes correspondentes
        meses.forEach(function(mes) {
            var checkbox = document.getElementById('mes_' + mes);
            if (checkbox) {
                checkbox.checked = true;
            }
        });

        const selectElement = document.getElementById('motorista_id');
        const options = selectElement.getElementsByTagName('option');

        for (let i = 0; i < options.length; i++) {
            if (options[i].value === motorista_id) {
                options[i].selected = true;
                break; // Uma vez que a opção foi encontrada e selecionada, saia do loop
            }
        }

        document.getElementById('imprimir').addEventListener('click', function () {
            var divImprimir = document.getElementById('secao-imprimir');
            console.log(divImprimir);
            if (divImprimir) {
                var janelaImprimir = window.open('', '', 'width=800,height=600');
                janelaImprimir.document.open();
                janelaImprimir.document.write('<html><head><title>Imprimir Conteúdo</title><link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet"></head><body>');
                janelaImprimir.document.write(`<header class="bg-gradient-to-r from-blue-900 to-blue-500 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-2xl text-center font-semibold">fretExpress</h1>
            <p class="mt-2">Relatório Mensal de Entradas e Saídas</p>
        </div>
    </header>`);
                janelaImprimir.document.write('<h1 class="text-center">Entradas e Saidas</h1>');
                janelaImprimir.document.write(divImprimir.innerHTML); // Inserir o conteúdo da div
                janelaImprimir.document.write('</body></html>');
                janelaImprimir.document.close();
                janelaImprimir.print();
                janelaImprimir.close();
            } else {
                alert('Elemento com ID "imprimir" não encontrado.');
            }
        });


    </script>
@endsection

