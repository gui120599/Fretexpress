<!-- Menu Lateral -->
<div id="sidebar" class="flex flex-col w-14 bg-gradient-to-r from-blue-900 to-blue-500 text-white transition-width duration-300 ease-in-out shadow">
    <aside id="sidebar">
        <div class="p-4">
            <h1 class="flex justify-between text-2xl font-semibold cursor-pointer" id="toggleButton">
                <label class="hidden">Menu</label>
                <i class='bx bx-menu text-4xl'></i>
            </h1>
        </div>
        <ul class="mt-6 py-4">
            <li class="px-4 py-2 hover:bg-blue-600 cursor-pointer">
                <a href="{{route('dashboard')}}">
                    <i class='bx bx-home-alt text-base mr-4'></i>
                    <label class="cursor-pointer hidden">Página Inicial</label>
                </a>
            </li>
            <li class="px-4 py-2 hover:bg-blue-600 cursor-pointer">
                <a href="{{ route('fretes.fretes') }}">
                    <i class='bx bxs-truck text-base mr-4'></i>
                    <label class="cursor-pointer hidden">Fretes</label>
                </a>
            </li>
            <li class="px-4 py-2 hover:bg-blue-600 cursor-pointer">
                <a href="{{ route('entradas.entradas') }}">
                    <i class='bx bx-trending-up text-base mr-4' ></i>
                    <label class="cursor-pointer hidden">Entradas</label>
                </a>
            </li>
            <li class="px-4 py-2 hover:bg-blue-600 cursor-pointer">
                <a href="{{ route('saidas.saidas') }}">
                    <i class='bx bx-trending-down text-base mr-4'></i>
                    <label class="cursor-pointer hidden">Saidas</label>
                </a>
            </li>
            <li class="px-4 py-2 hover:bg-blue-600 cursor-pointer">
                <a href="{{route('motoristas.motoristas')}}">
                    <i class='bx bx-id-card text-base mr-4'></i>
                    <label class="cursor-pointer hidden">Motoristas</label>
                </a>
            </li>
            <li class="px-4 py-2 hover:bg-blue-600 cursor-pointer">
                <a href="{{route('entradas-saidas')}}">
                    <i class='bx bxs-report text-base mr-4'></i>
                    <label class="cursor-pointer hidden">Entradas/Saídas</label>
                </a>
            </li>
            <!-- Adicione mais itens de menu conforme necessário -->
        </ul>
    </aside>
    <ul class="mt-12">
        <li class="px-4 py-2 hover:bg-blue-600 cursor-pointer">
            <!-- Authentication -->
                <a href="{{ route('logout') }}" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class='bx bx-log-out text-base mr-4'></i>
                    <label class="cursor-pointer hidden">Logout</label>
                </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>
