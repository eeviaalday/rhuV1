@extends('layouts.admin')
@section('title', $user->full_name)
@section('header', 'User Details: ' . $user->full_name)
@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-lg">
    <dl class="space-y-3">
        <div class="flex justify-between"><dt class="text-gray-600">Full Name:</dt><dd>{{ $user->full_name }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-600">Username:</dt><dd>{{ $user->username }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-600">Role:</dt><dd><span class="px-2 py-1 rounded text-xs {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">{{ ucfirst($user->role) }}</span></dd></div>
        <div class="flex justify-between"><dt class="text-gray-600">Designation:</dt><dd>{{ $user->designation ?? 'N/A' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-600">Contact:</dt><dd>{{ $user->contact_number ?? 'N/A' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-600">Status:</dt><dd>{{ $user->is_active ? 'Active' : 'Inactive' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-600">Last Login:</dt><dd>{{ $user->last_login ? $user->last_login->format('M d, Y h:i A') : 'Never' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-600">Last Password Change:</dt><dd>{{ $user->last_password_change ? $user->last_password_change->format('M d, Y h:i A') : 'Never' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-600">Created:</dt><dd>{{ $user->created_at->format('M d, Y') }}</dd></div>
    </dl>
    <div class="flex justify-end mt-6">
        <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 mr-2">Edit</a>
        <a href="{{ route('admin.users.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Back</a>
    </div>
</div>
@endsection
