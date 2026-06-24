@extends('layouts.admin')
@section('title', 'Edit User')
@section('header', 'Edit User: ' . $user->full_name)
@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">First Name *</label><input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="w-full px-3 py-2 border rounded-lg" required></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Middle Name</label><input type="text" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Last Name *</label><input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="w-full px-3 py-2 border rounded-lg" required></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Username *</label><input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full px-3 py-2 border rounded-lg" required></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Designation</label><input type="text" name="designation" value="{{ old('designation', $user->designation) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Contact Number</label><input type="text" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}" class="w-full px-3 py-2 border rounded-lg"></div>
        </div>
        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg">Cancel</a>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Update User</button>
        </div>
    </form>
    <hr class="my-6">
    <h3 class="font-bold text-lg mb-4">Reset Password</h3>
    <form method="POST" action="{{ route('admin.users.reset_password', $user->id) }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Your Password (required to confirm)</label>
            <input type="password" name="admin_password" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700" onclick="return confirm('Reset password for this user?')">Reset Password</button>
    </form>
</div>
@endsection
