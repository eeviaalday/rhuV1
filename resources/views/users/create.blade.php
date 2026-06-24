@extends('layouts.admin')
@section('title', 'Add User')
@section('header', 'Add New User')
@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">First Name *</label><input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full px-3 py-2 border rounded-lg" required></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Middle Name</label><input type="text" name="middle_name" value="{{ old('middle_name') }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Last Name *</label><input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full px-3 py-2 border rounded-lg" required></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Username *</label><input type="text" name="username" value="{{ old('username') }}" class="w-full px-3 py-2 border rounded-lg" required></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Temporary Password *</label><input type="text" name="password" value="{{ old('password') }}" class="w-full px-3 py-2 border rounded-lg" required></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Role *</label>
                <select name="role" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="">Select</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Designation</label><input type="text" name="designation" value="{{ old('designation') }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Contact Number</label><input type="text" name="contact_number" value="{{ old('contact_number') }}" class="w-full px-3 py-2 border rounded-lg"></div>
        </div>
        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg">Cancel</a>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Create User</button>
        </div>
    </form>
</div>
@endsection
