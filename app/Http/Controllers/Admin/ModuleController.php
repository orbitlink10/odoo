<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::query()->orderBy('name')->paginate(20);

        return view('admin.modules.index', compact('modules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:50', 'unique:modules,slug'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        Module::query()->create($data);

        return redirect()->route('admin.modules.index')->with('success', 'Module created.');
    }
}
