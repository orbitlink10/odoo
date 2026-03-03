<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Tenant Settings</h2></x-slot>
    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('app.settings.update') }}" class="bg-white shadow sm:rounded-lg p-6 space-y-4">
            @csrf
            @method('PUT')
            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="block text-sm">Company Name</label><input name="name" value="{{ old('name', $tenant->name) }}" class="w-full border rounded p-2" required></div>
                <div><label class="block text-sm">Country</label><input name="country" value="{{ old('country', $tenant->country) }}" class="w-full border rounded p-2" required></div>
                <div><label class="block text-sm">Timezone</label><input name="timezone" value="{{ old('timezone', $tenant->timezone) }}" class="w-full border rounded p-2" required></div>
                <div><label class="block text-sm">Currency</label><input name="currency" value="{{ old('currency', $tenant->currency) }}" class="w-full border rounded p-2" required></div>
                <div><label class="block text-sm">Logo Path</label><input name="logo_path" value="{{ old('logo_path', $tenant->logo_path) }}" class="w-full border rounded p-2"></div>
            </div>

            <div class="border-t pt-4">
                <h3 class="font-semibold mb-2">Notification Placeholders</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div><label class="block text-sm">SMS Provider</label><input name="sms_provider" value="{{ old('sms_provider', $tenant->settings['sms_provider'] ?? '') }}" class="w-full border rounded p-2"></div>
                    <div><label class="block text-sm">Email Provider</label><input name="email_provider" value="{{ old('email_provider', $tenant->settings['email_provider'] ?? '') }}" class="w-full border rounded p-2"></div>
                </div>
            </div>

            <div class="border-t pt-4">
                <h3 class="font-semibold mb-2">Tax / VAT</h3>
                <div><label class="block text-sm">VAT Rate (%)</label><input type="number" step="0.01" name="vat_rate" value="{{ old('vat_rate', $tenant->settings['vat_rate'] ?? 16) }}" class="w-full border rounded p-2"></div>
            </div>

            <button class="px-4 py-2 bg-blue-600 text-white rounded" type="submit">Save Settings</button>
        </form>
    </div>
</x-app-layout>
