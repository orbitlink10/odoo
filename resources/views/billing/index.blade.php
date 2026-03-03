<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Billing & Subscription</h2></x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded">{{ session('error') }}</div>
        @endif

        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="font-semibold text-lg">Current Subscription</h3>
            @if($subscription)
                <p>Status: <span class="font-semibold">{{ $subscription->status }}</span></p>
                <p>Modules: {{ $subscription->modules->pluck('name')->join(', ') }}</p>
                <p>Trial Ends: {{ $subscription->trial_ends_at?->format('Y-m-d') ?? 'N/A' }}</p>
            @else
                <p>No subscription found.</p>
            @endif
        </div>

        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="font-semibold text-lg mb-3">Change Subscription</h3>
            <form method="POST" action="{{ route('billing.subscribe') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm">Plan</label>
                    <select name="plan_id" class="w-full border rounded p-2">
                        <option value="">Custom Per-App</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->name }} - KES {{ number_format($plan->monthly_price,2) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm mb-2">Apps</label>
                    <div class="grid md:grid-cols-2 gap-2">
                        @foreach($tiwiModules as $module)
                            <label class="flex items-center gap-2 border rounded p-2">
                                <input type="checkbox" name="modules[]" value="{{ $module->slug }}" {{ in_array($module->slug, $subscription?->modules->pluck('slug')->all() ?? [], true) ? 'checked' : '' }}>
                                <span>{{ $module->name }} (KES {{ number_format($module->base_price,2) }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-3">
                    <label class="flex items-center gap-2"><input type="checkbox" name="start_trial" value="1" checked> Start Trial</label>
                    <input type="number" name="trial_days" value="14" class="border rounded p-2" placeholder="Trial days">
                </div>
                <button class="px-4 py-2 bg-blue-600 text-white rounded" type="submit">Save Subscription</button>
            </form>
        </div>

        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="font-semibold text-lg mb-3">Invoices</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-3 text-left">Invoice #</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Total</th>
                            <th class="p-3 text-left">Paid</th>
                            <th class="p-3 text-left">Balance</th>
                            <th class="p-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr class="border-t">
                                <td class="p-3">{{ $invoice->invoice_no }}</td>
                                <td class="p-3">{{ $invoice->status }}</td>
                                <td class="p-3">{{ number_format($invoice->total,2) }}</td>
                                <td class="p-3">{{ number_format($invoice->amount_paid,2) }}</td>
                                <td class="p-3">{{ number_format($invoice->balance_due,2) }}</td>
                                <td class="p-3">
                                    @if($invoice->balance_due > 0)
                                        <form method="POST" action="{{ route('billing.pay') }}" class="flex gap-2 items-center">
                                            @csrf
                                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                            <input type="number" step="0.01" name="amount" placeholder="Amount" class="border rounded px-2 py-1 w-24" required>
                                            <input type="text" name="method" value="manual" class="border rounded px-2 py-1 w-24">
                                            <button class="bg-green-600 text-white px-3 py-1 rounded">Pay</button>
                                        </form>
                                    @else
                                        Paid
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td class="p-3" colspan="6">No invoices yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $invoices->links() }}</div>
        </div>
    </div>
</x-app-layout>
