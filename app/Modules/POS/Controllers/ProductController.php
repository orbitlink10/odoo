<?php

namespace App\Modules\POS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\POS\Models\Category;
use App\Modules\POS\Models\Inventory;
use App\Modules\POS\Models\Product;
use App\Modules\POS\Requests\StoreProductRequest;
use App\Services\AuditLogService;

class ProductController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index()
    {
        $products = Product::query()->with(['category', 'inventory'])->latest()->paginate(20);

        return view('modules.pos.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('modules.pos.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::query()->create([
            'category_id' => $request->input('category_id'),
            'sku' => $request->input('sku'),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'tax_rate' => $request->input('tax_rate', 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        Inventory::query()->create([
            'product_id' => $product->id,
            'quantity' => $request->input('quantity', 0),
        ]);

        $this->auditLogService->log('pos.product.created', Product::class, $product->id);

        return redirect()->route('pos.products.index')->with('success', 'Product created.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'inventory']);

        return view('modules.pos.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::query()->orderBy('name')->get();
        $product->load('inventory');

        return view('modules.pos.products.edit', compact('product', 'categories'));
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $product->update([
            'category_id' => $request->input('category_id'),
            'sku' => $request->input('sku'),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'tax_rate' => $request->input('tax_rate', 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        $product->inventory()->updateOrCreate([], ['quantity' => $request->input('quantity', 0)]);

        $this->auditLogService->log('pos.product.updated', Product::class, $product->id);

        return redirect()->route('pos.products.show', $product)->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        $this->auditLogService->log('pos.product.deleted', Product::class, $product->id);

        return redirect()->route('pos.products.index')->with('success', 'Product archived.');
    }
}
