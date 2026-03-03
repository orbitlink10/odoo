<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Tenant Admin: Roles</h2></x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h3 class="font-semibold mb-3">Create Role</h3>
            <form method="POST" action="{{ route('tenant-admin.roles.store') }}" class="space-y-3">
                @csrf
                <div class="grid md:grid-cols-2 gap-3">
                    <input name="name" placeholder="Role Name" class="border rounded p-2" required>
                    <input name="slug" placeholder="role-slug" class="border rounded p-2" required>
                </div>
                <div class="grid md:grid-cols-3 gap-2">
                    @foreach($permissions as $permission)
                        <label class="border rounded p-2 text-sm"><input type="checkbox" name="permissions[]" value="{{ $permission->id }}"> {{ $permission->slug }}</label>
                    @endforeach
                </div>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Create Role</button>
            </form>
        </div>

        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h3 class="font-semibold mb-3">Role Permissions</h3>
            <div class="space-y-3">
                @foreach($roles as $role)
                    <form method="POST" action="{{ route('tenant-admin.roles.update', $role) }}" class="border rounded p-3">
                        @csrf
                        @method('PATCH')
                        <p class="font-semibold">{{ $role->name }} ({{ $role->slug }})</p>
                        <div class="mt-2 grid md:grid-cols-3 gap-2">
                            @foreach($permissions as $permission)
                                <label class="border rounded p-2 text-sm"><input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @checked($role->permissions->contains('id', $permission->id))> {{ $permission->slug }}</label>
                            @endforeach
                        </div>
                        <button class="mt-3 bg-blue-600 text-white px-4 py-2 rounded">Update Permissions</button>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
