<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiwi Pricing</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex justify-between items-center mb-12">
            <a href="{{ route('home') }}" class="text-2xl font-bold">Tiwi</a>
            <a href="{{ route('login') }}" class="text-sm hover:text-cyan-300">Login</a>
        </div>

        <h1 class="text-4xl font-black">Pricing</h1>
        <p class="text-slate-300 mt-2">Per-app monthly pricing for School, Hospital, Property, and POS.</p>

        <div class="mt-10 grid md:grid-cols-3 gap-5">
            @forelse($plans as $plan)
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6">
                    <h2 class="text-xl font-bold">{{ $plan->name }}</h2>
                    <p class="text-3xl font-black mt-3">KES {{ number_format($plan->monthly_price, 2) }}</p>
                    <p class="text-sm text-slate-400 mt-1">{{ $plan->trial_days }} day trial</p>
                    <p class="text-sm text-slate-300 mt-3">{{ $plan->description }}</p>
                    <ul class="mt-4 text-sm space-y-1 text-slate-300">
                        @forelse($plan->modules as $module)
                            <li>{{ $module->name }} - KES {{ number_format($module->pivot->price_override ?? $module->base_price, 2) }}</li>
                        @empty
                            <li>No modules assigned.</li>
                        @endforelse
                    </ul>
                </div>
            @empty
                <p>No plans configured yet.</p>
            @endforelse
        </div>
    </div>
</body>
</html>
