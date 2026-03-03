<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">POS Screen</h2></x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('pos.checkout') }}" class="bg-white p-6 shadow sm:rounded-lg space-y-6">
            @csrf
            <div class="grid md:grid-cols-3 gap-4">
                <div><label class="block text-sm">Customer Name</label><input name="customer_name" class="w-full border rounded p-2"></div>
                <div><label class="block text-sm">Customer Phone</label><input name="customer_phone" class="w-full border rounded p-2"></div>
                <div><label class="block text-sm">Payment Method</label><select name="payment_method" class="w-full border rounded p-2"><option value="cash">Cash</option><option value="card">Card</option><option value="mpesa">M-Pesa</option></select></div>
            </div>

            <div>
                <h3 class="font-semibold mb-2">Cart Items</h3>
                <p class="text-sm text-gray-500 mb-3">Add up to 5 lines; leave unused lines blank.</p>
                <div class="space-y-3">
                    @for($i = 0; $i < 5; $i++)
                        <div class="grid md:grid-cols-2 gap-3">
                            <select name="items[{{ $i }}][product_id]" class="w-full border rounded p-2">
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} ({{ number_format($product->price, 2) }}) - Stock {{ $product->inventory?->quantity ?? 0 }}</option>
                                @endforeach
                            </select>
                            <input type="number" step="0.01" min="0" name="items[{{ $i }}][quantity]" placeholder="Quantity" class="w-full border rounded p-2">
                        </div>
                    @endfor
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div><label class="block text-sm">Discount Total</label><input type="number" step="0.01" name="discount_total" value="0" class="w-full border rounded p-2"></div>
                <div><label class="block text-sm">Paid Amount</label><input type="number" step="0.01" name="paid_amount" class="w-full border rounded p-2" required></div>
                <div class="flex items-end"><button class="w-full px-4 py-2 bg-green-600 text-white rounded" type="submit">Finalize Sale</button></div>
            </div>
        </form>
    </div>
</x-app-layout>
