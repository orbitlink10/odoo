<?php

namespace App\Modules\POS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\POS\Models\Sale;

class ReceiptController extends Controller
{
    public function show(Sale $sale)
    {
        $sale->load(['items.product', 'payments', 'receipt', 'customer']);

        return view('modules.pos.receipt', compact('sale'));
    }
}
