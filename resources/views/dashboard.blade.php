@extends('layouts.app')
@section('title','Dashboard')
@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
    <div class="w-full mx-auto mt-2 mb-2 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Card de Entradas -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">Total Entradas</h2>
                <i class='bx bx-dollar text-2xl'></i>
            </div>
            <div class="mt-4">
                <p class="text-gray-600">Valor de Entradas:</p>
                <p class="text-3xl font-semibold text-green-500 entradas">R$ 7.000,00</p>
            </div>
        </div>

        <!-- Card de Saídas -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">Total Saídas</h2>
                <i class='bx bx-wallet text-2xl'></i>
            </div>
            <div class="mt-4">
                <p class="text-gray-600">Valor de Saídas:</p>
                <p class="text-3xl font-semibold text-red-500 saidas">R$ 5.000,00</p>
            </div>
        </div>

        <!-- Card de Entradas -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">Entradas Mensal</h2>
                <i class='bx bx-dollar text-2xl'></i>
            </div>
            <div class="mt-4">
                <p class="text-gray-600">Valor de Entradas:</p>
                <p class="text-3xl font-semibold text-green-500 entradas-mensal">R$ 7.000,00</p>
            </div>
        </div>

        <!-- Card de Saídas -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">Saídas Mensal</h2>
                <i class='bx bx-wallet text-2xl'></i>
            </div>
            <div class="mt-4">
                <p class="text-gray-600">Valor de Saídas:</p>
                <p class="text-3xl font-semibold text-red-500 saidas-mensal">R$ 5.000,00</p>
            </div>
        </div>

        <!-- Card de Quantidade de Fretes -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">Total de Fretes</h2>
                <i class='bx bx-truck text-2xl'></i>
            </div>
            <div class="mt-4">
                <p class="text-gray-600">Total de Fretes:</p>
                <p class="text-3xl font-semibold text-purple-500 fretes">100</p>
            </div>
        </div>

        <!-- Card de Quantidade de Fretes -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">Quantidade de Fretes Mensal</h2>
                <i class='bx bx-truck text-2xl'></i>
            </div>
            <div class="mt-4">
                <p class="text-gray-600">Total de Fretes:</p>
                <p class="text-3xl font-semibold text-purple-500 fretes-mensal">100</p>
            </div>
        </div>

        <!-- Card de Quantidade de Motoristas -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">Quantidade de Motoristas</h2>
                <i class='bx bx-user text-2xl'></i>
            </div>
            <div class="mt-4">
                <p class="text-gray-600">Total de Motoristas:</p>
                <p class="text-3xl font-semibold text-blue-500">25</p>
            </div>
        </div>
    </div>
    <div class="flex flex-wrap">
        <div class="w-full sm:w-1/2 max-h-96 overflow-x-auto">
            <div class="bg-white p-4 shadow-md" style="max-width: 100%; overflow-x: auto;">
                <h2 class="text-xl font-semibold mb-4">Quantidade de Fretes Mensais</h2>
                <canvas id="fretesChart" class="w-full max-h-72 text-[10px] sm:text-base"></canvas>
            </div>
        </div>
        <div class="w-full sm:w-1/2 max-h-96 overflow-x-auto">
            <div class="bg-white p-4 shadow-md" style="max-width: 100%; overflow-x: auto;">
                <h2 class="text-xl font-semibold mb-4">Receitas por Motorista</h2>
                <canvas id="fretesChart2" class="w-full max-h-72 text-[10px] sm:text-base"></canvas>
            </div>
        </div>
    </div>
    <div class="hidden" id="dadosCompletos" data-dados="{{ json_encode($dadosCompletos) }}"></div>


    <script>

        document.addEventListener("DOMContentLoaded", function () {
            // Preencha os cards com os dados retornados
            document.querySelector(".saidas").textContent = `R$ {{ $valorSaidas }}`;
            document.querySelector(".entradas").textContent = `R$ {{ $valorEntradas }}`;
            document.querySelector(".fretes").textContent = `{{ $totalFretes }}`;
            document.querySelector(".saidas-mensal").textContent = `R$ {{ $valorSaidasMesAtual }}`;
            document.querySelector(".entradas-mensal").textContent = `R$ {{ $valorEntradasMesAtual }}`;
            document.querySelector(".fretes-mensal").textContent = `{{ $totalFretes }}`;
            document.querySelector(".text-blue-500").textContent = `{{ $totalMotoristas }}`;
        });

            document.addEventListener("DOMContentLoaded", function () {
                const ctx = document.getElementById("fretesChart").getContext("2d");

                // Dados de exemplo (substitua isso com os dados reais do seu banco de dados)
                const dadosDoBancoDeDados = {!! $dadosFretes !!};

                // Mapear os nomes dos meses
                const meses = [
                    'Janeiro', 'Fevereiro', 'Março', 'Abril',
                    'Maio', 'Junho', 'Julho', 'Agosto',
                    'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                ];

                // Organizar os dados em um formato adequado para o gráfico
                const data = {
                    labels: meses, // Rótulos dos meses
                    datasets: []
                };

                // Organizar os dados por motorista
                const motoristas = {};

                dadosDoBancoDeDados.forEach(item => {
                    const mes = meses[item.mes - 1]; // Os meses começam em 1
                    const motorista = item.motorista_apelido;

                    if (!motoristas[motorista]) {
                        motoristas[motorista] = Array(12).fill(0);
                    }

                    motoristas[motorista][meses.indexOf(mes)] = item.quantidade_fretes;
                });

                // Adicionar cada motorista como um conjunto de dados no gráfico
                for (const motorista in motoristas) {
                    if (motoristas.hasOwnProperty(motorista)) {
                        data.datasets.push({
                            label: motorista,
                            backgroundColor: `rgba(${Math.random() * 255}, ${Math.random() * 255}, ${Math.random() * 255}, 0.6)`,
                            borderColor: `rgba(${Math.random() * 255}, ${Math.random() * 255}, ${Math.random() * 255}, 1)`,
                            data: motoristas[motorista]
                        });
                    }
                }

                // Configurações do gráfico
                const options = {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: true
                            },
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        },
                    },
                };

                // Criar o gráfico de barras
                const chart = new Chart(ctx, {
                    type: "bar",
                    data: data,
                    options: options,
                });
            });

            document.addEventListener("DOMContentLoaded", function () {
                const ctx = document.getElementById("fretesChart2").getContext("2d");

                // Dados de exemplo (substitua isso com os dados reais do seu banco de dados)
                const dadosDoBancoDeDados = JSON.parse(document.getElementById("dadosCompletos").getAttribute("data-dados"));


// Mapear os nomes dos meses
                const meses = [
                    'Janeiro', 'Fevereiro', 'Março', 'Abril',
                    'Maio', 'Junho', 'Julho', 'Agosto',
                    'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                ];

// Organizar os dados em um formato adequado para o gráfico
                const data = {
                    labels: meses, // Rótulos dos meses
                    datasets: []
                };

// Organizar os dados por motorista
                const motoristas = {};

                dadosDoBancoDeDados.forEach(item => {
                    const mes = meses[item.mes - 1]; // Os meses começam em 1
                    const motorista = item.motorista_apelido;

                    if (!motoristas[motorista]) {
                        motoristas[motorista] = {
                            entradas: Array(12).fill(0),
                            saidas: Array(12).fill(0),
                        };
                    }

                    // Verifique se é uma entrada ou saída
                    if (item.total_entradas >= 0) {
                        motoristas[motorista].entradas[meses.indexOf(mes)] += parseFloat(item.total_entradas);
                    }
                    if (item.total_saidas >= 0) {
                        motoristas[motorista].saidas[meses.indexOf(mes)] += parseFloat(item.total_saidas);
                    }
                });

// Cores para entradas e saídas
                // Cores para entradas e saídas
                const coresEntrada = 'rgba(0, 128, 0, 0.6)'; // Verde
                const coresSaida = 'rgba(255, 0, 0, 0.6)'; // Vermelho

                // Adicionar cada motorista como um conjunto de dados no gráfico
                for (const motorista in motoristas) {
                    if (motoristas.hasOwnProperty(motorista)) {
                        const entradas = motoristas[motorista].entradas.map(parseFloat); // Converter strings em números
                        const saidas = motoristas[motorista].saidas.map(parseFloat); // Converter strings em números

                        data.datasets.push({
                            label: `${motorista} (Entradas)`,
                            backgroundColor: coresEntrada,
                            borderColor: coresSaida,
                            data: entradas
                        });
                        data.datasets.push({
                            label: `${motorista} (Saídas)`,
                            backgroundColor: coresSaida,
                            borderColor: coresEntrada,
                            data: saidas
                        });
                    }
                }

// Configurações do gráfico
                const options = {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: true
                            },
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        },
                    },
                };

                // Criar o gráfico de barras
                const chart = new Chart(ctx, {
                    type: "bar",
                    data: data,
                    options: options,
                });
            });


    </script>

@endsection
