<?php

namespace App\Modules\Hospital\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Hospital\Models\Bill;
use App\Modules\Hospital\Models\HospitalPayment;
use App\Modules\Hospital\Requests\StoreHospitalPaymentRequest;
use App\Services\AuditLogService;

class PaymentController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function store(StoreHospitalPaymentRequest $request, Bill $bill)
    {
        $payment = HospitalPayment::query()->create([
            'bill_id' => $bill->id,
            'amount' => $request->input('amount'),
            'method' => $request->input('method', 'cash'),
            'reference' => $request->input('reference'),
            'paid_at' => now(),
        ]);

        $paid = (float) $bill->payments()->sum('amount');
        $balance = max((float) $bill->total - $paid, 0);

        $bill->update([
            'paid_amount' => $paid,
            'balance' => $balance,
            'status' => $balance <= 0 ? 'paid' : 'partial',
        ]);

        $this->auditLogService->log('hospital.payment.recorded', HospitalPayment::class, $payment->id, ['bill_id' => $bill->id]);

        return redirect()->route('hospital.bills.show', $bill)->with('success', 'Payment recorded.');
    }
}
