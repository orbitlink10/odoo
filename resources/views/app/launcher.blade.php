<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Tiwi Launcher Dashboard</h2>
            <div class="text-sm text-gray-500">{{ now()->format('D, d M Y') }}</div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-lg border border-green-200">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded-lg border border-red-200">{{ session('error') }}</div>
        @endif

        @if(! $tenant)
            <div class="bg-amber-50 border border-amber-200 p-6 rounded-xl">
                <h3 class="font-bold text-lg text-amber-900">Complete tenant onboarding</h3>
                <p class="mt-1 text-amber-800">Your account is active but no company workspace exists yet.</p>
                <a href="{{ route('onboarding.create') }}" class="inline-block mt-4 px-4 py-2 bg-amber-600 text-white rounded-lg font-semibold">Start Onboarding</a>
            </div>
        @else
            <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Tenant</p>
                        <p class="text-xl font-bold text-gray-800">{{ $tenant->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Subscription</p>
                        <p class="text-xl font-bold {{ $subscriptionActive ? 'text-green-600' : 'text-amber-600' }}">{{ $subscription?->status ?? 'none' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Workspace</p>
                        <p class="text-xl font-bold text-gray-800">{{ $tenant->currency }} | {{ $tenant->timezone }}</p>
                    </div>
                </div>
                @if(! $subscriptionActive)
                    <div class="mt-4 p-3 rounded-lg bg-amber-50 text-amber-900 text-sm border border-amber-200">
                        Subscription inactive. Only Billing + limited launcher are available until payment/reactivation.
                    </div>
                @endif
            </div>

            <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-5">
                @foreach($modules as $module)
                    @php($enabled = in_array($module->slug, $enabledModuleSlugs, true) && $subscriptionActive)
                    @php($insight = $moduleInsights[$module->slug] ?? ['primary' => 'No data', 'secondary' => ''])
                    <div class="bg-white shadow-sm rounded-xl border p-5 {{ $enabled ? 'border-green-200' : 'border-gray-200' }}">
                        <div class="flex items-center justify-between gap-2">
                            <h4 class="font-bold text-lg text-gray-800">{{ $module->name }}</h4>
                            <span class="text-xs px-2 py-1 rounded-full {{ $enabled ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ $enabled ? 'Enabled' : 'Not active' }}</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">KES {{ number_format($module->base_price, 2) }}/month</p>
                        <div class="mt-4 space-y-1">
                            <p class="text-sm font-semibold text-gray-800">{{ $insight['primary'] }}</p>
                            <p class="text-sm text-gray-500">{{ $insight['secondary'] }}</p>
                        </div>
                        <div class="mt-5">
                            @if($enabled)
                                <a href="{{ url('/app/'.$module->slug) }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold">Open Dashboard</a>
                            @else
                                <a href="{{ route('billing.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-800 text-white font-semibold">Manage Billing</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="grid lg:grid-cols-2 gap-5">
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h3 class="font-bold text-lg">Quick Access</h3>
                    <div class="mt-4 grid sm:grid-cols-2 gap-3 text-sm">
                        <a href="{{ route('billing.index') }}" class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50">Billing & Invoices</a>
                        <a href="{{ route('app.settings.edit') }}" class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50">Tenant Settings</a>
                        @if(auth()->user()?->hasPermission('platform.tenant_admin.access'))
                            <a href="{{ route('tenant-admin.users.index') }}" class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50">Tenant Users</a>
                        @endif
                        @if(auth()->user()?->is_super_admin)
                            <a href="{{ route('admin.tenants.index') }}" class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50">Super Admin Panel</a>
                        @endif
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h3 class="font-bold text-lg">Need help getting started?</h3>
                    <p class="mt-2 text-sm text-gray-600">Open an app dashboard, then use the sidebar to create records and run reports. Start with onboarding your users and assigning roles.</p>
                    <div class="mt-4 text-sm text-gray-500">
                        Tip: Each module URL is fixed: <span class="font-mono">/app/school</span>, <span class="font-mono">/app/hospital</span>, <span class="font-mono">/app/property</span>, <span class="font-mono">/app/pos</span>.
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
