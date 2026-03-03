<?php

namespace App\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\School\Models\Guardian;
use App\Modules\School\Models\Student;
use App\Modules\School\Requests\StoreStudentRequest;
use App\Services\AuditLogService;

class StudentController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index()
    {
        $students = Student::query()->with('guardian')->latest()->paginate(20);

        return view('modules.school.students.index', compact('students'));
    }

    public function create()
    {
        return view('modules.school.students.create');
    }

    public function store(StoreStudentRequest $request)
    {
        $guardian = null;

        if ($request->filled('guardian_name')) {
            $guardian = Guardian::query()->create([
                'name' => $request->input('guardian_name'),
                'phone' => $request->input('guardian_phone'),
                'email' => $request->input('guardian_email'),
                'relationship' => $request->input('guardian_relationship'),
            ]);
        }

        $student = Student::query()->create([
            'guardian_id' => $guardian?->id,
            'admission_no' => $request->input('admission_no'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'status' => $request->input('status', 'active'),
        ]);

        $this->auditLogService->log('school.student.created', Student::class, $student->id);

        return redirect()->route('school.students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['guardian', 'feeInvoices']);

        return view('modules.school.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('modules.school.students.edit', compact('student'));
    }

    public function update(StoreStudentRequest $request, Student $student)
    {
        $student->update($request->safe()->only([
            'admission_no',
            'first_name',
            'last_name',
            'date_of_birth',
            'gender',
            'status',
        ]));

        $this->auditLogService->log('school.student.updated', Student::class, $student->id);

        return redirect()->route('school.students.show', $student)->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        $this->auditLogService->log('school.student.deleted', Student::class, $student->id);

        return redirect()->route('school.students.index')->with('success', 'Student archived successfully.');
    }
}
