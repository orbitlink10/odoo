<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $selectedModule = $request->query('module');
        $allowedModules = ['school', 'hospital', 'property', 'pos'];

        if (! in_array($selectedModule, $allowedModules, true)) {
            $selectedModule = null;
        }

        return view('auth.register', compact('selectedModule'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'selected_module' => ['nullable', Rule::in(['school', 'hospital', 'property', 'pos'])],
            'school_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($request->filled('selected_module')) {
            $params = ['module' => $request->string('selected_module')->toString()];

            if ($request->filled('school_name')) {
                $params['company_name'] = $request->string('school_name')->toString();
            }

            if ($request->filled('phone')) {
                $params['admin_phone'] = $request->string('phone')->toString();
            }

            return redirect()->route('onboarding.create', $params);
        }

        return redirect(route('dashboard', absolute: false));
    }
}
