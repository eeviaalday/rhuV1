@extends('layouts.admin')
@section('title', 'User Management')
@section('header', 'User Management')
@section('content')
<div class="mb-4 flex justify-end">
    <a href="{{ route('admin.users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">+ Add User</a>
</div>
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50"><th class="text-left py-3 px-4">Full Name</th><th class="text-left py-3 px-4">Username</th><th class="text-left py-3 px-4">Designation</th><th class="text-left py-3 px-4">Role</th><th class="text-left py-3 px-4">Status</th><th class="text-left py-3 px-4">Date Created</th><th class="text-left py-3 px-4">Last Login</th><th class="text-left py-3 px-4">Actions</th></tr></thead>
        <tbody>@forelse($users as $user)
            <tr class="border-t hover:bg-gray-50 {{ auth()->id() == $user->id ? 'bg-green-50' : '' }}">
                <td class="py-3 px-4">{{ $user->full_name }} @if(auth()->id() == $user->id)<span class="text-xs text-green-600">(You)</span>@endif</td>
                <td class="py-3 px-4">{{ $user->username }}</td>
                <td class="py-3 px-4">{{ $user->designation ?? 'N/A' }}</td>
                <td class="py-3 px-4"><span class="px-2 py-1 rounded text-xs {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">{{ ucfirst($user->role) }}</span></td>
                <td class="py-3 px-4">{{ $user->is_active ? 'Active' : 'Inactive' }}</td>
                <td class="py-3 px-4">{{ $user->created_at->format('M d, Y') }}</td>
                <td class="py-3 px-4">{{ $user->last_login ? $user->last_login->format('M d, Y h:i A') : 'Never' }}</td>
                <td class="py-3 px-4">
                    <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:underline mr-2">View</a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                </td>
            </tr>
        @empty<tr><td colspan="8" class="py-4 text-center text-gray-500">No users found</td></tr>@endforelse</tbody>
    </table>
    <div class="p-4">{{ $users->links() }}</div>
</div>
@endsection
