<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @php
            $moduleNav = null;
            $isSchoolModule = false;
            $isPosModule = false;
            $consoleTitle = null;
            $consoleSubtitle = null;

            if (request()->is('app/school*')) {
                $isSchoolModule = true;
                $moduleNav = [
                    ['code' => 'HM', 'label' => 'Home', 'route' => 'school.dashboard'],
                    [
                        'code' => 'AD',
                        'label' => 'Admissions',
                        'route' => 'school.students.index',
                        'children' => [
                            ['label' => 'Students List', 'route' => 'school.students.index'],
                            ['label' => 'Add Student', 'route' => 'school.students.create'],
                        ],
                    ],
                    [
                        'code' => 'AC',
                        'label' => 'Academics',
                        'route' => 'school.classes.index',
                        'children' => [
                            ['label' => 'Classes', 'route' => 'school.classes.index'],
                            ['label' => 'Add Class', 'route' => 'school.classes.create'],
                        ],
                    ],
                    [
                        'code' => 'FN',
                        'label' => 'Finance',
                        'route' => 'school.fee-invoices.index',
                        'children' => [
                            ['label' => 'Fee Invoices', 'route' => 'school.fee-invoices.index'],
                            ['label' => 'Create Invoice', 'route' => 'school.fee-invoices.create'],
                        ],
                    ],
                    ['code' => 'RP', 'label' => 'Reports', 'route' => 'school.reports'],
                    ['code' => 'BL', 'label' => 'Billing', 'route' => 'billing.index'],
                    ['code' => 'SE', 'label' => 'Settings', 'route' => 'app.settings.edit'],
                ];
                $consoleTitle = 'Tiwi School';
                $consoleSubtitle = 'Academic Console';
            } elseif (request()->is('app/hospital*')) {
                $moduleNav = [
                    ['label' => 'Overview', 'route' => 'hospital.dashboard'],
                    ['label' => 'Patients', 'route' => 'hospital.patients.index'],
                    ['label' => 'Appointments', 'route' => 'hospital.appointments.index'],
                    ['label' => 'Visits', 'route' => 'hospital.visits.index'],
                    ['label' => 'Bills', 'route' => 'hospital.bills.index'],
                    ['label' => 'Reports', 'route' => 'hospital.reports'],
                ];
            } elseif (request()->is('app/property*')) {
                $moduleNav = [
                    ['label' => 'Overview', 'route' => 'property.dashboard'],
                    ['label' => 'Properties', 'route' => 'property.properties.index'],
                    ['label' => 'Units', 'route' => 'property.units.index'],
                    ['label' => 'Leases', 'route' => 'property.leases.index'],
                    ['label' => 'Rent Invoices', 'route' => 'property.rent-invoices.index'],
                    ['label' => 'Maintenance', 'route' => 'property.maintenance.index'],
                    ['label' => 'Reports', 'route' => 'property.reports'],
                ];
            } elseif (request()->is('app/pos*')) {
                $isPosModule = true;
                $moduleNav = [
                    [
                        'code' => 'HM',
                        'label' => 'Home',
                        'route' => 'pos.dashboard',
                        'children' => [
                            ['label' => 'Dashboard', 'route' => 'pos.dashboard'],
                            ['label' => 'Today Summary', 'route' => 'pos.reports'],
                        ],
                    ],
                    [
                        'code' => 'ST',
                        'label' => 'Stock',
                        'route' => 'pos.products.index',
                        'children' => [
                            ['label' => 'All Stock', 'route' => 'pos.products.index'],
                            ['label' => 'Add Product', 'route' => 'pos.products.create'],
                        ],
                    ],
                    [
                        'code' => 'SL',
                        'label' => 'Make a Sale',
                        'route' => 'pos.screen',
                        'children' => [
                            ['label' => 'POS Screen', 'route' => 'pos.screen'],
                            ['label' => 'Checkout Report', 'route' => 'pos.reports'],
                        ],
                    ],
                    [
                        'code' => 'SH',
                        'label' => 'Sales History',
                        'route' => 'pos.reports',
                        'children' => [
                            ['label' => 'Daily Reports', 'route' => 'pos.reports'],
                            ['label' => 'Recent Sales', 'route' => 'pos.dashboard'],
                        ],
                    ],
                    [
                        'code' => 'PD',
                        'label' => 'Products',
                        'route' => 'pos.products.index',
                        'children' => [
                            ['label' => 'Product List', 'route' => 'pos.products.index'],
                            ['label' => 'Create Product', 'route' => 'pos.products.create'],
                        ],
                    ],
                    [
                        'code' => 'BR',
                        'label' => 'Branches',
                        'route' => 'pos.branches.index',
                        'children' => [
                            ['label' => 'Branch List', 'route' => 'pos.branches.index'],
                        ],
                    ],
                    [
                        'code' => 'BL',
                        'label' => 'Billing',
                        'route' => 'billing.index',
                        'children' => [
                            ['label' => 'Billing Center', 'route' => 'billing.index'],
                        ],
                    ],
                    [
                        'code' => 'PG',
                        'label' => 'Pages',
                        'route' => 'pos.pages.index',
                        'children' => [
                            ['label' => 'POS Pages', 'route' => 'pos.pages.index'],
                        ],
                    ],
                    [
                        'code' => 'SE',
                        'label' => 'Settings',
                        'route' => 'app.settings.edit',
                        'children' => [
                            ['label' => 'App Settings', 'route' => 'app.settings.edit'],
                        ],
                    ],
                    [
                        'code' => 'AD',
                        'label' => 'Admin',
                        'route' => 'tenant-admin.users.index',
                        'children' => [
                            ['label' => 'Users', 'route' => 'tenant-admin.users.index'],
                            ['label' => 'Roles', 'route' => 'tenant-admin.roles.index'],
                        ],
                    ],
                ];
                $consoleTitle = 'Tiwi POS';
                $consoleSubtitle = 'Retail Console';
            }

            $isModernModuleLayout = $isPosModule || $isSchoolModule;
        @endphp

        <div class="min-h-screen {{ $isModernModuleLayout ? 'bg-[#edf2f7]' : 'bg-gray-100' }}">
            @unless($isModernModuleLayout)
                @include('layouts.navigation')
            @endunless

            @isset($header)
                <header class="{{ $isModernModuleLayout ? 'bg-slate-100 border-b border-slate-200' : 'bg-white shadow' }}">
                    <div class="{{ $isModernModuleLayout ? 'py-4 px-6' : 'max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8' }}">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <div class="{{ $isModernModuleLayout ? 'w-full' : 'max-w-7xl mx-auto sm:px-6 lg:px-8 py-4' }}">
                <div class="flex {{ $isModernModuleLayout ? 'gap-0' : 'gap-6' }}">
                    @if($moduleNav)
                        @if($isModernModuleLayout)
                            <aside class="w-[18.5rem] hidden md:block">
                                <div class="sticky top-0 h-screen overflow-y-auto bg-[#0f2954] text-white px-4 py-6 border-r border-[#25416b]">
                                    @php
                                        $tenantName = auth()->user()?->tenant?->name ?? config('app.name', 'Tiwi');
                                        $tenantInitials = collect(explode(' ', $tenantName))
                                            ->filter()
                                            ->take(2)
                                            ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                                            ->implode('');
                                    @endphp
                                    <div class="flex items-center gap-3 mb-8">
                                        <div class="h-12 w-12 rounded-xl bg-[#b8d8f7] text-[#0f2954] font-extrabold flex items-center justify-center text-lg">
                                            {{ $tenantInitials ?: 'TS' }}
                                        </div>
                                        <div>
                                            <h3 class="{{ $isPosModule ? 'text-[1.05rem] md:text-[1.12rem] leading-[1.1]' : 'text-4xl leading-tight' }} font-extrabold">{{ $consoleTitle }}</h3>
                                            <p class="{{ $isPosModule ? 'text-[0.72rem] md:text-[0.78rem] leading-tight' : 'text-base' }} text-[#a9c0df] mt-1">{{ $consoleSubtitle }}</p>
                                        </div>
                                    </div>

                                    <nav class="space-y-2.5">
                                        @foreach($moduleNav as $item)
                                            @php
                                                $childItems = $item['children'] ?? [];
                                                $isActive = request()->routeIs($item['route'])
                                                    || collect($childItems)->contains(fn ($child) => request()->routeIs($child['route']));
                                            @endphp
                                            <a
                                                href="{{ route($item['route']) }}"
                                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ $isSchoolModule ? 'text-2xl' : 'text-[0.95rem] md:text-[1rem]' }} leading-none font-semibold transition {{ $isActive ? 'bg-[#3c547b] text-white shadow' : 'text-[#b9c8de] hover:bg-[#1a3b6d] hover:text-white' }}"
                                            >
                                                <span class="h-8 w-8 rounded-lg flex items-center justify-center text-xs font-extrabold border border-white/20 {{ $isActive ? 'bg-white/15 text-white' : 'bg-white/5 text-[#d4e0f2]' }}">
                                                    {{ $item['code'] ?? '--' }}
                                                </span>
                                                <span>{{ $item['label'] }}</span>
                                            </a>

                                            @if(($isSchoolModule || $isPosModule) && !empty($childItems) && $isActive)
                                                <div class="ml-12 mt-1.5 mb-2.5 space-y-1">
                                                    @foreach($childItems as $child)
                                                        @php($childActive = request()->routeIs($child['route']))
                                                        <a
                                                            href="{{ route($child['route']) }}"
                                                            class="block rounded-lg px-2 py-1 text-[0.68rem] font-medium transition {{ $childActive ? 'bg-[#45618c] text-white' : 'text-[#9fb5d4] hover:text-white hover:bg-[#1a3b6d]' }}"
                                                        >
                                                            {{ $child['label'] }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </nav>
                                </div>
                            </aside>
                        @else
                            <aside class="w-64 hidden lg:block">
                                <div class="bg-white shadow sm:rounded-lg p-4 sticky top-6">
                                    <p class="text-xs uppercase text-gray-500 tracking-wider mb-3">Module Menu</p>
                                    <nav class="space-y-1 text-sm">
                                        @foreach($moduleNav as $item)
                                            <a
                                                href="{{ route($item['route']) }}"
                                                class="block px-3 py-2 rounded {{ request()->routeIs($item['route']) ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}"
                                            >
                                                {{ $item['label'] }}
                                            </a>
                                        @endforeach
                                    </nav>
                                </div>
                            </aside>
                        @endif
                    @endif

                    <main class="{{ $isModernModuleLayout ? 'flex-1 min-w-0 px-5 md:px-9 py-6 bg-[#dce3ea]' : 'flex-1 min-w-0' }}">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
