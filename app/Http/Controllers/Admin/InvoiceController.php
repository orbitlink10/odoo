<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::query()
            ->withoutGlobalScope('tenant')
            ->with(['tenant', 'subscription'])
            ->latest()
            ->paginate(20);

        return view('admin.invoices.index', compact('invoices'));
    }
}
