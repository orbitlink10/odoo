<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Tenant Admin: Users</h2></x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h3 class="font-semibold mb-3">Create User</h3>
            <form method="POST" action="{{ route('tenant-admin.users.store') }}" class="grid md:grid-cols-3 gap-3">
                @csrf
                <input name="name" placeholder="Name" class="border rounded p-2" required>
                <input name="email" type="email" placeholder="Email" class="border rounded p-2" required>
                <input name="phone" placeholder="Phone" class="border rounded p-2">
                <input name="password" type="password" placeholder="Password" class="border rounded p-2" required>
                <div class="md:col-span-2 grid md:grid-cols-3 gap-2">
                    @foreach($roles as $role)
                        <label class="border rounded p-2"><input type="checkbox" name="roles[]" value="{{ $role->id }}"> {{ $role->name }}</label>
                    @endforeach
                </div>
                <button class="md:col-span-3 bg-blue-600 text-white px-4 py-2 rounded">Create User</button>
            </form>
        </div>

        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h3 class="font-semibold mb-3">Users</h3>
            <div class="space-y-3">
                @foreach($users as $user)
                    <form method="POST" action="{{ route('tenant-admin.users.update', $user) }}" class="border rounded p-3">
                        @csrf
                        @method('PATCH')
                        <div class="grid md:grid-cols-4 gap-2">
                            <input name="name" value="{{ $user->name }}" class="border rounded p-2">
                            <input name="email" value="{{ $user->email }}" class="border rounded p-2">
                            <input name="phone" value="{{ $user->phone }}" class="border rounded p-2">
                            <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" @checked($user->is_active)> Active</label>
                        </div>
                        <div class="mt-3 grid md:grid-cols-3 gap-2">
                            @foreach($roles as $role)
                                <label class="border rounded p-2"><input type="checkbox" name="roles[]" value="{{ $role->id }}" @checked($user->roles->contains('id', $role->id))> {{ $role->name }}</label>
                            @endforeach
                        </div>
                        <button class="mt-3 bg-blue-600 text-white px-4 py-2 rounded">Update User</button>
                    </form>
                @endforeach
            </div>
            <div class="mt-4">{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layout>
