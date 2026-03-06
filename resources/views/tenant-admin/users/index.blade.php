<x-app-layout>
    @php
        $totalUsers = $users->total();
        $activeUsers = collect($users->items())->where('is_active', true)->count();
        $inactiveUsers = collect($users->items())->where('is_active', false)->count();
        $selectedCreateRoles = collect(old('roles', []))->map(fn ($roleId) => (int) $roleId)->all();
    @endphp

    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] font-bold text-slate-500">Tenant Admin</p>
                <h2 class="mt-1 text-2xl md:text-3xl leading-none font-extrabold tracking-tight text-slate-900">Users & Access</h2>
                <p class="mt-2 text-sm md:text-base text-slate-600">Create team accounts, assign roles, and keep tenant access under control.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center rounded-2xl bg-slate-200 text-slate-700 px-3 py-1.5 text-xs font-semibold">Users: {{ number_format($totalUsers) }}</span>
                <span class="inline-flex items-center rounded-2xl bg-emerald-100 text-emerald-800 px-3 py-1.5 text-xs font-semibold">Active (this page): {{ number_format($activeUsers) }}</span>
                <span class="inline-flex items-center rounded-2xl bg-rose-100 text-rose-800 px-3 py-1.5 text-xs font-semibold">Inactive (this page): {{ number_format($inactiveUsers) }}</span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-[1360px] mx-auto space-y-6">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
                <p class="font-semibold">Please correct the highlighted fields.</p>
                <ul class="mt-1 list-disc pl-5 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="grid xl:grid-cols-[1.35fr_1fr] gap-5">
            <article class="rounded-[26px] border border-[#c8d2de] bg-white p-6 md:p-7 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h3 class="text-xl md:text-2xl leading-none font-extrabold text-slate-900">Create User</h3>
                        <p class="mt-1.5 text-sm text-slate-600">Add a new user and immediately grant the right access roles.</p>
                    </div>
                    <span class="inline-flex rounded-2xl bg-sky-100 text-sky-800 px-3 py-1.5 text-xs font-semibold">Onboarding</span>
                </div>

                <form method="POST" action="{{ route('tenant-admin.users.store') }}" class="mt-5 space-y-5">
                    @csrf

                    <div class="grid md:grid-cols-3 gap-3">
                        <div>
                            <label for="create_name" class="mb-1.5 block text-xs uppercase tracking-wide font-bold text-slate-600">Full Name</label>
                            <input
                                id="create_name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter full name"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-sky-500 focus:ring-sky-500"
                                required
                            >
                        </div>

                        <div>
                            <label for="create_email" class="mb-1.5 block text-xs uppercase tracking-wide font-bold text-slate-600">Email Address</label>
                            <input
                                id="create_email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                placeholder="name@company.com"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-sky-500 focus:ring-sky-500"
                                required
                            >
                        </div>

                        <div>
                            <label for="create_phone" class="mb-1.5 block text-xs uppercase tracking-wide font-bold text-slate-600">Phone Number</label>
                            <input
                                id="create_phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="+254 700 000 000"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-sky-500 focus:ring-sky-500"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="create_password" class="mb-1.5 block text-xs uppercase tracking-wide font-bold text-slate-600">Temporary Password</label>
                        <input
                            id="create_password"
                            name="password"
                            type="password"
                            placeholder="At least 8 characters"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-sky-500 focus:ring-sky-500"
                            required
                        >
                        <p class="mt-1.5 text-xs text-slate-500">The user can change this later from their profile.</p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wide font-bold text-slate-600">Assign Roles</p>
                        <div class="mt-2 grid sm:grid-cols-2 lg:grid-cols-3 gap-2.5">
                            @forelse ($roles as $role)
                                @php($roleInputId = 'create-role-'.$role->id)
                                <label for="{{ $roleInputId }}" class="cursor-pointer">
                                    <input
                                        id="{{ $roleInputId }}"
                                        type="checkbox"
                                        name="roles[]"
                                        value="{{ $role->id }}"
                                        class="peer sr-only"
                                        @checked(in_array($role->id, $selectedCreateRoles, true))
                                    >
                                    <span class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm font-semibold text-slate-700 transition peer-checked:border-sky-300 peer-checked:bg-sky-50 peer-checked:text-sky-800">
                                        <span class="inline-block h-2.5 w-2.5 rounded-full bg-slate-300"></span>
                                        {{ $role->name }}
                                    </span>
                                </label>
                            @empty
                                <p class="sm:col-span-2 lg:col-span-3 rounded-xl border border-amber-200 bg-amber-50 px-3 py-2.5 text-sm text-amber-800">
                                    No roles found. Create roles first to grant permissions.
                                </p>
                            @endforelse
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <p class="text-xs text-slate-500">Users are created in your current tenant only.</p>
                        <button class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-sky-600 to-indigo-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:from-sky-700 hover:to-indigo-700">
                            Create User
                        </button>
                    </div>
                </form>
            </article>

            <article class="rounded-[26px] border border-[#d9dee8] bg-[#ffffff] p-6 md:p-7 shadow-sm">
                <span class="inline-flex items-center rounded-full border border-[#f4c7cb] bg-[#fff5f6] px-3 py-1 text-[11px] font-extrabold uppercase tracking-[0.12em] text-[#b11f2c]">Security Guide</span>
                <h3 class="mt-3 text-xl md:text-2xl leading-none font-extrabold text-[#0f1828]">Access Checklist</h3>
                <p class="mt-2 text-sm text-[#3d4a5f]">Keep role assignments intentional to reduce mistakes and protect tenant data.</p>

                <div class="mt-5 h-1.5 w-14 rounded-full bg-[#e30613]"></div>

                <div class="mt-5 space-y-3 text-sm">
                    <div class="rounded-2xl border border-[#d9dee8] bg-[#f8fafd] p-3">
                        <p class="font-bold text-[#111d2f]">1. Principle of least privilege</p>
                        <p class="mt-1 text-[#3d4a5f]">Assign only the roles needed for daily responsibilities.</p>
                    </div>
                    <div class="rounded-2xl border border-[#d9dee8] bg-[#f8fafd] p-3">
                        <p class="font-bold text-[#111d2f]">2. Use temporary passwords</p>
                        <p class="mt-1 text-[#3d4a5f]">Set a strong temporary password and ask users to rotate it immediately.</p>
                    </div>
                    <div class="rounded-2xl border border-[#d9dee8] bg-[#f8fafd] p-3">
                        <p class="font-bold text-[#111d2f]">3. Disable unused accounts</p>
                        <p class="mt-1 text-[#3d4a5f]">Turn off access for inactive staff while keeping historical records intact.</p>
                    </div>
                </div>

                <div class="mt-5 flex flex-wrap gap-2">
                    <span class="inline-flex rounded-2xl border border-[#d9dee8] bg-[#eef3fb] text-[#1f3658] px-3 py-1.5 text-xs font-semibold">Roles: {{ number_format($roles->count()) }}</span>
                    <span class="inline-flex rounded-2xl border border-[#f4c7cb] bg-[#fff5f6] text-[#b11f2c] px-3 py-1.5 text-xs font-semibold">Review monthly</span>
                </div>
            </article>
        </section>

        <section class="rounded-[26px] border border-[#c8d2de] bg-white p-6 md:p-7 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h3 class="text-xl md:text-2xl leading-none font-extrabold text-slate-900">Tenant Users</h3>
                    <p class="mt-1.5 text-sm text-slate-600">Update profile details, role assignments, and account status.</p>
                </div>
                <span class="inline-flex rounded-2xl bg-slate-100 text-slate-700 px-3 py-1.5 text-xs font-semibold">Page {{ $users->currentPage() }} of {{ $users->lastPage() }}</span>
            </div>

            @if ($users->isEmpty())
                <div class="mt-5 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center">
                    <p class="text-slate-700 font-semibold">No users found for this tenant yet.</p>
                    <p class="mt-1 text-sm text-slate-500">Use the create form above to add the first user account.</p>
                </div>
            @else
                <div class="mt-5 space-y-4">
                    @foreach ($users as $user)
                        <form method="POST" action="{{ route('tenant-admin.users.update', $user) }}" class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 md:p-5 space-y-4">
                            @csrf
                            @method('PATCH')

                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div>
                                    <h4 class="text-base md:text-lg leading-none font-bold text-slate-900">{{ $user->name }}</h4>
                                    <p class="mt-1 text-sm text-slate-600">{{ $user->email }}</p>
                                </div>
                                <span class="inline-flex rounded-2xl px-3 py-1 text-xs font-semibold {{ $user->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div class="grid md:grid-cols-4 gap-3">
                                <div>
                                    <label for="user_{{ $user->id }}_name" class="mb-1.5 block text-xs uppercase tracking-wide font-bold text-slate-600">Name</label>
                                    <input
                                        id="user_{{ $user->id }}_name"
                                        name="name"
                                        value="{{ $user->name }}"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 focus:border-sky-500 focus:ring-sky-500"
                                        required
                                    >
                                </div>

                                <div>
                                    <label for="user_{{ $user->id }}_email" class="mb-1.5 block text-xs uppercase tracking-wide font-bold text-slate-600">Email</label>
                                    <input
                                        id="user_{{ $user->id }}_email"
                                        name="email"
                                        type="email"
                                        value="{{ $user->email }}"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 focus:border-sky-500 focus:ring-sky-500"
                                        required
                                    >
                                </div>

                                <div>
                                    <label for="user_{{ $user->id }}_phone" class="mb-1.5 block text-xs uppercase tracking-wide font-bold text-slate-600">Phone</label>
                                    <input
                                        id="user_{{ $user->id }}_phone"
                                        name="phone"
                                        value="{{ $user->phone }}"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 focus:border-sky-500 focus:ring-sky-500"
                                    >
                                </div>

                                <div class="rounded-xl border border-slate-200 bg-white px-3 py-2.5">
                                    <p class="text-xs uppercase tracking-wide font-bold text-slate-600">Account Status</p>
                                    <input type="hidden" name="is_active" value="0">
                                    <label class="mt-2 inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                                        <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" @checked($user->is_active)>
                                        Active
                                    </label>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wide font-bold text-slate-600">Roles</p>
                                <div class="mt-2 grid sm:grid-cols-2 lg:grid-cols-3 gap-2.5">
                                    @foreach ($roles as $role)
                                        @php($userRoleInputId = 'user-'.$user->id.'-role-'.$role->id)
                                        <label for="{{ $userRoleInputId }}" class="cursor-pointer">
                                            <input
                                                id="{{ $userRoleInputId }}"
                                                type="checkbox"
                                                name="roles[]"
                                                value="{{ $role->id }}"
                                                class="peer sr-only"
                                                @checked($user->roles->contains('id', $role->id))
                                            >
                                            <span class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition peer-checked:border-sky-300 peer-checked:bg-sky-50 peer-checked:text-sky-800">
                                                <span class="inline-block h-2.5 w-2.5 rounded-full bg-slate-300"></span>
                                                {{ $role->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <p class="text-xs text-slate-500">Last updated {{ optional($user->updated_at)->diffForHumans() }}.</p>
                                <button class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-slate-800">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
