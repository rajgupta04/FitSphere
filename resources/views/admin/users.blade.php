<x-app-layout>
@section('title', 'Manage Users')
@section('subtitle', 'Admin user management')

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <h3 class="text-lg font-bold"><i class="fas fa-users-cog text-primary-500 mr-2"></i>All Users</h3>
        <form method="GET" action="{{ route('admin.users') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." class="text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 px-4 py-2 w-48">
            <select name="role" class="text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 px-3 py-2" onchange="this.form.submit()">
                <option value="">All Roles</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50"><tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-500 text-xs uppercase">User</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-500 text-xs uppercase">Email</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Role</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Joined</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Actions</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($users as $u)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full gradient-primary flex items-center justify-center text-white text-xs font-bold">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                                <span class="font-medium">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $u->email }}</td>
                        <td class="px-4 py-3 text-center">
                            <form method="POST" action="{{ route('admin.users.update-role', $u) }}" class="inline">@csrf @method('PATCH')
                                <select name="role" onchange="this.form.submit()" class="text-xs rounded-lg border-gray-200 dark:border-gray-600 dark:bg-gray-700 py-1 px-2 {{ $u->role === 'admin' ? 'text-primary-600 bg-primary-50' : '' }}">
                                    <option value="user" {{ $u->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-center text-gray-400 text-xs">{{ $u->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($u->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.delete', $u) }}" onsubmit="return confirm('Delete this user?')">@csrf @method('DELETE')
                                <button class="p-2 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 text-red-400 hover:text-red-600 transition"><i class="fas fa-trash text-xs"></i></button>
                            </form>
                            @else
                            <span class="text-xs text-gray-400">You</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $users->links() }}</div>
    </div>
</div>
</x-app-layout>
