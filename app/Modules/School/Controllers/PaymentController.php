<?php

namespace App\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\School\Models\FeeInvoice;
use App\Modules\School\Models\SchoolPayment;
use App\Modules\School\Requests\StoreSchoolPaymentRequest;
use App\Services\AuditLogService;

class PaymentController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function store(StoreSchoolPaymentRequest $request, FeeInvoice $feeInvoice)
    {
        $payment = SchoolPayment::query()->create([
            'fee_invoice_id' => $feeInvoice->id,
            'amount' => $request->input('amount'),
            'method' => $request->input('method', 'cash'),
            'reference' => $request->input('reference'),
            'paid_at' => now(),
        ]);

        $paid = (float) $feeInvoice->payments()->sum('amount');
        $balance = max((float) $feeInvoice->amount - $paid, 0);

        $feeInvoice->update([
            'paid_amount' => $paid,
            'balance' => $balance,
            'status' => $balance <= 0 ? 'paid' : 'partial',
        ]);

        $this->auditLogService->log('school.payment.recorded', SchoolPayment::class, $payment->id, ['invoice_id' => $feeInvoice->id]);

        return redirect()->route('school.fee-invoices.show', $feeInvoice)->with('success', 'Payment recorded.');
    }
}
