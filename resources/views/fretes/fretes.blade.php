@extends('layouts.app')
@section('title','Fretes')
@section('content')
    <h1 class="text-2xl font-bold mb-4">Fretes</h1>
    <div class="w-full p-1 gap-4 flex flex-wrap md:flex-nowrap justify-between items-center">
        <!-- Botão Adicionar -->
        <div class="mb-4 w-full md:w-1/4">
            <button id="botaoAdicionar" class="w-full md:w-auto lg:max-w-sm flex items-center bg-blue-400 hover:bg-blue-900 p-1 rounded text-white justify-center font-semibold abrir-modal">
                <i class='bx bx-plus'></i>
                <span>Adicionar</span>
            </button>
        </div>
        <!-- Botão Adicionar -->
        <div class="mb-4 w-full md:w-1/4">
            <button id="imprimir" class="w-full md:w-auto lg:max-w-sm flex items-center bg-blue-400 hover:bg-blue-900 p-1 rounded text-white justify-center font-semibold abrir-modal">
                <i class='bx bx-plus'></i>
                <span>Imprimir</span>
            </button>
        </div>
        <!-- Campo de Busca -->
        <div class="mb-4 w-full md:w-1/4">
            <div class="relative flex justify-end">
                <input type="text" id="buscar" name="buscar" class="w-full lg:max-w-md pl-3 pr-10 rounded border-gray-200 p-0" placeholder="Buscar...">
                <i class='bx bx-search text-xl absolute right-3 top-1/2 transform -translate-y-1/2'></i>
            </div>
        </div>
    </div>

    <div class="w-[18rem] sm:w-[99%] overflow-auto mx-auto h-2/4">

        <table class="w-full text-center text-[7px] md:text-base" id="tabela">
            <thead class="bg-gray-50 border-2 border-gray-200">
            <tr>
                <th class="border-2">ID</th>
                <th class="border-2 px-1 md:px-4"><i class='mr-2 pt-1 bx bx-package'></i>Carga</th>
                <th class="border-2 px-1 md:px-4"><i class='mr-2 pt-1 bx bx-user-circle' ></i>Motorista</th>
                <th class="border-2 px-1 md:px-4"><i class='mr-2 mt-1 bx bx-calendar' ></i>Data Frete</th>
                <th class="border-2 px-1 md:px-4"><i class='mr-2 mt-1 bx bxs-institution' ></i>Empresa</th>
                <th class="border-2 px-1 md:px-4"><i class='mr-2 mt-1 bx bx-location-plus' ></i>Saída</th>
                <th class="border-2 px-1 md:px-4"><i class='mr-2 mt-1 bx bx-location-plus' ></i>Destino</th>
                <th class="border-2 px-1 md:px-4"><i class='mr-2 mt-1 bx bx-dollar-circle' ></i>Valor Km</th>
                <th class="border-2 px-1 md:px-4"><i class='mr-2 mt-1 bx bx-transfer-alt' ></i>Distância Km</th>
                <th class="border-2 px-1 md:px-4"><i class='mr-2 mt-1 bx bxs-badge-dollar' ></i>Total</th>
                {{--<th class="border-2 px-1">Data Carregamento</th>
                <th class="border-2 px-1">Data Descarregamento</th>--}}
                <th class="border-2 px-1">Opções</th>
            </tr>
            </thead>
            <tbody>
            <tr class="hover:bg-gray-50" id="nenhumRegistroEncontrado" style="display: none;">
                <td class="border-2" colspan="5">Nenhum registro encontrado</td>
            </tr>
            @foreach($fretes as $frete)
                <tr class="hover:bg-gray-50">
                    <th class="border-2">{{ $frete->id }}</th>
                    <td class="border-2">{{ $frete->frete_descricao_carga }}</td>
                    <td class="border-2">{{ $frete->motorista->motorista_apelido }}</td>
                    <td class="border-2">
                        @if ($frete->frete_data)
                            {{ \Carbon\Carbon::parse($frete->frete_data)->format('d/m/Y') }}
                        @else
                            Data não disponível
                    @endif
                    <td class="border-2">{{ $frete->frete_empresa }}</td>
                    <td class="border-2">{{ $frete->frete_municipio_saida }}</td>
                    <td class="border-2">{{ $frete->frete_municipio_destino }}</td>
                    <td class="border-2">R$ {{ $frete->frete_valor_km }}</td>
                    <td class="border-2">{{ $frete->frete_distancia_percorrida }} Km</td>
                    <td class="border-2">R$ {{ $frete->frete_valor_total }}</td>
                    {{--<td class="border-2">{{ $frete->frete_data_saida }}</td>
                    <td class="border-2">{{ $frete->frete_data_chegada }}</td>--}}
                    <td class="border-2">
                        <div class="flex items-center justify-center space-x-4">
                            <button class="text-[10px] md:text-xl" title="Editar" onclick="window.location.href = '{{ route('fretes.edit', $frete->id) }}'"><i class='bx bxs-edit'></i></button>
                            <form method="POST" action="{{route('fretes.destroy', $frete->id)}}">
                                @method('delete')
                                @csrf
                                <button class="text-[10px] md:text-xl" title="Excluir"><i class='bx bxs-x-square'></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    @section('modal-title')
        <h2 class="flex justify-items-start items-center">
            <i class='bx bxs-truck text-4xl mr-4'></i>
            <label>Adicionar um novo Frete</label>
        </h2>
    @endsection
    @section('modal-content')
        <div class="w-full  mx-auto p-4 overflow-y-auto h-5/6">
            <form id="freteForm" method="POST" action="{{route('fretes.store')}}">
                @csrf()
                <div class="w-full p-1 gap-4 flex flex-wrap md:flex-nowrap items-center">
                    <div class="w-full md:w-1/4 mb-4">
                        <label for="frete_descricao_carga" class="block text-sm font-medium text-gray-700">Descrição da Carga</label>
                        <input type="text" name="frete_descricao_carga" id="frete_descricao_carga" value="{{ $frete_edit['frete_descricao_carga'] }}" class="w-full border-gray-300 rounded-md p-2" placeholder="Digite a descrição da carga">
                    </div>
                    <div class="w-full mb-4">
                        <label for="frete_empresa" class="block text-sm font-medium text-gray-700">Nome da Empresa</label>
                        <input type="text" name="frete_empresa" id="frete_empresa" value="{{ $frete_edit['frete_empresa'] }}" class="w-full border-gray-300 rounded-md p-2" placeholder="Digite o nome da empresa">
                    </div>
                    <div class="w-full md:w-1/4 mb-4">
                        <label for="frete_data" class="block text-sm font-medium text-gray-700">Data do Frete*</label>
                        <input type="date" name="frete_data" id="frete_data" value="{{ $frete_edit['frete_data'] }}" class="w-full border-gray-300 rounded-md p-2" placeholder="00/00/0000" required>
                    </div>
                </div>
                <div class="w-full mb-4">
                    <label for="motorista_id" class="block text-sm font-medium text-gray-700">Selecione o Motorista*</label>
                    <select name="motorista_id" id="motorista_id" class="w-full border-gray-300 rounded-md p-2">
                        <option>Selecione...</option>
                        @foreach($motoristas as $motorista)
                            <option value="{{$motorista->id}}">{{ $motorista->motorista_primeiro_nome }} {{ $motorista->motorista_sobrenome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full p-1 gap-4 flex flex-wrap md:flex-nowrap items-center">
                    <div class="w-full md:w-1/2 mb-4">
                        <label for="frete_municipio_saida" class="block text-sm font-medium text-gray-700">Cidade de Carregamento*</label>
                        <input type="text" name="frete_municipio_saida" id="frete_municipio_saida" value="{{ $frete_edit['frete_municipio_saida'] }}" class="w-full border-gray-300 rounded-md p-2" placeholder="Digite o município de carregamento" required>
                    </div>
                    <div class="w-full md:w-1/2 mb-4">
                        <label for="frete_municipio_destino" class="block text-sm font-medium text-gray-700">Cidade de Descarregamento*</label>
                        <input type="text" name="frete_municipio_destino" id="frete_municipio_destino" value="{{ $frete_edit['frete_municipio_destino'] }}" class="w-full border-gray-300 rounded-md p-2" placeholder="Digite o município de descarregamento" required>
                    </div>
                </div>
                <div class="w-full p-1 gap-4 flex flex-wrap md:flex-nowrap items-center">
                    <div class="w-1/2 md:w-1/4 mb-4">
                        <label for="frete_valor_km" class="block text-sm font-medium text-gray-700">Valor Km</label>
                        <input type="text" name="frete_valor_km" id="frete_valor_km" value="{{ $frete_edit['frete_valor_km'] }}" class="w-full border-gray-300 rounded-md p-2" placeholder="R$0000,00">
                    </div>
                    <div class="w-1/2 md:w-1/4 mb-4">
                        <label for="frete_distancia_percorrida" class="block text-sm font-medium text-gray-700">Distância Km</label>
                        <input type="text" name="frete_distancia_percorrida" id="frete_distancia_percorrida" value="{{ $frete_edit['frete_distancia_percorrida'] }}" class="w-full border-gray-300 rounded-md p-2" placeholder="0000km">
                    </div>
                    <div class="w-full md:w-1/3 mb-4">
                        <label for="frete_valor_total" class="block text-sm font-medium text-gray-700">Valor Total*</label>
                        <input type="text" name="frete_valor_total" id="frete_valor_total" value="{{ $frete_edit['frete_valor_total'] }}" class="w-full border-gray-300 rounded-md p-2" placeholder="R$0.000.000,00">
                    </div>
                </div>
                <div class="w-full flex">
                    <button type="button" class="w-1/4 px-1 md:px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-300 mr-2 cancelar-modal">Cancelar</button>
                    <button type="submit" class="w-3/4 bg-blue-400 hover:bg-blue-900 p-1 rounded text-white font-semibold">
                        <span>Salvar</span>
                    </button>
                </div>
            </form>
        </div>
    @endsection
    <script>
        //Função imprimir
        document.getElementById('imprimir').addEventListener('click', function () {
            var tabela = document.getElementById('tabela');
            var janelaDeImpressao = window.open('', '', 'width=800,height=600');
            janelaDeImpressao.document.write('<html><head><title>Imprimir Tabela</title><link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet"></head><body>');
            janelaDeImpressao.document.write('<h1>Tabela para Impressão</h1>');
            janelaDeImpressao.document.write(`<table class="w-full text-center text-[7px] md:text-base" id="tabela">
                <thead class="bg-gray-50 border-2 border-gray-200">
                <tr>
                <th class="border-2">ID</th>
            <th class="border-2 px-1 md:px-4">Carga</th>
            <th class="border-2 px-1 md:px-4">Motorista</th>
            <th class="border-2 px-1 md:px-4">Empresa</th>
            <th class="border-2 px-1 md:px-4">Saída</th>
            <th class="border-2 px-1 md:px-4">Destino</th>
            <th class="border-2 px-1 md:px-4">Valor Km</th>
            <th class="border-2 px-1 md:px-4">Distância Km</th>
            <th class="border-2 px-1 md:px-4">Total</th>
        </tr>
        </thead>
            <tbody>
            <tr class="hover:bg-gray-50" id="nenhumRegistroEncontrado" style="display: none;">
                <td class="border-2" colspan="5">Nenhum registro encontrado</td>
            </tr>
            @foreach($fretes as $frete)
            <tr class="hover:bg-gray-50">
            <th class="border-2">{{ $frete->id }}</th>
            <td class="border-2">{{ $frete->frete_descricao_carga }}</td>
            <td class="border-2">{{ $frete->motorista->motorista_apelido }}</td>
            <td class="border-2">{{ $frete->frete_empresa }}</td>
            <td class="border-2">{{ $frete->frete_municipio_saida }}</td>
            <td class="border-2">{{ $frete->frete_municipio_destino }}</td>
            <td class="border-2">{{ $frete->frete_valor_km }}</td>
            <td class="border-2">{{ $frete->frete_distancia_percorrida }}</td>
            <td class="border-2">{{ $frete->frete_valor_total }}</td>
            </td>
            </tr>
            @endforeach
            </tbody>
        </table>`);
            janelaDeImpressao.document.write('</body></html>');
            janelaDeImpressao.document.close();
            janelaDeImpressao.print();
            janelaDeImpressao.close();
        });


        // Função para calcular valor km e distância
        document.addEventListener('DOMContentLoaded', function() {
            // Obtém elementos do formulário pelo ID
            const distanciaPercorrida = document.getElementById('frete_distancia_percorrida');
            const valorKm = document.getElementById('frete_valor_km');
            const valorTotal = document.getElementById('frete_valor_total');

            // Adiciona um ouvinte de evento de entrada para o campo de valor km
            valorKm.addEventListener('input', function () {
                // Obtém os valores dos campos, substituindo vírgulas por pontos
                const valorKmLimpo = valorKm.value.replace(',', '.'); // Substitui vírgula por ponto
                const distanciaPercorridaLimpa = distanciaPercorrida.value.replace(',', '.'); // Substitui vírgula por ponto

                // Verifica se ambos os campos têm valores não vazios
                if (valorKmLimpo !== '' && distanciaPercorridaLimpa !== '') {
                    // Realiza o cálculo multiplicando os valores (agora como números de ponto flutuante)
                    let resultado = parseFloat(valorKmLimpo) * parseFloat(distanciaPercorridaLimpa);

                    // Limita o resultado a 2 casas decimais
                    resultado = parseFloat(resultado.toFixed(2));


                    // Exibe o resultado no campo de valor total, substituindo ponto por vírgula na exibição
                    valorTotal.value = resultado.toString().replace('.', ','); // Substitui ponto por vírgula na exibição
                }
            });
            // Adiciona um ouvinte de evento de entrada para o campo de distância percorrida
            distanciaPercorrida.addEventListener('input', function () {
                // Obtém os valores dos campos, substituindo vírgulas por pontos
                const valorKmLimpo = valorKm.value.replace(',', '.'); // Substitui vírgula por ponto
                const distanciaPercorridaLimpa = distanciaPercorrida.value.replace(',', '.'); // Substitui vírgula por ponto

                // Verifica se ambos os campos têm valores não vazios
                if (valorKmLimpo !== '' && distanciaPercorridaLimpa !== '') {
                    // Realiza o cálculo multiplicando os valores (agora como números de ponto flutuante)
                    let resultado = parseFloat(valorKmLimpo) * parseFloat(distanciaPercorridaLimpa);

                    // Limita o resultado a 2 casas decimais
                    resultado = parseFloat(resultado.toFixed(2));


                    // Exibe o resultado no campo de valor total, substituindo ponto por vírgula na exibição
                    valorTotal.value = resultado.toString().replace('.', ','); // Substitui ponto por vírgula na exibição
                }
            });
        });

        //FUNÇÃO QUE CALCULA O VALOR DO KM RODADO
        document.addEventListener('DOMContentLoaded', function() {
            // Obtém elementos do formulário pelo ID
            const distanciaPercorrida = document.getElementById('frete_distancia_percorrida');
            const valorTotal = document.getElementById('frete_valor_total');
            const valorKm = document.getElementById('frete_valor_km');

            // Adiciona um ouvinte de evento de entrada para o campo de distância percorrida
            distanciaPercorrida.addEventListener('input', calcularValorKm);

            // Adiciona um ouvinte de evento de entrada para o campo de valor total
            valorTotal.addEventListener('input', calcularValorKm);

            // Função para calcular o valor do KM
            function calcularValorKm() {
                // Obtém os valores dos campos, substituindo vírgulas por pontos
                const distanciaPercorridaLimpa = distanciaPercorrida.value.replace(',', '.'); // Substitui vírgula por ponto
                const valorTotalLimpo = valorTotal.value.replace(',', '.'); // Substitui vírgula por ponto

                // Verifica se ambos os campos têm valores não vazios
                if (distanciaPercorridaLimpa !== '' && valorTotalLimpo !== '') {
                    // Realiza o cálculo dividindo os valores (agora como números de ponto flutuante)
                    let resultado = parseFloat(valorTotalLimpo) / parseFloat(distanciaPercorridaLimpa);

                    // Limita o resultado a 2 casas decimais
                    resultado = parseFloat(resultado.toFixed(2));

                    // Exibe o resultado no campo de valor do KM, substituindo ponto por vírgula na exibição
                    valorKm.value = resultado.toString().replace('.', ','); // Substitui ponto por vírgula na exibição
                } else {
                    // Se um dos campos estiver vazio, defina o valor do KM como vazio
                    valorKm.value = '';
                }
            }
        });


        //Eventos quando o botao editar for clicado
        document.addEventListener('DOMContentLoaded', function() {
            //Essa variavel vem do controller edit para identificar que o usuario
            //deseja realizar a edição do objeto
            const resultEdit = '{{$result}}';

            if(resultEdit === 'edit'){
                const botaoAdicionar = document.getElementById('botaoAdicionar');
                const formulario = document.getElementById('freteForm');

                // Crie um novo input para mudar o method do form para patch que é o method de update
                const novoCampo = document.createElement('input');
                novoCampo.type = 'hidden';
                novoCampo.name = '_method';
                novoCampo.value = 'patch';

                // Verifique se o botão e formulario  foi encontrado
                if (botaoAdicionar && formulario) {
                    //Clica no botao para abrir a modal
                    botaoAdicionar.click();

                    //Altera a action do formulario para a action de update
                    formulario.action = '{{ route('fretes.update',$frete_edit['id']) }}';


                    // Adicione o novo campo ao formulário
                    formulario.appendChild(novoCampo);

                    //Seleciona o motorista do frete no input select
                    const motoristaId = '{{ $frete_edit['motorista_id'] }}';

                    const selectElement = document.getElementById('motorista_id');
                    const options = selectElement.getElementsByTagName('option');

                    for (let i = 0; i < options.length; i++) {
                        if (options[i].value === motoristaId.toString()) {
                            options[i].selected = true;
                            break; // Uma vez que a opção foi encontrada e selecionada, saia do loop
                        }
                    }

                } else {
                    console.error('Elementos não encontrado');// Exibe um erro no console caso o botão não seja encontrado
                }
                //Caso o usuario clique no botao de fechar o modal a
                // tela deve voltar a tela inicial de fretes
                document.getElementById('fechar-modal').addEventListener('click', function () {
                    window.location.href = '{{ route('fretes.fretes') }}';
                });
        }

        //Essa variavel vem do Controller para mostrar as alerts na tela
        const result = '{{ session('result') }}';

        switch (result) {
            case 'success':
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('msg') }}',
                    showConfirmButton: false,
                    timer: 1500
                })
                break;
            case 'error':
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: '{{ session('msg') }}',
                    showConfirmButton: false,
                    timer: 1500
                })
                break;
            case 'edit':

                break;

        }
        });

        //Essa função é acionada quando o usuario digita algo no input 'buscar'
        //e realiza um filtro na tabela
        document.getElementById('buscar').addEventListener('input', function () {
            const valorBusca = this.value.toLowerCase();
            const tabela = document.getElementById('tabela');
            const linhas = tabela.getElementsByTagName('tr');
            const linhaNenhumRegistro = document.getElementById('nenhumRegistroEncontrado');

            let encontrouResultados = false;

            for (let i = 1; i < linhas.length; i++) {
                const linha = linhas[i];
                const colunas = linha.getElementsByTagName('td');
                let encontrou = false;

                for (let j = 0; j < colunas.length; j++) {
                    const coluna = colunas[j];
                    if (coluna) {
                        const texto = coluna.textContent.toLowerCase();
                        if (texto.includes(valorBusca)) {
                            encontrou = true;
                            encontrouResultados = true;
                            break;
                        }
                    }
                }

                if (encontrou) {
                    linha.style.display = '';
                } else {
                    linha.style.display = 'none';
                }
            }

            if (!encontrouResultados) {
                linhaNenhumRegistro.style.display = 'table-row';
            } else {
                linhaNenhumRegistro.style.display = 'none';
            }
        });

    </script>

@endsection

