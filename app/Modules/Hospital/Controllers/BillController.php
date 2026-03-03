<?php

namespace App\Modules\Hospital\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Hospital\Models\Bill;
use App\Modules\Hospital\Models\BillItem;
use App\Modules\Hospital\Models\Patient;
use App\Modules\Hospital\Requests\StoreBillRequest;
use App\Services\AuditLogService;

class BillController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index()
    {
        $bills = Bill::query()->with('patient')->latest()->paginate(20);

        return view('modules.hospital.bills.index', compact('bills'));
    }

    public function create()
    {
        $patients = Patient::query()->orderBy('first_name')->get();

        return view('modules.hospital.bills.create', compact('patients'));
    }

    public function store(StoreBillRequest $request)
    {
        $lineTotal = (float) $request->input('quantity') * (float) $request->input('unit_price');

        $bill = Bill::query()->create([
            'patient_id' => $request->integer('patient_id'),
            'bill_no' => sprintf('HB-%s-%04d', now()->format('Ym'), random_int(1, 9999)),
            'issue_date' => now()->toDateString(),
            'total' => $lineTotal,
            'paid_amount' => 0,
            'balance' => $lineTotal,
            'status' => 'unpaid',
        ]);

        BillItem::query()->create([
            'bill_id' => $bill->id,
            'description' => $request->input('description'),
            'quantity' => $request->integer('quantity'),
            'unit_price' => $request->input('unit_price'),
            'line_total' => $lineTotal,
        ]);

        $this->auditLogService->log('hospital.bill.created', Bill::class, $bill->id);

        return redirect()->route('hospital.bills.show', $bill)->with('success', 'Bill created.');
    }

    public function show(Bill $bill)
    {
        $bill->load(['patient', 'items', 'payments']);

        return view('modules.hospital.bills.show', compact('bill'));
    }
}
