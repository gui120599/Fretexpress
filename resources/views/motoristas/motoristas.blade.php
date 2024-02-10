@extends('layouts.app')
@section('title','Motoristas')
@section('content')
    <h1 class="text-2xl font-bold mb-4">Motoristas</h1>
    <div class="w-full p-1 gap-4 flex flex-wrap md:flex-nowrap justify-between items-center">
        <!-- Botão Adicionar -->
        <div class="mb-4 w-full md:w-1/4">
            <button id="botaoAdicionar" class="w-full md:w-auto lg:max-w-sm flex items-center bg-blue-400 hover:bg-blue-900 p-1 rounded text-white justify-center font-semibold abrir-modal">
                <i class='bx bx-plus'></i>
                <span>Adicionar</span>
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

    <div class="w-[18rem] sm:w-[99%] overflow-x-auto mx-auto">

        <table class="w-full" id="tabela">
            <thead class="bg-gray-50 border-2 border-gray-200">
            <tr>
                <th class="border-2">ID</th>
                <th class="border-2 px-4">Nome</th>
                <th class="border-2 px-10">Sobrenome</th>
                <th class="border-2 px-6">Celular</th>
                <th class="border-2">Opções</th>
            </tr>
            </thead>
            <tbody>
            <tr class="hover:bg-gray-50" id="nenhumRegistroEncontrado" style="display: none;">
                <td class="border-2" colspan="5">Nenhum registro encontrado</td>
            </tr>
            @foreach($motoristas as $motorista)
                <tr class="hover:bg-gray-50">
                    <th class="border-2">{{ $motorista->id }}</th>
                    <td class="border-2">{{ $motorista->motorista_primeiro_nome }}</td>
                    <td class="border-2">{{ $motorista->motorista_sobrenome }}</td>
                    <td class="border-2">{{ $motorista->motorista_celular }}</td>
                    <td class="border-2">
                        <div class="flex items-center justify-center space-x-4">
                            <button class="text-xl" title="Editar" onclick="window.location.href = '{{ route('motoristas.edit', $motorista->id) }}'"><i class='bx bxs-edit'></i></button>
                            <form method="POST" action="{{route('motoristas.destroy', $motorista->id)}}">
                                @method('delete')
                                @csrf
                                <button class="text-xl" title="Excluir"><i class='bx bxs-x-square'></i></button>
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
            <i class='bx bx-id-card text-4xl mr-4'></i>
            <label>Adicionar um novo Motorista</label>
        </h2>
    @endsection
    @section('modal-content')
        <div class="w-full  mx-auto p-4">
            <form id="motoristaForm" method="POST" action="{{route('motoristas.store')}}">
                @csrf()
                <div class="mb-4">
                    <label for="motorista_primeiro_nome" class="block text-sm font-medium text-gray-700">Nome</label>
                    <input type="text" name="motorista_primeiro_nome" id="motorista_primeiro_nome" value="{{ $motorista_edit['motorista_primeiro_nome'] }}" class="w-full border-gray-300 rounded-md p-2" placeholder="Digite o nome">
                </div>
                <div class="mb-4">
                    <label for="motorista_sobrenome" class="block text-sm font-medium text-gray-700">Sobrenome</label>
                    <input type="text" name="motorista_sobrenome" id="motorista_sobrenome" value="{{ $motorista_edit['motorista_sobrenome'] }}" class="w-full border-gray-300 rounded-md p-2" placeholder="Digite o sobrenome">
                </div>
                <div class="mb-4">
                    <label for="motorista_apelido" class="block text-sm font-medium text-gray-700">Apelido</label>
                    <input type="text" name="motorista_apelido" id="motorista_apelido" value="{{ $motorista_edit['motorista_apelido'] }}" class="w-full border-gray-300 rounded-md p-2" placeholder="Digite o apelido">
                </div>
                <div class="mb-4">
                    <label for="motorista_celular" class="block text-sm font-medium text-gray-700">Celular</label>
                    <input type="text" name="motorista_celular" id="motorista_celular" value="{{ $motorista_edit['motorista_celular'] }}" class="w-full border-gray-300 rounded-md p-2" placeholder="(DDD)9 0000-0000">
                </div>
                <div class="w-full flex">
                    <button type="button" class="w-1/4 px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-300 mr-2 cancelar-modal">Cancelar</button>
                    <button type="submit" class="w-3/4 bg-blue-400 hover:bg-blue-900 p-1 rounded text-white font-semibold">
                        <span>Salvar</span>
                    </button>
                </div>
            </form>
        </div>
    @endsection
    <script>

        //Eventos quando o botao editar for clicado
        document.addEventListener('DOMContentLoaded', function() {
            //Essa variavel vem do controller edit para identificar que o usuario
            //deseja realizar a edição do objeto
            const resultEdit = '{{$result}}';

            if(resultEdit === 'edit'){
                const botaoAdicionar = document.getElementById('botaoAdicionar');
                const formulario = document.getElementById('motoristaForm');

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
                    formulario.action = '{{ route('motoristas.update',$motorista_edit['id']) }}';


                    // Adicione o novo campo ao formulário
                    formulario.appendChild(novoCampo);

                } else {
                    console.error('Elementos não encontrado');// Exibe um erro no console caso o botão não seja encontrado
                }
                //Caso o usuario clique no botao de fechar o modal a
                // tela deve voltar a tela inicial de motoristas
                document.getElementById('fechar-modal').addEventListener('click', function () {
                    window.location.href = '{{ route('motoristas.motoristas') }}';
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

