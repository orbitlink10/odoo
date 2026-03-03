<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-2xl text-slate-900 leading-tight">Tenant Onboarding</h2>
            <p class="text-sm text-slate-500">Set up your organization, choose modules, and start your subscription in one flow.</p>
        </div>
    </x-slot>

    @php
        $moduleLocked = !empty($selectedModule);
        $defaultSelection = $moduleLocked ? [$selectedModule] : $modules->pluck('slug')->all();
        $selectedModules = $moduleLocked
            ? [$selectedModule]
            : collect(old('modules', $defaultSelection))
                ->map(fn ($slug) => (string) $slug)
                ->values()
                ->all();
        $lockedModuleDetails = $moduleLocked ? $modules->firstWhere('slug', $selectedModule) : null;
        $schoolSelected = in_array('school', $selectedModules, true);
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if($errors->any())
                <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <p class="font-semibold">Please fix the highlighted fields before continuing.</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('onboarding.store') }}">
                @csrf
                @if($moduleLocked)
                    <input type="hidden" name="locked_module" value="{{ $selectedModule }}">
                    <input type="hidden" name="modules[]" value="{{ $selectedModule }}">
                @endif

                <div class="mb-4 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-indigo-100 bg-indigo-50 px-4 py-3">
                    <p class="text-sm text-indigo-900 font-medium">Complete this setup once to activate your module dashboard.</p>
                    <button type="submit" class="inline-flex items-center rounded-xl bg-indigo-600 text-white font-semibold py-2.5 px-4 hover:bg-indigo-700 transition">
                        Finish Onboarding
                    </button>
                </div>

                <div class="grid xl:grid-cols-3 gap-6 items-start">
                    <div class="xl:col-span-2 space-y-6">
                        <section class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                            <div class="flex items-center justify-between gap-4 mb-4">
                                <h3 class="text-lg font-semibold text-slate-900">1. Company Profile</h3>
                                <span class="text-xs uppercase tracking-wide font-semibold text-slate-500">Required</span>
                            </div>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Company Name</label>
                                    <input name="company_name" value="{{ old('company_name', $prefill['company_name'] ?? '') }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('company_name')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Country Code</label>
                                    <input name="country" value="{{ old('country', 'KE') }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" maxlength="2" required>
                                    @error('country')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Timezone</label>
                                    <input name="timezone" value="{{ old('timezone', 'Africa/Nairobi') }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('timezone')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Currency</label>
                                    <input name="currency" value="{{ old('currency', 'KES') }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" maxlength="3" required>
                                    @error('currency')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        <section class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                            <div class="flex items-center justify-between gap-4 mb-4">
                                <h3 class="text-lg font-semibold text-slate-900">2. First Admin</h3>
                                <span class="text-xs uppercase tracking-wide font-semibold text-slate-500">Required</span>
                            </div>
                            <div class="grid md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                                    <input name="admin_name" value="{{ old('admin_name', auth()->user()->name) }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('admin_name')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Work Email</label>
                                    <input name="admin_email" type="email" value="{{ old('admin_email', auth()->user()->email) }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('admin_email')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
                                    <input name="admin_phone" value="{{ old('admin_phone', $prefill['admin_phone'] ?? '') }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('admin_phone')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        @if($moduleLocked)
                            <section class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                                    <h3 class="text-lg font-semibold text-slate-900">3. Selected Module</h3>
                                    <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">
                                        Locked from sign up
                                    </span>
                                </div>
                                <p class="text-sm text-slate-600 mb-4">
                                    You selected <span class="font-semibold text-indigo-700">{{ ucfirst($selectedModule) }}</span> during sign up.
                                    Additional modules can be enabled later from Billing.
                                </p>
                                <div class="rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-3 flex items-center justify-between">
                                    <span class="font-semibold text-indigo-900">{{ $lockedModuleDetails?->name ?? ucfirst($selectedModule) }}</span>
                                    <span class="text-indigo-700 font-medium">KES {{ number_format((float) ($lockedModuleDetails?->base_price ?? 0), 2) }} / month</span>
                                </div>
                            </section>
                        @else
                            <section class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                                    <h3 class="text-lg font-semibold text-slate-900">3. Choose Modules</h3>
                                    <span class="text-xs font-semibold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-full">
                                        Select one or more modules
                                    </span>
                                </div>

                                @error('modules')
                                    <p class="text-rose-600 text-xs mb-3">{{ $message }}</p>
                                @enderror

                                <div class="grid md:grid-cols-2 gap-3">
                                    @foreach($modules as $module)
                                        @php($isChecked = in_array($module->slug, $selectedModules, true))
                                        <label class="flex items-start gap-3 rounded-xl border p-4 cursor-pointer transition {{ $isChecked ? 'border-indigo-300 bg-indigo-50/40' : 'border-slate-200 bg-white' }}">
                                            <input
                                                type="checkbox"
                                                name="modules[]"
                                                value="{{ $module->slug }}"
                                                class="module-checkbox mt-1 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                                data-price="{{ (float) $module->base_price }}"
                                                @checked($isChecked)
                                            >
                                            <span class="block">
                                                <span class="block font-semibold text-slate-900">{{ $module->name }}</span>
                                                <span class="block text-sm text-slate-500">KES {{ number_format((float) $module->base_price, 2) }} / month</span>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        <section id="school-setup" class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 {{ $schoolSelected ? '' : 'hidden' }}">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-slate-900">4. School Setup Details</h3>
                                <span class="text-xs uppercase tracking-wide font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">School Module</span>
                            </div>

                            <p class="text-sm text-slate-600 mb-4">
                                Student records, class management, fee invoicing, payment tracking, and outstanding reports in one streamlined system.
                            </p>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">School Registration Number</label>
                                    <input name="school_registration_number" value="{{ old('school_registration_number') }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" @disabled(! $schoolSelected)>
                                    @error('school_registration_number')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">School Type</label>
                                    <select name="school_type" data-required-school class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" @if($schoolSelected) required @endif @disabled(! $schoolSelected)>
                                        <option value="">Select type</option>
                                        <option value="primary" @selected(old('school_type') === 'primary')>Primary</option>
                                        <option value="secondary" @selected(old('school_type') === 'secondary')>Secondary</option>
                                        <option value="college" @selected(old('school_type') === 'college')>College</option>
                                        <option value="university" @selected(old('school_type') === 'university')>University</option>
                                        <option value="mixed" @selected(old('school_type') === 'mixed')>Mixed / Multi-Level</option>
                                    </select>
                                    @error('school_type')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Admission Intake Mode</label>
                                    <select name="admission_term" data-required-school class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" @if($schoolSelected) required @endif @disabled(! $schoolSelected)>
                                        <option value="">Select mode</option>
                                        <option value="rolling" @selected(old('admission_term') === 'rolling')>Rolling Admissions</option>
                                        <option value="term_1" @selected(old('admission_term') === 'term_1')>Term 1 Intake</option>
                                        <option value="term_2" @selected(old('admission_term') === 'term_2')>Term 2 Intake</option>
                                        <option value="term_3" @selected(old('admission_term') === 'term_3')>Term 3 Intake</option>
                                    </select>
                                    @error('admission_term')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Estimated Student Capacity</label>
                                    <input name="student_capacity" type="number" min="1" max="50000" value="{{ old('student_capacity') }}" data-required-school class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" @if($schoolSelected) required @endif @disabled(! $schoolSelected)>
                                    @error('student_capacity')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Academic Year Start Date</label>
                                    <input name="academic_year_start" type="date" value="{{ old('academic_year_start') }}" data-required-school class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" @if($schoolSelected) required @endif @disabled(! $schoolSelected)>
                                    @error('academic_year_start')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Monthly Fee Due Day</label>
                                    <input name="fee_due_day" type="number" min="1" max="31" value="{{ old('fee_due_day', 5) }}" data-required-school class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" @if($schoolSelected) required @endif @disabled(! $schoolSelected)>
                                    @error('fee_due_day')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-5 grid md:grid-cols-2 gap-3">
                                <article class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <h4 class="font-semibold text-slate-900">Admissions</h4>
                                    <p class="text-sm text-slate-600 mt-1">Built into one secure tenant dashboard.</p>
                                </article>
                                <article class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <h4 class="font-semibold text-slate-900">Fees</h4>
                                    <p class="text-sm text-slate-600 mt-1">Built into one secure tenant dashboard.</p>
                                </article>
                                <article class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <h4 class="font-semibold text-slate-900">Reports</h4>
                                    <p class="text-sm text-slate-600 mt-1">Built into one secure tenant dashboard.</p>
                                </article>
                                <article class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <h4 class="font-semibold text-slate-900">Features</h4>
                                    <p class="text-sm text-slate-600 mt-1">Built into one secure tenant dashboard.</p>
                                </article>
                            </div>

                            <div class="mt-5 grid sm:grid-cols-2 gap-4">
                                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                    <input type="hidden" name="fee_reminder_email" value="0" @disabled(! $schoolSelected)>
                                    <input type="checkbox" name="fee_reminder_email" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" @checked(old('fee_reminder_email', true)) @disabled(! $schoolSelected)>
                                    Enable fee reminder emails
                                </label>
                                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                    <input type="hidden" name="fee_reminder_sms" value="0" @disabled(! $schoolSelected)>
                                    <input type="checkbox" name="fee_reminder_sms" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" @checked(old('fee_reminder_sms', false)) @disabled(! $schoolSelected)>
                                    Enable fee reminder SMS
                                </label>
                            </div>
                        </section>
                    </div>

                    <aside class="space-y-6 xl:sticky xl:top-24">
                        <section class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                            <h3 class="text-lg font-semibold text-slate-900 mb-3">Subscription & Trial</h3>
                            <p class="text-sm text-slate-600 mb-4">Trialing starts immediately after onboarding.</p>
                            <div class="space-y-4">
                                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                    <input type="hidden" name="start_trial" value="0">
                                    <input type="checkbox" name="start_trial" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" @checked(old('start_trial', true))>
                                    Start trial now
                                </label>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Trial Days</label>
                                    <input type="number" name="trial_days" min="1" max="30" value="{{ old('trial_days', 14) }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trial_days')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        <section class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                            <h3 class="text-lg font-semibold text-slate-900 mb-3">Selected Modules</h3>
                            <p class="text-sm text-slate-600 mb-4">
                                <span id="selected-module-count">{{ count($selectedModules) }}</span> module(s) selected
                            </p>
                            <div class="space-y-2 mb-4">
                                @foreach($modules as $module)
                                    @php($rowVisible = in_array($module->slug, $selectedModules, true))
                                    <div
                                        data-summary-module="{{ $module->slug }}"
                                        class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 {{ $rowVisible ? '' : 'hidden' }}"
                                    >
                                        <span class="text-sm font-medium text-slate-800">{{ $module->name }}</span>
                                        <span class="text-sm text-slate-600">KES {{ number_format((float) $module->base_price, 2) }}</span>
                                    </div>
                                @endforeach
                                <p id="selected-modules-empty" class="text-sm text-slate-500 {{ count($selectedModules) > 0 ? 'hidden' : '' }}">
                                    No module selected yet.
                                </p>
                            </div>
                            <div class="rounded-xl border border-indigo-100 bg-indigo-50 px-4 py-3">
                                <p class="text-xs uppercase tracking-wide font-semibold text-indigo-700">Estimated Monthly Total</p>
                                <p id="selected-module-total" class="text-2xl font-bold text-indigo-900 mt-1">
                                    KES {{ number_format($modules->whereIn('slug', $selectedModules)->sum('base_price'), 2) }}
                                </p>
                            </div>
                        </section>

                        <button type="submit" class="w-full inline-flex justify-center items-center rounded-xl bg-indigo-600 text-white font-semibold py-3 px-4 hover:bg-indigo-700 transition">
                            Finish Onboarding
                        </button>
                        <p class="text-xs text-slate-500 text-center">You can enable/disable modules later from billing settings.</p>
                    </aside>
                </div>

                <div class="mt-6 xl:hidden">
                    <button type="submit" class="w-full inline-flex justify-center items-center rounded-xl bg-indigo-600 text-white font-semibold py-3 px-4 hover:bg-indigo-700 transition">
                        Finish Onboarding
                    </button>
                </div>
            </form>
        </div>
    </div>

    @unless($moduleLocked)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const moduleCheckboxes = Array.from(document.querySelectorAll('.module-checkbox'));
                const schoolSetup = document.getElementById('school-setup');
                const schoolRequiredFields = schoolSetup ? Array.from(schoolSetup.querySelectorAll('[data-required-school]')) : [];
                const selectedCount = document.getElementById('selected-module-count');
                const selectedTotal = document.getElementById('selected-module-total');
                const emptyState = document.getElementById('selected-modules-empty');
                const summaryRows = Array.from(document.querySelectorAll('[data-summary-module]'));

                function refreshSelectionSummary() {
                    const selected = moduleCheckboxes.filter((box) => box.checked);
                    const selectedSlugs = selected.map((box) => box.value);
                    const hasSchool = selectedSlugs.includes('school');
                    const total = selected.reduce((sum, box) => sum + (parseFloat(box.dataset.price || '0') || 0), 0);

                    if (selectedCount) {
                        selectedCount.textContent = String(selected.length);
                    }

                    if (selectedTotal) {
                        selectedTotal.textContent = 'KES ' + total.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });
                    }

                    summaryRows.forEach((row) => {
                        row.classList.toggle('hidden', !selectedSlugs.includes(row.dataset.summaryModule));
                    });

                    if (emptyState) {
                        emptyState.classList.toggle('hidden', selected.length > 0);
                    }

                    if (schoolSetup) {
                        schoolSetup.classList.toggle('hidden', !hasSchool);
                        schoolRequiredFields.forEach((field) => {
                            field.disabled = !hasSchool;
                            field.required = hasSchool;
                        });
                    }
                }

                moduleCheckboxes.forEach((box) => {
                    box.addEventListener('change', refreshSelectionSummary);
                });

                refreshSelectionSummary();
            });
        </script>
    @endunless
</x-app-layout>
