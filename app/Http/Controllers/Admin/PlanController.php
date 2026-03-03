<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::query()->with('modules')->orderBy('monthly_price')->paginate(20);
        $modules = Module::query()->orderBy('name')->get();

        return view('admin.plans.index', compact('plans', 'modules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:50', 'unique:plans,slug'],
            'description' => ['nullable', 'string'],
            'monthly_price' => ['required', 'numeric', 'min:0'],
            'trial_days' => ['required', 'integer', 'min:1', 'max:30'],
            'modules' => ['nullable', 'array'],
            'modules.*' => ['exists:modules,id'],
        ]);

        $plan = Plan::query()->create($data);
        $plan->modules()->sync($request->input('modules', []));

        return redirect()->route('admin.plans.index')->with('success', 'Plan created.');
    }
}
