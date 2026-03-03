<?php

namespace App\Modules\Property\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Property\Models\Lease;
use App\Modules\Property\Models\PropertyPayment;
use App\Modules\Property\Models\RentInvoice;
use App\Modules\Property\Requests\StoreRentInvoiceRequest;
use App\Services\AuditLogService;
use Illuminate\Http\Request;

class RentInvoiceController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index()
    {
        $invoices = RentInvoice::query()->with('lease.rentalTenant')->latest()->paginate(20);

        return view('modules.property.rent-invoices.index', compact('invoices'));
    }

    public function create()
    {
        $leases = Lease::query()->with(['unit', 'rentalTenant'])->orderByDesc('id')->get();

        return view('modules.property.rent-invoices.create', compact('leases'));
    }

    public function store(StoreRentInvoiceRequest $request)
    {
        $invoice = RentInvoice::query()->create([
            'lease_id' => $request->integer('lease_id'),
            'invoice_no' => sprintf('RI-%s-%04d', now()->format('Ym'), random_int(1, 9999)),
            'issue_date' => now()->toDateString(),
            'due_date' => $request->input('due_date'),
            'amount' => $request->input('amount'),
            'paid_amount' => 0,
            'balance' => $request->input('amount'),
            'status' => 'unpaid',
        ]);

        $this->auditLogService->log('property.rent_invoice.created', RentInvoice::class, $invoice->id);

        return redirect()->route('property.rent-invoices.show', $invoice)->with('success', 'Rent invoice created.');
    }

    public function show(RentInvoice $rentInvoice)
    {
        $rentInvoice->load(['lease.rentalTenant', 'payments']);

        return view('modules.property.rent-invoices.show', compact('rentInvoice'));
    }

    public function pay(Request $request, RentInvoice $rentInvoice)
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'method' => ['nullable', 'string', 'max:50'],
            'reference' => ['nullable', 'string', 'max:100'],
        ]);

        $payment = PropertyPayment::query()->create([
            'rent_invoice_id' => $rentInvoice->id,
            'amount' => $data['amount'],
            'method' => $data['method'] ?? 'cash',
            'reference' => $data['reference'] ?? null,
            'paid_at' => now(),
        ]);

        $paid = (float) $rentInvoice->payments()->sum('amount');
        $balance = max((float) $rentInvoice->amount - $paid, 0);

        $rentInvoice->update([
            'paid_amount' => $paid,
            'balance' => $balance,
            'status' => $balance <= 0 ? 'paid' : 'partial',
        ]);

        $this->auditLogService->log('property.payment.recorded', PropertyPayment::class, $payment->id, ['invoice_id' => $rentInvoice->id]);

        return redirect()->route('property.rent-invoices.show', $rentInvoice)->with('success', 'Payment recorded.');
    }
}
