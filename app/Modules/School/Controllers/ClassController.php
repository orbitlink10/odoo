<?php

namespace App\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\School\Models\SchoolClass;
use App\Modules\School\Requests\StoreClassRequest;
use App\Services\AuditLogService;

class ClassController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index()
    {
        $classes = SchoolClass::query()->latest()->paginate(20);

        return view('modules.school.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('modules.school.classes.create');
    }

    public function store(StoreClassRequest $request)
    {
        $class = SchoolClass::query()->create($request->validated());
        $this->auditLogService->log('school.class.created', SchoolClass::class, $class->id);

        return redirect()->route('school.classes.index')->with('success', 'Class created.');
    }

    public function show(SchoolClass $class)
    {
        $class->load('enrollments.student');

        return view('modules.school.classes.show', compact('class'));
    }

    public function edit(SchoolClass $class)
    {
        return view('modules.school.classes.edit', compact('class'));
    }

    public function update(StoreClassRequest $request, SchoolClass $class)
    {
        $class->update($request->validated());
        $this->auditLogService->log('school.class.updated', SchoolClass::class, $class->id);

        return redirect()->route('school.classes.show', $class)->with('success', 'Class updated.');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        $this->auditLogService->log('school.class.deleted', SchoolClass::class, $class->id);

        return redirect()->route('school.classes.index')->with('success', 'Class removed.');
    }
}
