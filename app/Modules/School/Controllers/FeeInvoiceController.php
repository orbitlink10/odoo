<?php

namespace App\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\School\Models\Fee;
use App\Modules\School\Models\FeeInvoice;
use App\Modules\School\Models\Student;
use App\Modules\School\Requests\StoreFeeInvoiceRequest;
use App\Services\AuditLogService;
use Illuminate\Support\Facades\DB;

class FeeInvoiceController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index()
    {
        $invoices = FeeInvoice::query()->with('student')->latest()->paginate(20);

        return view('modules.school.fee-invoices.index', compact('invoices'));
    }

    public function create()
    {
        $students = Student::query()->orderBy('first_name')->get();

        return view('modules.school.fee-invoices.create', compact('students'));
    }

    public function store(StoreFeeInvoiceRequest $request)
    {
        DB::transaction(function () use ($request): void {
            $fee = Fee::query()->create([
                'name' => $request->input('fee_name'),
                'term' => $request->input('term'),
                'amount' => $request->input('amount'),
                'due_date' => $request->input('due_date'),
            ]);

            $invoice = FeeInvoice::query()->create([
                'student_id' => $request->integer('student_id'),
                'fee_id' => $fee->id,
                'invoice_no' => sprintf('SFI-%s-%04d', now()->format('Ym'), random_int(1, 9999)),
                'issue_date' => now()->toDateString(),
                'due_date' => $request->input('due_date'),
                'amount' => $request->input('amount'),
                'paid_amount' => 0,
                'balance' => $request->input('amount'),
                'status' => 'unpaid',
            ]);

            $this->auditLogService->log('school.fee_invoice.created', FeeInvoice::class, $invoice->id);
        });

        return redirect()->route('school.fee-invoices.index')->with('success', 'Fee invoice created.');
    }

    public function show(FeeInvoice $feeInvoice)
    {
        $feeInvoice->load(['student', 'payments']);

        return view('modules.school.fee-invoices.show', compact('feeInvoice'));
    }
}
