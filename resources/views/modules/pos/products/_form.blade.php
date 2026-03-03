@csrf
<div class="grid md:grid-cols-3 gap-4">
    <div><label class="block text-sm">SKU</label><input name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="w-full border rounded p-2" required></div>
    <div><label class="block text-sm">Name</label><input name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full border rounded p-2" required></div>
    <div><label class="block text-sm">Category</label><select name="category_id" class="w-full border rounded p-2"><option value="">-- None --</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>{{ $category->name }}</option>@endforeach</select></div>
    <div><label class="block text-sm">Price</label><input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" class="w-full border rounded p-2" required></div>
    <div><label class="block text-sm">Tax Rate (%)</label><input type="number" step="0.01" name="tax_rate" value="{{ old('tax_rate', $product->tax_rate ?? 0) }}" class="w-full border rounded p-2"></div>
    <div><label class="block text-sm">Stock Qty</label><input type="number" step="0.01" name="quantity" value="{{ old('quantity', $product->inventory->quantity ?? 0) }}" class="w-full border rounded p-2" required></div>
</div>
<div class="mt-4"><label class="inline-flex items-center gap-2"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))> Active</label></div>
<div class="mt-6"><button class="px-4 py-2 bg-blue-600 text-white rounded" type="submit">{{ $buttonText ?? 'Save' }}</button></div>
