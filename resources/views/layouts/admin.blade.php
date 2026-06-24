<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - RHU Peñarrubia PRMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="bg-green-800 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out z-30" :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
            <div class="px-4">
                <h2 class="text-xl font-bold">RHU Peñarrubia</h2>
                <p class="text-green-200 text-sm">PRMS</p>
            </div>
            <nav class="space-y-1">
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.dashboard' : 'user.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('*.dashboard') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <span>&#x1F3E0;</span> Dashboard
                </a>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.index' : 'user.patients.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('*.patients.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <span>&#x1F465;</span> Patients
                </a>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.consultations.index' : 'user.consultations.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('*.consultations.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <span>&#x1F48A;</span> Consultations
                </a>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.maternal.index' : 'user.maternal.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('*.maternal.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <span>&#x1F469;&#x200D;&#x1F37C;</span> Maternal Care
                </a>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.immunizations.index' : 'user.immunizations.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('*.immunizations.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <span>&#x1F489;</span> Immunizations
                </a>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.morbidity.index' : 'user.morbidity.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('*.morbidity.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <span>&#x1F4CA;</span> Morbidity
                </a>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.archive.index' : 'user.archive.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('*.archive.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <span>&#x1F4C2;</span> Archive
                </a>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.fhsis.index' : 'user.fhsis.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('*.fhsis.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <span>&#x1F4CB;</span> FHSIS Reports
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <span>&#x1F464;</span> User Management
                </a>
                <a href="{{ route('admin.backup.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.backup.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <span>&#x1F4BE;</span> Backup & Restore
                </a>
                @endif
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.account.index' : 'user.account.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('*.account.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <span>&#x1F512;</span> Account
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white shadow-md px-6 py-3 flex items-center justify-between">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 focus:outline-none md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="text-gray-600">
                    @yield('header', 'Dashboard')
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">{{ auth()->user()->full_name }}</span>
                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">{{ ucfirst(auth()->user()->role) }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">Logout</button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
                @endif
                @if(session('warning'))
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">{{ session('warning') }}</div>
                @endif
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
